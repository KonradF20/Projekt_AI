@extends('layouts.app')

@section('title', 'Planer Podróży AI')

@section('content')
    <div class="absolute top-0 left-0 w-full h-[600px] z-0 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1764586118417-0ced8a9c6f6d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhbWFsZmklMjBjb2FzdCUyMHN1bnNldCUyMHdhcm0lMjBhZXN0aGV0aWN8ZW58MXx8fHwxNzczMTUyOTA4fDA&ixlib=rb-4.1.0&q=80&w=1080" alt="Beautiful aesthetic coast sunset" class="w-full h-full object-cover object-center opacity-60 mix-blend-multiply">
        <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-[#FCFAF8]/60 to-[#FCFAF8]"></div>
    </div>

    <main class="max-w-[1400px] mx-auto px-6 md:px-12 pb-24 mt-8 space-y-16 relative z-10">

        <div class="text-center mb-8 pt-4">
            <h2 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tighter drop-shadow-sm mb-4">
                Gdzie Cię <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-orange-400">zabierze</span> sztuczna inteligencja?
            </h2>
            <p class="text-lg md:text-xl font-medium text-slate-600 max-w-2xl mx-auto">
                Zaprojektuj idealne wakacje. Od lotów po ukryte perełki, nasz model zaplanuje wszystko za Ciebie.
            </p>
        </div>

        @if(auth()->check() && auth()->user()->isAdmin())

            <div class="flex flex-col items-center justify-center mt-12 bg-white/60 backdrop-blur-md p-10 rounded-[2rem] border border-slate-200 shadow-xl relative z-10">
                <div class="w-16 h-16 bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl flex items-center justify-center text-white shadow-lg mb-6">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2">Tryb Administratora</h3>
                <p class="text-slate-500 font-medium mb-8 text-center">Jesteś zalogowany jako administrator systemu. Wyszukiwarka jest ukryta.</p>
                <a href="{{ url('/admin') }}" class="bg-gradient-to-r from-slate-800 to-slate-900 hover:from-slate-900 hover:to-black text-white font-bold py-4 px-10 rounded-2xl shadow-lg transition-all active:scale-95 text-lg flex items-center gap-2">
                    Przejdź do Panelu Sterowania &rarr;
                </a>
            </div>

        @else
            <form method="POST" action="{{ route('travel.generate') }}" id="search-form" class="bg-white p-4 md:p-6 rounded-[2rem] shadow-[0_20px_40px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col md:flex-row items-center gap-4 relative z-50 w-full">
                @csrf

                <div class="flex-1 w-full relative group z-20">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-1 block">Skąd</label>
                    <select name="origin" id="origin-select" required placeholder="Wpisz miasto lub kod lotniska..." class="w-full"></select>
                </div>

                <div class="flex-1 w-full relative group z-20">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-1 block">Dokąd</label>
                    <select name="destination" id="destination-select" required placeholder="Wpisz miasto lub kod lotniska..." class="w-full"></select>
                </div>

                <div class="flex-1 w-full relative group">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-1 block">Daty podróży</label>
                    <input type="text" id="date-picker" name="dates" placeholder="Wybierz termin" required class="w-full bg-slate-50/50 focus:bg-white border-2 border-transparent focus:border-rose-100 rounded-2xl py-3 px-4 text-slate-800 font-bold outline-none transition-all placeholder:font-medium placeholder:text-slate-400">
                </div>

                <button type="submit" class="w-full md:w-auto h-full min-h-[60px] bg-gradient-to-r from-rose-500 to-orange-400 hover:from-rose-600 hover:to-orange-500 text-white font-black px-10 rounded-2xl shadow-[0_8px_20px_rgb(244,63,94,0.25)] hover:shadow-[0_12px_30px_rgb(244,63,94,0.35)] transition-all active:scale-95 flex items-center justify-center gap-2 mt-5 md:mt-0">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    Szukaj
                </button>
            </form>

            <div id="loader" class="hidden flex-col items-center justify-center py-24 text-center">
                <div class="w-16 h-16 border-4 border-rose-100 border-t-rose-500 rounded-full animate-spin mb-6"></div>
                <h3 class="text-xl font-black text-slate-800 mb-2">AI układa Twój plan...</h3>
                <p class="text-slate-500 font-medium">To może potrwać do 30 sekund. Nie odświeżaj strony!</p>
            </div>

            @if($showResults)
                <div id="results-container">
                    @include('components.travel-results')
                </div>
            @else
                <div id="empty-state" class="flex flex-col items-center justify-center text-center px-4 mt-24 mb-16 relative z-10">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-rose-400 to-orange-400 text-white rounded-[1.5rem] shadow-xl shadow-rose-500/20 mb-8 border border-white/20">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                            <path d="M20 3v4"/>
                            <path d="M22 5h-4"/>
                            <path d="M4 17v2"/>
                            <path d="M5 18H3"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-black text-slate-800 mb-3 tracking-tight">Czekamy na Twoje wskazówki</h3>
                    <p class="text-slate-500 font-medium max-w-md mx-auto leading-relaxed">
                        Wpisz miasto wylotu, cel podróży oraz daty, a sztuczna inteligencja zaprojektuje dla Ciebie idealny plan.
                    </p>
                </div>
            @endif
        @endif
    </main>
@endsection

@section('scripts')
    <script>
        // Skrypt obsługujący ekran ładowania
        const searchForm = document.getElementById('search-form');
        if(searchForm) {
            searchForm.addEventListener('submit', function(e) {
                @guest
                    // BLOKADA: Jeśli użytkownik NIE JEST zalogowany, zatrzymaj wysyłanie!
                    e.preventDefault();
                    openAuthModal('register');

                    // Wstrzykujemy błąd do modala z opóźnieniem animacji okienka
                    setTimeout(() => {
                        const errorDiv = document.getElementById('auth-error-msg');
                        if(errorDiv) {
                            errorDiv.classList.remove('text-emerald-600', 'bg-emerald-50', 'border-emerald-100');
                            errorDiv.classList.add('text-rose-600', 'bg-rose-50', 'border-rose-100');
                            errorDiv.innerText = "Zaloguj się lub załóż darmowe konto, aby sztuczna inteligencja wygenerowała Twój plan!";
                            errorDiv.classList.remove('hidden');
                        }
                    }, 100);
                @else
                    // Jeśli użytkownik JEST zalogowany, pokaż ekran ładowania AI
                    this.classList.add('hidden');
                    const emptyState = document.getElementById('empty-state');
                    if(emptyState) emptyState.classList.add('hidden');
                    const resultsContainer = document.getElementById('results-container');
                    if(resultsContainer) resultsContainer.classList.add('hidden');
                    const loader = document.getElementById('loader');
                    loader.classList.remove('hidden');
                    loader.classList.add('flex');
                @endguest
            });
        }

        // Globalna baza tysięcy lotnisk ładująca się w tle (Tom Select + Algolia JSON)
        document.addEventListener('DOMContentLoaded', function() {
            const tsStyles = document.createElement('link');
            tsStyles.rel = 'stylesheet';
            tsStyles.href = 'https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css';
            document.head.appendChild(tsStyles);

            const tsScript = document.createElement('script');
            tsScript.src = 'https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js';
            tsScript.onload = function() {
                // Pobieramy publiczną bazę lotnisk z GitHuba
                fetch('https://raw.githubusercontent.com/algolia/datasets/master/airports/airports.json')
                    .then(response => response.json())
                    .then(data => {
                        // Filtrujemy tylko lotniska z kodem IATA i przygotowujemy format dla Tom Select
                        const airports = data
                            .filter(airport => airport.iata_code)
                            .map(airport => ({
                                id: airport.iata_code,
                                title: `${airport.city} (${airport.iata_code})`,
                                subtitle: `${airport.name}, ${airport.country}`,
                                search: `${airport.city} ${airport.name} ${airport.iata_code} ${airport.country}`
                            }));

                        const tsConfig = {
                            options: airports,
                            valueField: 'id',
                            labelField: 'title',
                            searchField: ['search'],
                            create: false,
                            maxOptions: 50,
                            placeholder: 'Wpisz miasto lub kod...',
                            render: {
                                option: function(item, escape) {
                                    return `<div>
                                        <span class="font-bold text-slate-800 block">${escape(item.title)}</span>
                                        <span class="text-xs text-slate-500">${escape(item.subtitle)}</span>
                                    </div>`;
                                },
                                item: function(item, escape) {
                                    return `<div><span class="font-bold text-slate-800">${escape(item.title)}</span></div>`;
                                }
                            }
                        };

                        if(document.getElementById("origin-select")) new TomSelect("#origin-select", tsConfig);
                        if(document.getElementById("destination-select")) new TomSelect("#destination-select", tsConfig);

                        // Poprawka stylów, żeby pasowało do Twojego designu
                        setTimeout(() => {
                            document.querySelectorAll('.ts-control').forEach(el => {
                                el.style.border = 'none';
                                el.style.backgroundColor = 'rgba(248, 250, 252, 0.5)';
                                el.style.padding = '0.75rem 1rem';
                                el.style.borderRadius = '1rem';
                                el.style.boxShadow = 'none';
                                el.style.fontSize = '16px';
                            });
                        }, 100);
                    })
                    .catch(error => console.error('Błąd ładowania lotnisk:', error));
            };
            document.head.appendChild(tsScript);
        });

        // Logika osi czasu (Dni)
        function switchDay(dayNum) {
            // Ukryj wszystkie sekcje z dniami
            document.querySelectorAll('.day-content').forEach(el => {
                el.classList.add('hidden');
                el.classList.remove('block');
            });

            // Zresetuj wszystkie przyciski (zakładki) do stanu NIEAKTYWNEGO
            document.querySelectorAll('.tab-btn').forEach(btn => {
                // Tutaj są zaktualizowane, powiększone klasy px-6 py-4
                btn.className = 'tab-btn shrink-0 flex items-center gap-3 px-6 py-4 rounded-2xl font-bold transition-all border-2 bg-white/50 border-transparent text-slate-500 hover:bg-white hover:shadow-sm';
                let icon = btn.querySelector('.tab-icon');
                if(icon) icon.className = 'w-10 h-10 shrink-0 rounded-full flex items-center justify-center text-base bg-slate-100 text-slate-500 tab-icon transition-colors';
            });

            // Pokaż wybraną sekcję z dniem
            let selectedDay = document.getElementById('day-' + dayNum);
            if(selectedDay) {
                selectedDay.classList.remove('hidden');
                selectedDay.classList.add('block');
            }

            // Ustaw kliknięty przycisk w stan AKTYWNY
            let selectedBtn = document.getElementById('tab-btn-' + dayNum);
            if(selectedBtn) {
                selectedBtn.className = 'tab-btn shrink-0 flex items-center gap-3 px-6 py-4 rounded-2xl font-bold transition-all border-2 bg-white border-rose-200 text-rose-600 shadow-md';
                let icon = selectedBtn.querySelector('.tab-icon');
                if(icon) icon.className = 'w-10 h-10 shrink-0 rounded-full flex items-center justify-center text-base bg-rose-100 text-rose-600 tab-icon transition-colors';
            }
        }

        // Logika pakowania bagażu
        function togglePack(button) {
            const isPacked = button.classList.contains('packed');
            const checkBox = button.querySelector('.check-box');
            const checkIcon = button.querySelector('.check-icon');
            const itemText = button.querySelector('.item-text');

            if (isPacked) {
                button.classList.remove('packed');
                button.className = "pack-item w-full text-left flex items-center gap-4 p-4 rounded-2xl transition-all duration-200 border bg-white border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)]";
                checkBox.className = "check-box shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center border-slate-300 bg-transparent transition-colors";
                itemText.className = "item-text font-semibold text-base text-slate-700 transition-colors";
                checkIcon.classList.add('hidden');
            } else {
                button.classList.add('packed');
                button.className = "pack-item packed w-full text-left flex items-center gap-4 p-4 rounded-2xl transition-all duration-200 border bg-slate-50 border-slate-200/50 opacity-60";
                checkBox.className = "check-box shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center bg-emerald-500 border-emerald-500 text-white transition-colors";
                itemText.className = "item-text font-semibold text-base text-slate-400 line-through transition-colors";
                checkIcon.classList.remove('hidden');
            }
            updateProgress();
        }

        function updateProgress() {
            const totalItems = 17;
            const packedItems = document.querySelectorAll('.pack-item.packed').length;
            const percentage = Math.round((packedItems / totalItems) * 100);

            const progressText = document.getElementById('progress-text');
            const progressBar = document.getElementById('progress-bar');
            const packedCount = document.getElementById('packed-count');

            if(progressText) progressText.innerText = percentage + '%';
            if(progressBar) progressBar.style.width = percentage + '%';
            if(packedCount) packedCount.innerText = packedItems;

            document.querySelectorAll('.category-group').forEach(group => {
                const totalCat = group.querySelectorAll('.pack-item').length;
                const packedCat = group.querySelectorAll('.pack-item.packed').length;
                const counter = group.querySelector('.cat-counter');
                if(counter) counter.innerText = packedCat + ' / ' + totalCat;
            });
        }

        @if(session('show_login'))
            openAuthModal('login');
        @endif

        // Inicjalizacja kalendarza
        document.addEventListener('DOMContentLoaded', function() {
            const script = document.createElement('script');
            script.src = "https://cdn.jsdelivr.net/npm/flatpickr";
            script.onload = function() {
                const langScript = document.createElement('script');
                langScript.src = "https://npmcdn.com/flatpickr/dist/l10n/pl.js";
                langScript.onload = function() {
                    if(document.getElementById("date-picker")) {
                        flatpickr("#date-picker", {
                            mode: "range",
                            minDate: "today",
                            dateFormat: "d.m.Y",
                            locale: "pl",
                            showMonths: window.innerWidth > 768 ? 1 : 1
                        });
                    }
                };
                document.head.appendChild(langScript);
            };
            document.head.appendChild(script);
        });
    </script>
@endsection
