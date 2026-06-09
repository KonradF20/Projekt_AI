<div id="auth-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" onclick="closeAuthModal()"></div>

        <div id="auth-modal-content" class="relative w-full max-w-4xl bg-white rounded-[2.5rem] shadow-[0_20px_60px_rgb(0,0,0,0.1)] overflow-hidden flex flex-col md:flex-row z-10 transform scale-95 transition-transform duration-300">
            <button onclick="closeAuthModal()" class="absolute top-4 right-4 md:top-6 md:right-6 w-10 h-10 bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 rounded-full flex items-center justify-center transition-colors z-20">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>

            <div class="hidden md:block w-5/12 relative bg-slate-100 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1713286634189-2b0c5573fecd?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxob3QlMjBhaXIlMjBiYWxsb29uJTIwY2FwcGFkb2NpYSUyMHN1bnNldCUyMGFlc3RoZXRpY3xlbnwxfHx8fDE3NzMxNTU0MzB8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Cappadocia" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-rose-900/80 via-rose-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 text-white">
                    <div class="bg-white/20 backdrop-blur-md p-3 rounded-2xl inline-block mb-4 border border-white/30">
                        <svg class="w-6 h-6 text-rose-100" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/></svg>
                    </div>
                    <h3 class="text-2xl font-black mb-2">Rozpocznij przygodę</h3>
                    <p class="text-rose-100 font-medium text-sm leading-relaxed">
                        Zaloguj się, aby zapisywać wygenerowane plany, synchronizować je między urządzeniami i zapraszać znajomych do wspólnego planowania.
                    </p>
                </div>
            </div>

            <div class="w-full md:w-7/12 p-8 md:p-12 lg:p-16 flex flex-col justify-center bg-white relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-rose-50 rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

                <div class="relative z-10 max-w-md mx-auto w-full">
                    <div class="mb-8">
                        <h2 id="auth-title" class="text-3xl font-black text-slate-900 tracking-tight mb-2">Witaj ponownie!</h2>
                        <p id="auth-desc" class="text-slate-500 font-medium">Wprowadź swoje dane, aby uzyskać dostęp do planów.</p>
                    </div>

                    <form id="auth-form" method="POST" action="{{ route('login.post') }}" class="space-y-4">
                        @csrf

                        <div id="auth-error-msg" class="hidden p-3 text-sm text-rose-600 bg-rose-50 rounded-xl font-bold text-center border border-rose-100 transition-all"></div>

                        <div id="auth-name-wrapper" class="overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
                            <div class="space-y-2 pb-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-2">Imię i nazwisko</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-rose-500 transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
                                    </div>
                                    <input name="name" type="text" placeholder="Jan Kowalski" class="w-full bg-slate-50 border border-transparent focus:bg-white focus:border-rose-300 focus:ring-4 focus:ring-rose-500/10 rounded-2xl py-3.5 pl-12 pr-4 text-slate-900 font-medium transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-2">Adres E-mail</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-rose-500 transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                </div>
                                <input name="email" type="email" placeholder="twoj@email.com" class="w-full bg-slate-50 border border-transparent focus:bg-white focus:border-rose-300 focus:ring-4 focus:ring-rose-500/10 rounded-2xl py-3.5 pl-12 pr-4 text-slate-900 font-medium transition-all outline-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between ml-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Hasło</label>
                                <button type="button" id="auth-forgot-pwd" onclick="showForgotPasswordMsg()" class="text-xs font-bold text-rose-500 hover:text-rose-600 transition-colors">Zapomniałeś hasła?</button>
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-rose-500 transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </div>
                                <input name="password" type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-transparent focus:bg-white focus:border-rose-300 focus:ring-4 focus:ring-rose-500/10 rounded-2xl py-3.5 pl-12 pr-4 text-slate-900 font-medium transition-all outline-none">
                            </div>
                        </div>

                        <button type="submit" id="auth-submit-btn" class="w-full bg-gradient-to-r from-rose-500 to-orange-400 hover:from-rose-600 hover:to-orange-500 active:scale-[0.98] text-white font-black rounded-2xl py-4 px-6 flex items-center justify-center gap-2 transition-all shadow-[0_8px_20px_rgb(244,63,94,0.25)] hover:shadow-[0_12px_30px_rgb(244,63,94,0.35)] mt-6">
                            <span>Zaloguj się</span>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </button>
                    </form>

                    <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                        <p class="text-slate-500 font-medium">
                            <span id="auth-switch-text">Nie masz jeszcze konta?</span>
                            <button onclick="toggleAuthMode()" id="auth-switch-btn" class="ml-2 font-bold text-rose-500 hover:text-rose-600 transition-colors">
                                Zarejestruj się
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let currentAuthMode = 'login';

    function openAuthModal(mode = 'login') {
        const modal = document.getElementById('auth-modal');
        const modalContent = document.getElementById('auth-modal-content');

        if(currentAuthMode !== mode) {
            toggleAuthMode();
        }

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeAuthModal() {
        const modal = document.getElementById('auth-modal');
        const modalContent = document.getElementById('auth-modal-content');
        const form = document.getElementById('auth-form');

        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            form.reset();
            document.getElementById('auth-error-msg').classList.add('hidden');
        }, 300);
    }

    function toggleAuthMode() {
        currentAuthMode = currentAuthMode === 'login' ? 'register' : 'login';

        const title = document.getElementById('auth-title');
        const desc = document.getElementById('auth-desc');
        const nameWrapper = document.getElementById('auth-name-wrapper');
        const forgotPwd = document.getElementById('auth-forgot-pwd');
        const submitBtn = document.querySelector('#auth-submit-btn span');
        const switchText = document.getElementById('auth-switch-text');
        const switchBtn = document.getElementById('auth-switch-btn');

        const authForm = document.getElementById('auth-form');
        const errorDiv = document.getElementById('auth-error-msg');

        // Wyczyszczenie komunikatu o błędzie przy przełączaniu
        errorDiv.classList.add('hidden');
        errorDiv.innerText = '';

        if (currentAuthMode === 'register') {
            title.innerText = 'Utwórz konto';
            desc.innerText = 'Dołącz do nas i planuj podróże z pomocą AI.';

            // Płynne wysunięcie pola Imię
            nameWrapper.classList.remove('max-h-0', 'opacity-0');
            nameWrapper.classList.add('max-h-[100px]', 'opacity-100');

            forgotPwd.classList.add('hidden');
            submitBtn.innerText = 'Utwórz konto';

            switchText.innerText = 'Masz już konto?';
            switchBtn.innerText = 'Zaloguj się';

            authForm.action = "{{ route('register.post') }}";
        } else {
            title.innerText = 'Witaj ponownie!';
            desc.innerText = 'Wprowadź swoje dane, aby uzyskać dostęp do planów.';

            // Płynne wsunięcie pola Imię
            nameWrapper.classList.remove('max-h-[100px]', 'opacity-100');
            nameWrapper.classList.add('max-h-0', 'opacity-0');

            forgotPwd.classList.remove('hidden');
            submitBtn.innerText = 'Zaloguj się';

            switchText.innerText = 'Nie masz jeszcze konta?';
            switchBtn.innerText = 'Zarejestruj się';

            authForm.action = "{{ route('login.post') }}";
        }
    }

    function showForgotPasswordMsg() {
        const errorDiv = document.getElementById('auth-error-msg');
        errorDiv.innerText = 'W celu zresetowania hasła skontaktuj się z administratorem pod adresem: kontakt@twojastrona.pl';
        errorDiv.classList.remove('hidden');
    }

    document.getElementById('auth-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const errorDiv = document.getElementById('auth-error-msg');

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                // Wyświetlamy błąd wewnątrz modala
                errorDiv.innerText = data.message;
                errorDiv.classList.remove('hidden');
            }
        });
    });
</script>
