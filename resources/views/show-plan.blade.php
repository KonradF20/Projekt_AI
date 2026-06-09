@extends('layouts.app')

@section('title', $plan->title . ' - Planer Podróży AI')

@section('content')
    <div class="pt-24 pb-12 min-h-screen relative z-10">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12">

            <a href="{{ route('my-plans') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-rose-500 font-bold mb-8 transition-colors bg-white/80 backdrop-blur-sm px-5 py-3 rounded-xl border border-slate-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Wróć do moich planów
            </a>

            @include('components.travel-results')

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function switchDay(dayNum) {
            // 1. Ukryj wszystkie sekcje z dniami
            document.querySelectorAll('.day-content').forEach(el => {
                el.classList.add('hidden');
                el.classList.remove('block');
            });

            // 2. Zresetuj wszystkie przyciski (zakładki) do stanu NIEAKTYWNEGO
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = 'tab-btn shrink-0 flex items-center gap-3 px-6 py-4 rounded-2xl font-bold transition-all border-2 bg-white/50 border-transparent text-slate-500 hover:bg-white hover:shadow-sm';
                let icon = btn.querySelector('.tab-icon');
                if(icon) icon.className = 'w-10 h-10 shrink-0 rounded-full flex items-center justify-center text-base bg-slate-100 text-slate-500 tab-icon transition-colors';
            });

            // 3. Pokaż wybraną sekcję z dniem
            let selectedDay = document.getElementById('day-' + dayNum);
            if(selectedDay) {
                selectedDay.classList.remove('hidden');
                selectedDay.classList.add('block');
            }

            // 4. Ustaw kliknięty przycisk w stan AKTYWNY (z kolorem)
            let selectedBtn = document.getElementById('tab-btn-' + dayNum);
            if(selectedBtn) {
                selectedBtn.className = 'tab-btn shrink-0 flex items-center gap-3 px-6 py-4 rounded-2xl font-bold transition-all border-2 bg-white border-rose-200 text-rose-600 shadow-md';
                let icon = selectedBtn.querySelector('.tab-icon');
                if(icon) icon.className = 'w-10 h-10 shrink-0 rounded-full flex items-center justify-center text-base bg-rose-100 text-rose-600 tab-icon transition-colors';
            }
        }
    </script>
@endsection
