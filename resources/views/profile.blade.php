@extends('layouts.simple')

@section('title', 'Ustawienia konta')

@section('content')
<div class="absolute top-0 left-0 w-full h-[600px] z-0 overflow-hidden pointer-events-none">
    <img src="https://images.unsplash.com/photo-1764586118417-0ced8a9c6f6d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhbWFsZmklMjBjb2FzdCUyMHN1bnNldCUyMHdhcm0lMjBhZXN0aGV0aWN8ZW58MXx8fHwxNzczMTUyOTA4fDA&ixlib=rb-4.1.0&q=80&w=1080" alt="Beautiful aesthetic coast sunset" class="w-full h-full object-cover object-center opacity-60 mix-blend-multiply">
    <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-[#FCFAF8]/80 to-[#FCFAF8]"></div>
</div>

<div class="max-w-xl w-full mx-auto px-6 py-24 relative z-10">
    <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-[0_20px_40px_rgb(0,0,0,0.04)] border border-slate-100 relative z-10">

        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-900">Twój Profil</h2>
                <p class="text-sm font-medium text-slate-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 p-4 rounded-2xl mb-6 font-bold flex items-center gap-3">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-5">
            @csrf

            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-1 block">Obecne hasło</label>
                <input type="password" name="current_password" required class="w-full bg-slate-50 border-2 border-transparent focus:bg-white focus:border-rose-100 rounded-2xl py-3 px-4 text-slate-800 font-bold outline-none transition-all">
                @error('current_password') <span class="text-rose-500 text-sm font-bold ml-4 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-1 block">Nowe hasło</label>
                <input type="password" name="password" required class="w-full bg-slate-50 border-2 border-transparent focus:bg-white focus:border-rose-100 rounded-2xl py-3 px-4 text-slate-800 font-bold outline-none transition-all">
                @error('password') <span class="text-rose-500 text-sm font-bold ml-4 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-1 block">Powtórz nowe hasło</label>
                <input type="password" name="password_confirmation" required class="w-full bg-slate-50 border-2 border-transparent focus:bg-white focus:border-rose-100 rounded-2xl py-3 px-4 text-slate-800 font-bold outline-none transition-all">
            </div>

            <button type="submit" class="w-full mt-2 bg-gradient-to-r from-rose-500 to-orange-400 hover:from-rose-600 hover:to-orange-500 text-white font-black py-4 rounded-2xl shadow-lg transition-all active:scale-95">
                Zaktualizuj hasło
            </button>
        </form>
    </div>
</div>
@endsection
