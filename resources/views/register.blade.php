<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Crear Cuenta | Glosy</title>
    
    <link rel="icon" href="/public/img/logo_glosy.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-bg': '#FFF5F8',
                        'brand-dark': '#5C0A43',
                        'brand-primary': '#AB3E86',
                        'brand-accent': '#FFD1E6',
                    },
                    fontFamily: {
                        'sans': ['"Plus Jakarta Sans"', 'sans-serif'],
                        'serif': ['"Playfair Display"', 'serif'],
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-bg text-slate-800 antialiased min-h-[100dvh] flex flex-col items-center justify-center relative overflow-x-hidden px-4 py-8">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-0 -left-10 w-96 h-96 bg-brand-accent rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 -right-10 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </div>

    <a href="/" class="mb-6 hover:opacity-80 transition active:scale-95">
        <img src="/public/img/logo_glosy.png" alt="Glosy" class="h-20 w-auto object-contain drop-shadow-sm">
    </a>

    <div class="relative w-full max-w-lg bg-white/90 backdrop-blur-xl border border-pink-100 rounded-[2.5rem] shadow-2xl shadow-pink-500/10 p-6 md:p-10 overflow-hidden">
        
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-brand-primary/10 to-transparent rounded-bl-[100%] -z-10"></div>

        <div class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-serif font-bold text-brand-dark flex items-center justify-center gap-2">
                Comienza Gratis 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </h1>
            <p class="text-slate-500 mt-2 font-medium text-sm">Configura tu sal&oacute;n digital en segundos</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-500 p-4 rounded-2xl text-sm mb-6 animate-pulse flex gap-3 items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <ul class="list-disc pl-2 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-brand-dark uppercase tracking-wider ml-2">Tu Nombre</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-pink-300 group-focus-within:text-brand-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" class="w-full pl-10 pr-4 py-3 bg-pink-50/50 border-2 border-pink-50/80 rounded-xl text-sm focus:bg-white focus:border-brand-primary/50 outline-none transition-all text-brand-dark font-medium" placeholder="Ej: Ana" required>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-brand-dark uppercase tracking-wider ml-2">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-pink-300 group-focus-within:text-brand-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" class="w-full pl-10 pr-4 py-3 bg-pink-50/50 border-2 border-pink-50/80 rounded-xl text-sm focus:bg-white focus:border-brand-primary/50 outline-none transition-all text-brand-dark font-medium" placeholder="ana@mail.com" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-brand-dark uppercase tracking-wider ml-2">Contrase&ntilde;a</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-pink-300 group-focus-within:text-brand-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="passwordInput" class="w-full pl-10 pr-10 py-3 bg-pink-50/50 border-2 border-pink-50/80 rounded-xl text-sm focus:bg-white focus:border-brand-primary/50 outline-none transition-all text-brand-dark font-medium tracking-wider" placeholder="••••••••" required minlength="6">
                        
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-pink-300 hover:text-brand-primary transition-colors focus:outline-none">
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="relative flex py-2 items-center">
                <div class="flex-grow border-t border-pink-100"></div>
                <span class="flex-shrink-0 mx-4 text-pink-300 text-[10px] font-bold uppercase tracking-widest">Tu Negocio</span>
                <div class="flex-grow border-t border-pink-100"></div>
            </div>

            <div class="space-y-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-brand-dark uppercase tracking-wider ml-2">Nombre de tu Sal&oacute;n</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-pink-300 group-focus-within:text-brand-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <input type="text" name="nombre_negocio" class="w-full pl-10 pr-4 py-3 bg-pink-50/50 border-2 border-pink-50/80 rounded-xl text-sm focus:bg-white focus:border-brand-primary/50 outline-none transition-all text-brand-dark font-medium" placeholder="Ej: Ana Nails & Spa" required>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-brand-dark uppercase tracking-wider ml-2">Link de tu Agenda</label>
                    <div class="flex items-stretch rounded-xl overflow-hidden border-2 border-pink-50/80 focus-within:border-brand-primary/50 transition-colors">
                        <div class="bg-pink-50 px-3 flex items-center border-r border-pink-100 text-pink-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <span class="text-xs font-bold text-brand-primary">glosy.com.mx/</span>
                        </div>
                        <input type="text" name="slug" class="w-full px-4 py-3 bg-white text-sm outline-none text-brand-dark font-medium placeholder:font-normal" placeholder="ananails" required>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1 ml-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                        Sin espacios. Solo letras y n&uacute;meros.
                    </p>
                </div>
            </div>
            
            <div class="flex items-start gap-3 mt-4 ml-1">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 border border-pink-200 rounded text-brand-primary focus:ring-brand-primary/50 focus:ring-offset-0 bg-pink-50/50 cursor-pointer">
                </div>
                <label for="terms" class="text-xs font-medium text-slate-500">
                    Acepto la <a href="{{ route('privacy') }}" target="_blank" class="text-brand-primary underline hover:text-brand-dark">Pol&iacute;tica de Privacidad</a> y los T&eacute;rminos de Uso de Glosy.
                </label>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-brand-primary to-brand-dark text-white font-bold py-4 rounded-2xl shadow-xl shadow-pink-500/30 hover:shadow-pink-500/50 hover:scale-[1.02] active:scale-95 transition-all transform flex justify-center items-center gap-2 group text-base mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                Crear mi Sal&oacute;n
            </button>
        </form>

        <div class="mt-8 text-center border-t border-pink-100 pt-6">
            <p class="text-slate-500 font-medium text-sm">
                &iquest;Ya tienes cuenta? 
                <a href="{{ route('login') }}" class="text-brand-primary font-bold hover:text-brand-dark transition inline-flex items-center gap-1 group">
                    Entra aqu&iacute;
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </p>
        </div>
    </div>

    <p class="mt-8 text-xs text-slate-500 font-medium opacity-70 pb-4">© 2025 Glosy by Rodnix Agency.</p>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>