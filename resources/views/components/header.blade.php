<header class="sticky top-0 z-50 backdrop-blur-md bg-white/70 border-b border-slate-100/80">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12 h-20 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div class="bg-gradient-to-br from-rose-400 to-orange-400 text-white p-2.5 rounded-2xl shadow-lg shadow-rose-500/20 group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/></svg>
            </div>
            <span class="font-black text-xl tracking-tight text-slate-800">Planer Podróży <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-orange-400">AI</span></span>
        </a>

        <div class="flex items-center gap-4 md:gap-8">

            @guest
                <button onclick="requireLoginForPlans()" class="text-sm font-bold text-slate-600 hover:text-rose-500 transition-colors">
                    Moje Plany
                </button>

                <div class="flex items-center gap-3">
                    <button onclick="openAuthModal('login')" class="bg-white/80 hover:bg-white text-slate-700 font-bold px-5 py-2.5 rounded-xl border border-slate-200 shadow-sm transition-all text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
                        Zaloguj się
                    </button>
                    <button onclick="openAuthModal('register')" class="hidden sm:flex bg-slate-900 hover:bg-rose-500 text-white font-bold px-5 py-2.5 rounded-xl shadow-md transition-all text-sm items-center gap-2">
                        Załóż konto
                    </button>
                </div>
            @endguest

            @auth
                {{-- SPRAWDZAMY CZY ZALOGOWANY JEST ADMIN --}}
                @if(auth()->user()->isAdmin())
                    <a href="{{ url('/admin') }}" class="text-sm font-bold text-slate-600 hover:text-orange-500 transition-colors">
                        Panel Admina
                    </a>
                @else
                    <a href="{{ route('my-plans') }}" class="text-sm font-bold text-slate-600 hover:text-rose-500 transition-colors">
                        Moje Plany
                    </a>
                @endif

                <div class="flex items-center gap-4 border-l border-slate-200 pl-4 md:pl-6">
                    <div class="flex flex-col text-right hidden sm:flex">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Użytkownik</span>
                        <span class="text-sm font-black text-slate-800">{{ Auth::user()->name }}</span>
                    </div>

                @if(!auth()->user()->isAdmin())
                    <a href="{{ route('profile.edit') }}" class="bg-slate-100 hover:bg-rose-50 text-slate-500 hover:text-rose-600 p-2.5 rounded-xl transition-all" title="Ustawienia konta">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                @endif

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="bg-slate-100 hover:bg-rose-50 text-slate-500 hover:text-rose-600 p-2.5 rounded-xl transition-all" title="Wyloguj się">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        </button>
                    </form>
                </div>
            @endauth

        </div>
    </div>
</header>

<script>
    function requireLoginForPlans() {
        // Otwieramy modal na zakładce logowania
        openAuthModal('login');

        // Wstrzykujemy błąd
        setTimeout(() => {
            const errorDiv = document.getElementById('auth-error-msg');
            if(errorDiv) {
                errorDiv.classList.remove('text-emerald-600', 'bg-emerald-50', 'border-emerald-100');
                errorDiv.classList.add('text-rose-600', 'bg-rose-50', 'border-rose-100');

                errorDiv.innerText = "Zaloguj się żeby zobaczyć swoje plany.";
                errorDiv.classList.remove('hidden');
            }
        }, 100);
    }
</script>
