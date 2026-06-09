@extends('layouts.app')

@section('title', 'Moje Plany - Planer Podróży AI')

@section('content')
    <div class="absolute top-0 left-0 w-full h-[600px] z-0 overflow-hidden pointer-events-none">
        <img src="https://images.unsplash.com/photo-1764586118417-0ced8a9c6f6d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhbWFsZmklMjBjb2FzdCUyMHN1bnNldCUyMHdhcm0lMjBhZXN0aGV0aWN8ZW58MXx8fHwxNzczMTUyOTA4fDA&ixlib=rb-4.1.0&q=80&w=1080" alt="Beautiful aesthetic coast sunset" class="w-full h-full object-cover object-center opacity-60 mix-blend-multiply">
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-[#FCFAF8]/80 to-[#FCFAF8]"></div>
    </div>

    <div class="w-full min-h-[calc(100vh-200px)] pt-12 relative z-10">
        <main class="max-w-[1400px] mx-auto px-6 md:px-12 pb-24">

            <div class="mb-12">
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter drop-shadow-sm mb-4">
                    Twoje <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-orange-400">Plany Podróży</span>
                </h2>
                <p class="text-lg font-medium text-slate-600 max-w-2xl">
                    Przeglądaj, edytuj i wracaj do swoich wcześniej wygenerowanych planów.
                </p>
            </div>

            @if(session('success'))
                <div id="success-alert" class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 font-bold flex items-center gap-3 shadow-sm transition-all duration-500">
                    <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <a href="{{ route('home') }}" class="group h-full bg-slate-50/50 rounded-[2rem] border-2 border-dashed border-slate-200 hover:border-rose-300 hover:bg-rose-50/30 transition-all duration-300 flex flex-col items-center justify-center min-h-[400px] text-center p-8 cursor-pointer">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-rose-500 group-hover:scale-110 transition-all duration-300 mb-6">
                        <span class="text-3xl font-light leading-none">+</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-2 group-hover:text-rose-600 transition-colors">Utwórz nowy plan</h3>
                    <p class="text-slate-500 font-medium text-sm max-w-[200px]">Kliknij tutaj, aby wygenerować kolejną podróż z AI.</p>
                </a>

                @if(isset($plans) && $plans->count() > 0)
                    @foreach($plans as $plan)
                        <div class="group relative bg-white rounded-[2rem] shadow-[0_8px_40px_rgb(0,0,0,0.03)] border border-slate-100 hover:shadow-[0_20px_60px_rgb(0,0,0,0.08)] transition-all duration-500 flex flex-col h-full overflow-hidden">

                            <div class="relative h-48 w-full shrink-0 overflow-hidden bg-slate-100">

                                @php
                                    $imageSrc = 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&q=80&w=1080';

                                    if (!empty($plan->image)) {
                                        if (str_starts_with($plan->image, 'http://') || str_starts_with($plan->image, 'https://')) {
                                            $imageSrc = $plan->image;
                                        } else {
                                            $imageSrc = asset('storage/' . $plan->image);
                                        }
                                    }
                                @endphp

                                <img src="{{ $imageSrc }}" alt="{{ $plan->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/30"></div>

                                <button onclick="deletePlan(this, {{ $plan->id }})" class="absolute top-4 right-4 w-9 h-9 flex items-center justify-center bg-white/20 hover:bg-red-500 text-white backdrop-blur-md rounded-full transition-all z-10 border border-white/30" title="Usuń plan">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </div>

                            <div class="p-6 md:p-8 flex flex-col flex-1">
                                <h2 class="text-2xl font-black text-slate-900 mb-2 line-clamp-2 group-hover:text-rose-600 transition-colors">{{ $plan->title }}</h2>
                                <p class="text-sm font-bold text-slate-500 mb-6 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ $plan->destination }} • {{ $plan->dates }}
                                </p>

                                <div class="mt-auto space-y-3 pt-6 border-t border-slate-50">
                                    @if(isset($plan->flight_data) && !empty($plan->flight_data))
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="font-bold text-slate-400 flex items-center gap-1.5 uppercase tracking-wider text-[11px]">
                                                <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.6L2.5 8l6.4 3.9L7 16l-3.2-.8c-.3-.1-.6 0-.8.2L2 17l4 2 2 4 .9-1c.2-.2.3-.5.2-.8L8 18l4.1-1.9 3.9 6.4 1.2-1.2c.4-.2.7-.6.6-1.1z"/></svg>
                                                Najtańszy Lot
                                            </span>
                                            <span class="font-black text-slate-800">{{ $plan->flight_data['price'] ?? '???' }} PLN</span>
                                        </div>
                                    @endif

                                    @if(isset($plan->hotel_data) && !empty($plan->hotel_data))
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="font-bold text-slate-400 flex items-center gap-1.5 uppercase tracking-wider text-[11px]">
                                                <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v20"/><path d="M21 2v20"/><path d="M3 10h18"/><path d="M10 2v20"/><path d="M14 2v20"/></svg>
                                                Hotel ({{ $plan->hotel_data['nights'] ?? 1 }} noce)
                                            </span>
                                            <span class="font-black text-slate-800">{{ $plan->hotel_data['price'] ?? '???' }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto pt-6">
                                    <a href="{{ route('show-plan', $plan->id) }}" class="block text-center w-full bg-slate-50 hover:bg-rose-50 text-slate-700 hover:text-rose-600 font-black py-3.5 rounded-xl transition-colors border border-slate-200 hover:border-rose-200">
                                        Zobacz pełny plan
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </main>
    </div>

    <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300" id="delete-modal-content">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-6 mx-auto shadow-inner border border-red-100">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-900 mb-2 text-center">Usuń plan</h3>
            <p class="text-slate-500 font-medium text-center mb-8">Czy na pewno chcesz bezpowrotnie usunąć ten plan podróży? Tej operacji nie można cofnąć.</p>
            <div class="flex gap-4">
                <button onclick="cancelDelete()" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold py-3.5 rounded-xl transition-colors border border-slate-200">
                    Anuluj
                </button>
                <button onclick="confirmDelete()" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md">
                    Tak, usuń
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Zmienne do zapamiętania, który plan użytkownik chce usunąć
        let currentPlanId = null;
        let currentButton = null;

        // Automatyczne ukrywanie alertu sukcesu po 5 sekundach
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    // Najpierw płynnie wyzeruj przezroczystość
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';

                    // Po zakończeniu animacji (500ms) całkowicie usuń element ze strony
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000); // 5000 milisekund = 5 sekund
            }
        });

        function deletePlan(button, planId) {
            currentPlanId = planId;
            currentButton = button;

            const modal = document.getElementById('delete-modal');
            const modalContent = document.getElementById('delete-modal-content');

            // Pokaż modal i odpal animację
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        }

        function cancelDelete() {
            const modal = document.getElementById('delete-modal');
            const modalContent = document.getElementById('delete-modal-content');

            // Ukryj modal z animacją
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                currentPlanId = null;
                currentButton = null;
            }, 300);
        }

        function confirmDelete() {
            if(!currentPlanId || !currentButton) return;

            const card = currentButton.closest('.group');

            // Od razu ukrywamy modal
            cancelDelete();

            // Wysyłamy żądanie do bazy
            fetch(`/moje-plany/${currentPlanId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(response.ok) {
                    // Odpalamy animację zanikania kafelka
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        card.remove();
                    }, 300);
                } else {
                    // Awaryjny komunikat błędu
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-xl font-bold shadow-lg z-50';
                    errorMsg.innerText = 'Nie udało się usunąć planu.';
                    document.body.appendChild(errorMsg);
                    setTimeout(() => errorMsg.remove(), 3000);
                }
            })
            .catch(error => console.error('Błąd:', error));
        }
    </script>
@endsection
