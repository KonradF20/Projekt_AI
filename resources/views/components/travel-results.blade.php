<div class="space-y-12 mt-8 relative z-10" id="results-content">
    @if(!isset($isSaved) || !$isSaved)
        @if(isset($aiData) || isset($flight) || isset($hotel))
            <div class="flex justify-end mb-6">
                <form action="{{ route('save-plan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $aiData['title'] ?? 'Mój wyjazd' }}">
                    <input type="hidden" name="destination" value="{{ $aiData['city'] ?? $searchData['destination'] ?? '' }}">
                    <input type="hidden" name="dates" value="{{ $searchData['dates'] ?? '' }}">
                    <input type="hidden" name="days" value="{{ json_encode($aiData['days'] ?? []) }}">
                    <input type="hidden" name="flight_data" value="{{ json_encode($flight ?? null) }}">
                    <input type="hidden" name="hotel_data" value="{{ json_encode($hotel ?? null) }}">

                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-black py-3 px-6 rounded-2xl shadow-md transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Zapisz plan do profilu
                    </button>
                </form>
            </div>
        @endif
    @endif

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4 items-stretch">

        @if(isset($flight))
            <a href="{{ $flight['link'] ?? 'https://www.google.com/travel/flights' }}" target="_blank" class="bg-white rounded-[2rem] overflow-hidden shadow-[0_8px_40px_rgb(0,0,0,0.03)] border border-slate-100/80 group hover:shadow-[0_20px_60px_rgb(0,0,0,0.08)] transition-all duration-500 flex flex-col h-full min-w-0 cursor-pointer">
                <div class="relative h-60 w-full shrink-0 overflow-hidden bg-sky-900">
                    <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&q=80&w=1080" alt="Widok lotu" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out opacity-95">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-black/0"></div>
                    <div class="absolute top-5 left-5 bg-white/95 backdrop-blur-md px-4 py-2 rounded-full text-xs font-black text-slate-800 tracking-wider uppercase flex items-center gap-2 shadow-sm border border-white/50">
                        <svg class="w-4 h-4 text-rose-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.6L2.5 8l6.4 3.9L7 16l-3.2-.8c-.3-.1-.6 0-.8.2L2 17l4 2 2 4 .9-1c.2-.2.3-.5.2-.8L8 18l4.1-1.9 3.9 6.4 1.2-1.2c.4-.2.7-.6.6-1.1z"/></svg>
                        Google Flights
                    </div>
                </div>
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-8">
                        <div class="flex items-center gap-4 min-w-0">
                            @if(isset($flight['airline_logo']))
                                <div class="w-14 h-14 shrink-0 rounded-2xl bg-white border border-slate-100 flex items-center justify-center shadow-sm overflow-hidden p-2">
                                    <img src="{{ $flight['airline_logo'] }}" alt="Logo" class="max-w-full max-h-full object-contain">
                                </div>
                            @else
                                <div class="w-14 h-14 shrink-0 rounded-2xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center shadow-inner">
                                    <span class="font-black text-lg tracking-tighter">{{ substr($flight['airline'] ?? 'LOT', 0, 3) }}</span>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1 truncate">{{ $flight['airline'] ?? 'Linia lotnicza' }}</p>
                                <p class="text-xl font-bold text-slate-900 truncate">{{ $flight['flight_number'] ?? 'Brak nr' }}</p>
                                <p class="text-sm font-semibold flex items-center gap-1.5 truncate text-rose-500 group-hover:text-rose-600 transition-colors mt-1">
                                    <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                    Sprawdź i rezerwuj
                                </p>
                            </div>
                        </div>
                        <div class="text-right shrink-0 pl-4">
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Cena od</p>
                            <p class="text-3xl font-black text-rose-500">{{ $flight['price'] ?? '???' }} PLN</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between relative mt-auto pt-6 before:absolute before:top-[65%] before:left-0 before:w-full before:h-px before:bg-slate-200 before:border-dashed before:border-b-[3px] before:z-0">
                        <div class="bg-white pr-3 md:pr-5 z-10 shrink-0">
                            <p class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">{{ $flight['departure_time'] ?? '--:--' }}</p>
                            <p class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-wider" title="{{ $flight['departure_name'] ?? '' }}">{{ $flight['departure_id'] ?? '???' }}</p>
                        </div>
                        <div class="bg-white px-2 z-10 flex flex-col items-center shrink-0">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-rose-50 text-rose-500 border border-rose-100 flex items-center justify-center mb-1 shadow-sm relative group-hover:-translate-y-1 transition-transform">
                                <svg class="w-5 h-5 md:w-6 md:h-6 fill-rose-500/20" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.6L2.5 8l6.4 3.9L7 16l-3.2-.8c-.3-.1-.6 0-.8.2L2 17l4 2 2 4 .9-1c.2-.2.3-.5.2-.8L8 18l4.1-1.9 3.9 6.4 1.2-1.2c.4-.2.7-.6.6-1.1z"/></svg>
                            </div>
                            <p class="text-[10px] md:text-[11px] font-bold text-slate-500 flex items-center gap-1.5 uppercase tracking-wider bg-white whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $flight['duration_text'] ?? 'Bezpośredni' }}
                            </p>
                            @if(isset($flight['stops']) && $flight['stops'] > 0)
                                <p class="text-[9px] md:text-[10px] font-bold text-rose-500 mt-0.5 uppercase tracking-wider bg-white px-1">{{ $flight['stops_text'] ?? '' }}</p>
                            @endif
                        </div>
                        <div class="bg-white pl-3 md:pl-5 z-10 text-right shrink-0">
                            <p class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">{{ $flight['arrival_time'] ?? '--:--' }}</p>
                            <p class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-wider" title="{{ $flight['arrival_name'] ?? '' }}">{{ $flight['arrival_id'] ?? '???' }}</p>
                        </div>
                    </div>
                </div>
            </a>
        @else
            <div class="bg-white rounded-[2rem] p-8 shadow-[0_8px_40px_rgb(0,0,0,0.03)] border border-slate-100 flex flex-col items-center justify-center text-center h-full min-w-0">
                <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-[1.5rem] flex items-center justify-center mb-6 shadow-sm">
                    <svg class="w-10 h-10 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.29 7 12 12 20.71 7"></polyline>
                        <line x1="12" y1="22" x2="12" y2="12"></line>
                        <line x1="9" y1="12" x2="15" y2="12"></line>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3">Brak lotów dla tej trasy</h3>
                <p class="text-sm font-medium text-slate-500 max-w-[250px] leading-relaxed">
                    W wybranym terminie nie odnaleźliśmy połączeń lotniczych między tymi miastami. Spróbuj zmienić datę lub lotnisko.
                </p>
            </div>
        @endif

        @if(isset($hotel))
            <a href="{{ $hotel['link'] ?? '#' }}" target="_blank" class="bg-white rounded-[2rem] overflow-hidden shadow-[0_8px_40px_rgb(0,0,0,0.03)] border border-slate-100/80 group hover:shadow-[0_20px_60px_rgb(0,0,0,0.08)] transition-all duration-500 flex flex-col h-full min-w-0 cursor-pointer">
                <div class="relative h-60 w-full shrink-0 overflow-hidden bg-slate-100">
                    <img src="{{ $hotel['image'] }}" alt="Pokój Hotelowy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-transparent h-24"></div>
                    <div class="absolute top-5 left-5 bg-white/95 backdrop-blur-md px-4 py-2 rounded-full text-xs font-black text-slate-800 tracking-wider uppercase flex items-center gap-2 shadow-sm border border-white/50">
                        <svg class="w-4 h-4 text-amber-500 fill-amber-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        Google Hotels
                    </div>
                </div>
                <div class="p-8 flex flex-col flex-1">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="font-black text-lg text-slate-800">{{ number_format((float)$hotel['rating'], 1, '.', '') }}</span>
                            <div class="flex gap-0.5">
                                @php $rating = round($hotel['rating']); @endphp
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 {{ $i < $rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200 fill-slate-200' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                @endfor
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-2 truncate" title="{{ $hotel['name'] }}">{{ $hotel['name'] }}</h3>
                        <p class="text-sm font-semibold text-slate-500 flex items-center gap-2 truncate text-rose-500 group-hover:text-rose-600 transition-colors">
                            <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                            Sprawdź pełną ofertę i zdjęcia
                        </p>
                    </div>
                    <div class="mt-auto flex justify-between items-end border-t-2 border-slate-50 pt-6">
                        <div>
                            <p class="text-sm font-bold text-slate-500 mb-1">Szacunkowo za pobyt</p>
                            @php $n = $hotel['nights']; @endphp
                            <p class="text-xs font-bold text-slate-400">2 dorosłych, {{ $n }} {{ $n == 1 ? 'noc' : ($n < 5 ? 'noce' : 'nocy') }}</p>
                        </div>
                        <p class="text-3xl font-black text-rose-500 whitespace-nowrap">{{ $hotel['price'] }}</p>
                    </div>
                </div>
            </a>
        @else
            <div class="bg-white rounded-[2rem] p-8 shadow-[0_8px_40px_rgb(0,0,0,0.03)] border border-slate-100 flex flex-col items-center justify-center text-center h-full min-w-0">
                <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-[1.5rem] flex items-center justify-center mb-6 shadow-sm">
                    <svg class="w-10 h-10 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 2v20"></path><path d="M21 2v20"></path><path d="M3 10h18"></path><path d="M10 2v20"></path><path d="M14 2v20"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3">Brak dostępnych hoteli</h3>
                <p class="text-sm font-medium text-slate-500 max-w-[250px] leading-relaxed">
                    W wybranym terminie nie odnaleźliśmy ofert hotelowych w tym mieście.
                </p>
            </div>
        @endif

    </section>

    @if(isset($aiData) && isset($aiData['days']))
        <section class="bg-slate-50/50 rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-slate-100/80 mt-12 overflow-hidden flex flex-col">

            <div class="relative h-64 md:h-80 w-full overflow-hidden shrink-0">
                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&q=80&w=1080" alt="Podróż" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 flex items-center gap-5">
                    <div class="bg-white/20 border border-white/30 p-4 rounded-2xl text-white shadow-xl backdrop-blur-md">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tight drop-shadow-md">{{ $aiData['title'] ?? 'Twój inteligentny plan' }}</h2>
                        <p class="text-base font-medium text-slate-200 mt-1.5 drop-shadow-sm">{{ count($aiData['days']) }} dni • Zoptymalizowane przez AI</p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-12">

                <div class="flex overflow-x-auto gap-3 md:gap-4 mb-8 pb-4">
                    @foreach($aiData['days'] as $index => $day)
                        @php
                            $dayNum = $index + 1;
                            $cleanTitle = trim(preg_replace('/^Dzień\s*\d+[:\-\.]?\s*/iu', '', $day['title'] ?? ''));
                            $displayTitle = $cleanTitle ? 'Dzień ' . $dayNum . ': ' . $cleanTitle : 'Dzień ' . $dayNum;
                        @endphp

                        <button onclick="switchDay({{ $dayNum }})" id="tab-btn-{{ $dayNum }}"
                            class="tab-btn shrink-0 flex items-center gap-3 px-6 py-4 rounded-2xl font-bold transition-all border-2
                            {{ $dayNum === 1 ? 'bg-white border-rose-200 text-rose-600 shadow-md' : 'bg-white/50 border-transparent text-slate-500 hover:bg-white hover:shadow-sm' }}">

                            <div class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center text-base {{ $dayNum === 1 ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-500' }} tab-icon transition-colors">
                                {{ $dayNum }}
                            </div>

                            <span class="whitespace-nowrap text-base">{{ $displayTitle }}</span>

                        </button>
                    @endforeach
                </div>

                <div class="relative min-h-[400px]">
                    @foreach($aiData['days'] as $index => $day)
                        @php $dayNum = $index + 1; @endphp
                        <div id="day-{{ $dayNum }}" class="day-content space-y-6 {{ $dayNum === 1 ? 'block' : 'hidden' }}">

                            @if(isset($day['activities']) && is_array($day['activities']))
                                @foreach($day['activities'] as $actIndex => $activity)
                                    @php
                                        $styles = [
                                            ['bg' => 'bg-rose-100', 'text' => 'text-rose-600'],
                                            ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
                                            ['bg' => 'bg-amber-100', 'text' => 'text-amber-600'],
                                        ];
                                        $style = $styles[$actIndex % 3];
                                    @endphp

                                    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100/60 flex flex-col md:flex-row gap-6 group hover:border-rose-100 transition-colors">
                                        <div class="flex md:flex-col items-center md:items-start gap-4 md:w-56 md:border-r border-slate-100 md:pr-6">
                                            <div class="p-4 rounded-2xl {{ $style['bg'] }} {{ $style['text'] }} group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-900 text-lg">{{ $activity['time'] ?? 'Brak czasu' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex-1 flex flex-col justify-center">
                                            <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-rose-600 transition-colors">{{ $activity['title'] ?? 'Atrakcja' }}</h4>
                                            <p class="text-slate-600 font-medium">{{ $activity['description'] ?? 'Brak opisu' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-slate-500 font-medium p-6">Brak zaplanowanych aktywności na ten dzień.</p>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <div class="bg-red-50 text-red-600 p-8 rounded-3xl mt-12 border border-red-100 text-center shadow-sm">
            <h3 class="text-xl font-black mb-2 flex items-center justify-center gap-2">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                Ups! Sztuczna inteligencja się pogubiła.
            </h3>
            <p class="font-medium opacity-80">AI nie zwróciło danych w odpowiednim formacie. Spróbuj kliknąć "Szukaj" jeszcze raz!</p>
        </div>
    @endif
</div>
