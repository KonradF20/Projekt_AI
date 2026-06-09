<?php

namespace App\Http\Controllers;

use App\Models\TravelPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\GenerateTravelRequest;
use App\Http\Requests\StoreTravelPlanRequest;

class TravelController extends Controller
{
    public function generate(GenerateTravelRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route('home')->with('show_register', true);
        }

        ini_set('max_execution_time', 120);

        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $dates = $request->input('dates');

        // 1. OBLICZANIE DŁUGOŚCI WYJAZDU Z KALENDARZA
        $datesString = str_replace(' do ', ' to ', $dates);
        $datesArray = explode(' to ', $datesString);
        $numberOfDays = 1;

        if (count($datesArray) > 1) {
            $start = \DateTime::createFromFormat('d.m.Y', trim($datesArray[0]));
            $end = \DateTime::createFromFormat('d.m.Y', trim($datesArray[1]));
            if ($start && $end) {
                // Różnica dat w dniach + 1 (aby uwzględnić dzień przylotu)
                $numberOfDays = $start->diff($end)->days + 1;
            }
        }

        // Zabezpieczenie przed ucięciem kodu JSON: ograniczamy maksymalny plan do 10 dni
        $aiDaysLimit = $numberOfDays > 10 ? 10 : $numberOfDays;

        $prompt = "Jesteś profesjonalnym ekspertem ds. podróży. Użytkownik podał 3-literowe kody IATA lotnisk. Kod lotniska wylotu: '{$origin}', kod lotniska docelowego: '{$destination}'. Termin: {$dates}.

        WYMOGI:
        1. ROZSZYFRUJ KOD: Rozszyfruj kod IATA celu podróży ({$destination}) na czystą nazwę miasta (np. 'CIA' to Rzym). Zapisz tę czystą nazwę w polu JSON 'city'. Ułóż plan wycieczki DOKŁADNIE dla tego miasta.
        2. DŁUGOŚĆ PLANU: Ułóż szczegółowy plan na dokładnie {$aiDaysLimit} dni.
        3. SZCZEGÓŁOWOŚĆ: Na każdy dzień zaplanuj 6 różnorodnych aktywności. Wypełnij czas od rana do późnego wieczora. Uwzględnij przerwy na jedzenie.
        4. Bądź w 100% zgodny z rzeczywistością. Atrakcje i restauracje muszą znajdować się w docelowym mieście.
        5. Używaj wyłącznie pięknej, poprawnej polszczyzny.

        Zwróć wynik formacie JSON, dokładnie według tego wzoru:
        {
            \"title\": \"Wymyśl krótki, chwytliwy tytuł wycieczki do [Rozszyfrowane Miasto]\",
            \"city\": \"[Sama Rozszyfrowana Nazwa Miasta]\",
            \"days\": [
                {
                    \"day\": 1,
                    \"title\": \"Tytuł dnia\",
                    \"activities\": [
                        {
                            \"time\": \"09:00 - 11:30\",
                            \"title\": \"Prawdziwa nazwa atrakcji\",
                            \"description\": \"Krótki, wciągający opis po polsku.\"
                        }
                    ]
                }
            ]
        }";

        try {
            $response = Http::withoutVerifying()
                ->withToken(env('GROQ_API_KEY'))
                ->timeout(60)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Jesteś asystentem zwracającym TYLKO poprawny kod JSON.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'response_format' => ['type' => 'json_object'],
                    'temperature' => 0.3
                ]);

            if ($response->successful()) {
                $aiText = $response->json('choices.0.message.content');
                $aiData = json_decode($aiText, true);
            } else {
                $aiData = null;
            }

        } catch (\Exception $e) {
            $aiData = null;
        }

        // POBIERANIE LOTÓW Z OBRÓBKĄ DANYCH
        $flight = $this->getFlightData($origin, $destination, $dates);

        // POBIERANIE HOTELU NA BAZIE MIASTA Z AI
        $cityName = $aiData['city'] ?? $destination;
        $hotel = $this->getHotelData($cityName, $dates);

        return view('welcome', [
            'showResults' => true,
            'searchData' => $request->all(),
            'aiData' => $aiData,
            'flight' => $flight,
            'hotel' => $hotel
        ]);
    }

    private function getFlightData($origin, $destination, $dates)
    {
        $dates = str_replace(' do ', ' to ', $dates);
        $datesArray = explode(' to ', $dates);

        try {
            $parsedOutbound = \DateTime::createFromFormat('d.m.Y', trim($datesArray[0]));

            if (!$parsedOutbound) {
                return null;
            }

            $outboundDate = $parsedOutbound->format('Y-m-d');

            $params = [
                'engine' => 'google_flights',
                'departure_id' => $origin,
                'arrival_id' => $destination,
                'outbound_date' => $outboundDate,
                'api_key' => env('SERPAPI_KEY'),
                'hl' => 'pl',
                'currency' => 'PLN'
            ];

            if (count($datesArray) > 1) {
                $parsedReturn = \DateTime::createFromFormat('d.m.Y', trim($datesArray[1]));
                if ($parsedReturn) {
                    $params['return_date'] = $parsedReturn->format('Y-m-d');
                    $params['type'] = '1';
                } else {
                    $params['type'] = '2';
                }
            } else {
                $params['type'] = '2';
            }

            $response = Http::withoutVerifying()->get('https://serpapi.com/search', $params);

            // Wyciągamy link do rezerwacji Google Flights
            $googleFlightsUrl = $response->json('search_metadata.google_flights_url') ?? 'https://www.google.com/travel/flights';
            $rawFlight = $response->json('best_flights.0') ?? $response->json('other_flights.0') ?? null;

            if (!$rawFlight || !isset($rawFlight['flights'])) {
                return null;
            }

            // OBRÓBKA DANYCH LOTU Z BLADE DO KONTROLERA
            $flights = $rawFlight['flights'];
            $lastFlightIndex = count($flights) - 1;
            $firstFlight = $flights[0];
            $lastFlight = $flights[$lastFlightIndex];

            $depTime = isset($firstFlight['departure_airport']['time'])
                ? \Carbon\Carbon::parse($firstFlight['departure_airport']['time'])->format('H:i') : '--:--';
            $arrTime = isset($lastFlight['arrival_airport']['time'])
                ? \Carbon\Carbon::parse($lastFlight['arrival_airport']['time'])->format('H:i') : '--:--';

            $durationMins = $rawFlight['total_duration'] ?? 0;
            $hours = floor($durationMins / 60);
            $mins = $durationMins % 60;
            $durationText = $durationMins > 0 ? "{$hours}h {$mins}m" : 'Bezpośredni';

            $stops = count($flights) - 1;
            $stopsText = $stops > 0 ? ($stops == 1 ? '1 przesiadka' : "{$stops} przesiadki") : 'Bez przesiadek';

            // Zwracamy czystą, przetworzoną paczkę dla widoku
            return [
                'price' => $rawFlight['price'] ?? '???',
                'airline' => $firstFlight['airline'] ?? 'Linia lotnicza',
                'airline_logo' => $firstFlight['airline_logo'] ?? $rawFlight['airline_logo'] ?? null,
                'flight_number' => $firstFlight['flight_number'] ?? 'Brak nr',
                'departure_time' => $depTime,
                'departure_id' => $firstFlight['departure_airport']['id'] ?? '???',
                'departure_name' => $firstFlight['departure_airport']['name'] ?? '',
                'arrival_time' => $arrTime,
                'arrival_id' => $lastFlight['arrival_airport']['id'] ?? '???',
                'arrival_name' => $lastFlight['arrival_airport']['name'] ?? '',
                'duration_text' => $durationText,
                'stops' => $stops,
                'stops_text' => $stopsText,
                'link' => $googleFlightsUrl
            ];

        } catch (\Exception $e) {
            return null;
        }
    }

    // FUNKCJA DO POBIERANIA PRAWDZIWYCH HOTELI
    private function getHotelData($cityName, $dates)
    {
        $dates = str_replace(' do ', ' to ', $dates);
        $datesArray = explode(' to ', $dates);

        try {
            $parsedCheckIn = \DateTime::createFromFormat('d.m.Y', trim($datesArray[0]));
            if (!$parsedCheckIn) return null;
            $checkInDate = $parsedCheckIn->format('Y-m-d');

            if (count($datesArray) > 1) {
                $parsedCheckOut = \DateTime::createFromFormat('d.m.Y', trim($datesArray[1]));
                $checkOutDate = $parsedCheckOut ? $parsedCheckOut->format('Y-m-d') : null;
            } else {
                $checkOutDate = clone $parsedCheckIn;
                $checkOutDate->modify('+3 days');
                $checkOutDate = $checkOutDate->format('Y-m-d');
            }

            $response = Http::withoutVerifying()->get('https://serpapi.com/search', [
                'engine' => 'google_hotels',
                'q' => $cityName,
                'check_in_date' => $checkInDate,
                'check_out_date' => $checkOutDate,
                'currency' => 'PLN',
                'hl' => 'pl',
                'api_key' => env('SERPAPI_KEY')
            ]);

            $properties = $response->json('properties');
            if (!$properties || count($properties) == 0) return null;

            $hotel = $properties[0];

            $nights = (new \DateTime($checkInDate))->diff(new \DateTime($checkOutDate))->days;
            $nights = max(1, $nights);

            $price = $hotel['total_rate']['lowest'] ?? $hotel['rate_per_night']['lowest'] ?? 'Sprawdź cenę';

            return [
                'name' => $hotel['name'] ?? 'Nieznany hotel',
                'price' => $price,
                'rating' => $hotel['overall_rating'] ?? 4.0,
                'image' => $hotel['images'][0]['original_image'] ?? $hotel['images'][0]['thumbnail'] ?? 'https://images.unsplash.com/photo-1601371339865-97612837fd8a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080',
                'link' => $hotel['link'] ?? 'https://www.google.com/travel/hotels?q=' . urlencode($cityName),
                'nights' => $nights
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function savePlan(StoreTravelPlanRequest $request)
    {
        $hotelData = json_decode($request->input('hotel_data'), true);

        $image = $hotelData['image'] ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&q=80&w=1080';

        \App\Models\TravelPlan::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'title' => $request->input('title'),
            'destination' => $request->input('destination'),
            'dates' => $request->input('dates'),
            'days' => json_decode($request->input('days'), true),
            'flight_data' => json_decode($request->input('flight_data'), true),
            'hotel_data' => $hotelData,
            'image' => $image,
        ]);

        return redirect()->route('my-plans')->with('success', 'Plan został pomyślnie zapisany!');
    }

    public function myPlans()
    {
        // Pobieramy plany tylko dla aktualnie zalogowanego użytkownika
        $plans = TravelPlan::where('user_id', Auth::id())->latest()->get();
        return view('my-plans', compact('plans'));
    }

    public function destroyPlan($id)
    {
        // Szukamy planu po ID, upewniając się, że należy do zalogowanego użytkownika
        $plan = \App\Models\TravelPlan::where('user_id', \Illuminate\Support\Facades\Auth::id())->findOrFail($id);

        // Fizycznie usuwamy z bazy
        $plan->delete();

        // Zwracamy odpowiedź JSON dla naszego skryptu w widoku
        return response()->json(['success' => true]);
    }

    public function showPlan($id)
    {
        // Pobieramy plan z bazy (tylko jeśli należy do zalogowanego użytkownika)
        $plan = \App\Models\TravelPlan::where('user_id', \Illuminate\Support\Facades\Auth::id())->findOrFail($id);

        // Rekonstruujemy tablice do formatu, jakiego oczekuje Twój widok wyników
        $aiData = [
            'title' => $plan->title,
            'city' => $plan->destination,
            'days' => $plan->days,
        ];

        $flight = $plan->flight_data;
        $hotel = $plan->hotel_data;

        $searchData = [
            'destination' => $plan->destination,
            'dates' => $plan->dates,
        ];

        // Zmienna, która posłuży nam do ukrycia przycisku "Zapisz plan", skoro już jesteśmy w zapisanych
        $isSaved = true;

        return view('show-plan', compact('aiData', 'flight', 'hotel', 'searchData', 'isSaved', 'plan'));
    }
}
