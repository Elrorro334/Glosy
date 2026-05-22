<!DOCTYPE html>
<html lang="es-MX" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    
    <title>Glosy | Software y Agenda para Salones de Belleza</title>
    <meta name="description" content="Automatiza tu salón con Glosy: Agenda citas 24/7.">
    <meta name="author" content="Rodnix Digital Agency">
    
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
                        'brand-light': '#FCE7F3',
                    },
                    fontFamily: {
                        'sans': ['"Plus Jakarta Sans"', 'sans-serif'],
                        'serif': ['"Playfair Display"', 'serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'blob': 'blob 7s infinite',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'sway': 'sway 3s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        sway: {
                            '0%': { transform: 'rotate(-5deg)' },
                            '100%': { transform: 'rotate(5deg)' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Estilos Base */
        body { overflow-x: hidden; }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
        .text-gradient {
            background: linear-gradient(135deg, #5C0A43 0%, #AB3E86 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Efecto Sakura (Lluvia de flores) */
        .sakura-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .petal {
            position: absolute;
            background-color: #FFD1E6;
            border-radius: 150% 0 150% 0;
            animation: fall linear infinite;
        }
        @keyframes fall {
            0% { opacity: 0; top: -10%; transform: translateX(0) rotate(0deg); }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { opacity: 0; top: 110%; transform: translateX(20px) rotate(360deg); }
        }

        /* Scrollbar Personalizado */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #FFF5F8; }
        ::-webkit-scrollbar-thumb { background: #AB3E86; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #5C0A43; }
    </style>
</head>
<body class="bg-brand-bg text-slate-800 antialiased relative selection:bg-brand-accent selection:text-brand-dark">

    <div id="sakura-container" class="sakura-container"></div>

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-0 -left-10 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob"></div>
        <div class="absolute top-40 right-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-20 left-20 w-72 h-72 bg-brand-accent rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-blob animation-delay-4000"></div>
    </div>

    <header>
        <nav class="fixed w-full z-50 transition-all duration-300 top-0 left-0 glass h-20 flex items-center shadow-sm">
            <div class="w-full max-w-7xl mx-auto px-6 flex justify-between items-center">
                
                <a href="/" class="flex items-center gap-2 hover:opacity-80 transition active:scale-95" aria-label="Ir al inicio">
                    <img src="/public/img/logo_glosy.png" alt="Logo de Glosy" class="h-10 md:h-12 w-auto object-contain">
                </a>
                
                <div class="hidden md:flex gap-4 items-center">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-brand-dark hover:text-brand-primary hover:bg-pink-50/50 px-5 py-2.5 rounded-full transition duration-300">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}" class="group px-6 py-2.5 text-sm font-bold bg-brand-primary text-white rounded-full shadow-lg shadow-pink-500/20 hover:shadow-pink-500/40 hover:bg-brand-dark transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <span>Empezar Gratis</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <button id="menu-btn" class="md:hidden text-brand-dark p-2 rounded-lg hover:bg-pink-50 transition" aria-label="Abrir menú">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <div id="menu-backdrop" class="fixed inset-0 bg-slate-900/60 z-[60] hidden transition-opacity opacity-0 backdrop-blur-sm" onclick="toggleMenu()"></div>
    <aside id="mobile-menu" class="fixed top-0 right-0 w-[85%] max-w-xs h-full bg-white z-[70] transform translate-x-full transition-transform duration-500 cubic-bezier(0.4, 0, 0.2, 1) shadow-2xl flex flex-col">
        <div class="p-6 flex justify-between items-center border-b border-pink-50">
            <span class="font-serif font-bold text-2xl text-brand-dark">Menú</span>
            <button onclick="toggleMenu()" class="p-2 text-slate-400 hover:text-brand-primary transition rounded-full hover:bg-pink-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="p-6 flex flex-col gap-6">
            <a href="/" class="flex items-center gap-4 text-lg font-medium text-slate-600 hover:text-brand-primary transition">
                <span class="p-2 bg-pink-50 rounded-lg text-brand-primary"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></span>
                Inicio
            </a>
            <a href="#features" class="flex items-center gap-4 text-lg font-medium text-slate-600 hover:text-brand-primary transition">
                <span class="p-2 bg-pink-50 rounded-lg text-brand-primary"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg></span>
                Beneficios
            </a>
            <hr class="border-pink-100">
            <div class="space-y-4">
                <a href="{{ route('login') }}" class="flex w-full items-center justify-center py-3 rounded-xl border-2 border-brand-primary text-brand-primary font-bold hover:bg-pink-50 transition">
                    Soy Dueña
                </a>
                <a href="{{ route('login.cliente') }}" class="flex w-full items-center justify-center py-3 text-sm text-slate-500 font-medium hover:text-brand-primary transition">
                    Soy Clienta (Mis citas)
                </a>
                <a href="{{ route('register') }}" class="flex w-full items-center justify-center py-4 rounded-xl bg-brand-primary text-white font-bold shadow-xl shadow-pink-500/30 hover:bg-brand-dark transition">
                    ¡Empezar Gratis!
                </a>
            </div>
        </nav>
    </aside>

    <main class="pt-32 pb-20 px-6 max-w-7xl mx-auto">
        <section class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20 relative z-10">
            
            <div class="lg:w-1/2 space-y-8 text-center lg:text-left animate-fade-in">
                
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md rounded-full border border-pink-200 shadow-sm mx-auto lg:mx-0 hover:shadow-md transition cursor-default">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pink-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-brand-primary"></span>
                    </span>
                    <span class="text-xs font-bold text-brand-dark uppercase tracking-wider">Nuevo en Jilotepec</span>
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-serif font-bold leading-[1.1] text-slate-900 tracking-tight">
                    Tu agenda llena, <br>
                    <span class="text-gradient italic relative">
                        sin estrés.
                        <svg class="absolute -bottom-2 w-full h-3 text-brand-primary opacity-30" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="3" fill="none"/></svg>
                    </span>
                </h1>
                
                <p class="text-lg text-slate-600 leading-relaxed max-w-lg mx-auto lg:mx-0">
                    Deja de responder mensajes a medianoche. <b>Glosy</b> es el asistente inteligente que gestiona citas, recordatorios y clientas por ti, las 24 horas.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-2">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-brand-primary text-white rounded-2xl font-bold text-lg shadow-xl shadow-pink-500/30 hover:bg-brand-dark hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                        Crear mi Salón
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="pt-6 flex items-center justify-center lg:justify-start gap-4 text-sm text-slate-500 font-medium">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-200 bg-[url('https://i.pravatar.cc/100?img=1')] bg-cover"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-200 bg-[url('https://i.pravatar.cc/100?img=5')] bg-cover"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-200 bg-[url('https://i.pravatar.cc/100?img=9')] bg-cover"></div>
                    </div>
                    <div>
                        <p class="text-slate-800 font-bold">Confianza Rodnix</p>
                        <div class="flex text-yellow-400 gap-0.5">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 flex justify-center w-full relative">
                <div class="relative animate-float">
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 w-48 h-8 bg-brand-dark/20 blur-2xl rounded-full"></div>
                    
                    <div class="w-[300px] h-[600px] bg-slate-900 rounded-[3rem] p-3 shadow-2xl border-[6px] border-slate-800 relative overflow-hidden ring-1 ring-white/20">
                        <div class="absolute top-28 -right-2 w-1 h-16 bg-slate-800 rounded-r-md"></div>
                        <div class="absolute top-28 -left-2 w-1 h-10 bg-slate-800 rounded-l-md"></div>

                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-28 h-7 bg-black rounded-b-xl z-20"></div>
                        
                        <div class="w-full h-full bg-white rounded-[2.2rem] overflow-hidden flex flex-col relative">
                            <div class="h-44 bg-gradient-to-br from-[#5C0A43] to-[#AB3E86] p-6 pt-12 text-white relative">
                                <div class="flex justify-between items-center mb-6">
                                    <div class="w-10 h-10 bg-white/10 rounded-full backdrop-blur-md flex items-center justify-center border border-white/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"></path></svg>
                                    </div>
                                    <div class="w-10 h-10 rounded-full border border-white/30 bg-[url('https://i.pravatar.cc/150?img=32')] bg-cover"></div>
                                </div>
                                <h3 class="text-2xl font-serif tracking-wide">Hola, Lety</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    <p class="text-pink-100 text-xs font-medium">Agenda activa hoy</p>
                                </div>
                            </div>

                            <div class="flex-1 bg-slate-50 -mt-8 rounded-t-[2rem] p-5 space-y-4 overflow-hidden relative z-10">
                                <div class="flex justify-between items-end mb-2 px-1">
                                    <h4 class="font-bold text-slate-700 text-sm">Próximas Citas</h4>
                                    <span class="text-[11px] text-brand-primary font-bold cursor-pointer hover:underline">Ver calendario</span>
                                </div>
                                
                                <div class="bg-white p-4 rounded-2xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.1)] border border-pink-50/50 flex gap-4 items-center transform transition hover:scale-[1.02]">
                                    <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-pink-50 text-brand-primary">
                                        <span class="text-[10px] font-bold uppercase">Hoy</span>
                                        <span class="text-sm font-bold">10:00</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-slate-800 text-sm">María López</p>
                                        <p class="text-[11px] text-slate-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Gelish Liso • 60 min
                                        </p>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </div>

                                <div class="bg-white p-4 rounded-2xl shadow-[0_4px_20px_-10px_rgba(0,0,0,0.1)] border border-pink-50/50 flex gap-4 items-center opacity-70">
                                    <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-slate-100 text-slate-400">
                                        <span class="text-[10px] font-bold uppercase">Hoy</span>
                                        <span class="text-sm font-bold">11:30</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-slate-800 text-sm">Karla S.</p>
                                        <p class="text-[11px] text-slate-400">Esculturales • 120 min</p>
                                    </div>
                                </div>

                                <div class="absolute bottom-6 right-6 w-14 h-14 bg-brand-primary rounded-full shadow-lg shadow-pink-500/40 flex items-center justify-center text-white z-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-32 -right-6 md:-right-16 glass px-5 py-4 rounded-2xl shadow-xl animate-[sway_4s_ease-in-out_infinite] z-30 max-w-[200px] border border-white/60">
                        <div class="flex gap-3 items-center">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Nueva Reserva</p>
                                <p class="text-base font-bold text-slate-800 font-serif">+$450.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="py-6">
            <x-ad-banner />
        </div>

        <section id="features" class="mt-8 border-t border-pink-100/60 pt-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif font-bold text-slate-900 mb-3">¿Por qué elegir Glosy?</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Diseñado específicamente para manicuristas que quieren crecer sin trabajar más horas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-[2rem] bg-white border border-pink-50 shadow-sm hover:shadow-xl hover:shadow-pink-500/10 transition-all duration-300 hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center mb-6 text-brand-primary group-hover:scale-110 group-hover:bg-brand-primary group-hover:text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-3 font-serif">Agenda Autónoma</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Tus clientas reservan solas desde un link único. Tú solo recibes la notificación y el dinero.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-white border border-pink-50 shadow-sm hover:shadow-xl hover:shadow-pink-500/10 transition-all duration-300 hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center mb-6 text-brand-primary group-hover:scale-110 group-hover:bg-brand-primary group-hover:text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-3 font-serif">Cero Inasistencias</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Recordatorios automáticos por WhatsApp y correo para que nadie "olvide" su cita.</p>
                </div>

                <div class="p-8 rounded-[2rem] bg-white border border-pink-50 shadow-sm hover:shadow-xl hover:shadow-pink-500/10 transition-all duration-300 hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center mb-6 text-brand-primary group-hover:scale-110 group-hover:bg-brand-primary group-hover:text-white transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-3 font-serif">Finanzas Claras</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Visualiza cuánto ganas al día, qué servicios vendes más y controla tus gastos fácilmente.</p>
                </div>
            </div>
        </section>

        <div class="py-12">
            <x-ad-banner />
        </div>
    </main>
    
    <footer class="bg-white border-t border-slate-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6 flex flex-col items-center text-center">
            
            <img src="/public/img/logo_glosy.png" alt="Glosy Logo" class="h-8 mb-6 opacity-80 grayscale hover:grayscale-0 transition">
            
            <div class="flex flex-wrap justify-center gap-6 mb-8 text-sm font-medium text-slate-500">
                <a href="{{ route('login') }}" class="hover:text-brand-primary transition">Acceso Negocios</a>
                <a href="{{ route('login.cliente') }}" class="hover:text-brand-primary transition text-brand-primary font-bold">Acceso Clientes</a>
                <a href="{{ route('register') }}" class="hover:text-brand-primary transition">Registro</a>
                <a href="{{ route('privacy') }}" class="hover:text-brand-primary transition">Privacidad</a>
            </div>

            <div class="text-slate-400 text-xs">
                <p class="mb-2">&copy; 2025 Glosy. Todos los derechos reservados.</p>
                <p class="flex items-center justify-center gap-1.5">
                    Hecho con 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-pink-500 fill-current animate-pulse" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                    por 
                    <a href="https://rodnix.com.mx" target="_blank" class="font-bold text-slate-600 hover:text-brand-primary transition uppercase tracking-wider">
                        RODNIX
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /* --- Lógica del Menú Móvil --- */
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const backdrop = document.getElementById('menu-backdrop');
            const body = document.body;
            
            window.toggleMenu = function() {
                if (!mobileMenu || !backdrop) return;
                const isHidden = mobileMenu.classList.contains('translate-x-full');
                
                if (isHidden) {
                    backdrop.classList.remove('hidden');
                    setTimeout(() => {
                        backdrop.classList.remove('opacity-0');
                        mobileMenu.classList.remove('translate-x-full');
                    }, 10);
                    body.style.overflow = 'hidden'; 
                } else {
                    mobileMenu.classList.add('translate-x-full');
                    backdrop.classList.add('opacity-0');
                    setTimeout(() => {
                        backdrop.classList.add('hidden');
                        body.style.overflow = '';
                    }, 300);
                }
            }

            if (menuBtn) {
                menuBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleMenu();
                });
            }

            // Cerrar menú al hacer click en enlaces
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', toggleMenu);
            });

            /* --- Script de Lluvia de Sakura --- */
            const sakuraContainer = document.getElementById('sakura-container');
            const petalCount = 15; // Cantidad de pétalos simultáneos (bajo para no alentar PC/Móvil)

            function createPetal() {
                const petal = document.createElement('div');
                petal.classList.add('petal');
                
                // Tamaño aleatorio
                const size = Math.random() * 10 + 8 + 'px';
                petal.style.width = size;
                petal.style.height = size;
                
                // Posición horizontal aleatoria
                petal.style.left = Math.random() * 100 + 'vw';
                
                // Duración de caída aleatoria (entre 6s y 12s)
                const duration = Math.random() * 6 + 6 + 's';
                petal.style.animationDuration = duration;
                
                // Retraso aleatorio
                petal.style.animationDelay = Math.random() * 5 + 's';

                sakuraContainer.appendChild(petal);

                // Eliminar pétalo cuando termine la animación para no saturar el DOM
                setTimeout(() => {
                    petal.remove();
                    createPetal(); // Crear uno nuevo para mantener el ciclo
                }, parseFloat(duration) * 1000);
            }

            // Iniciar la lluvia
            for (let i = 0; i < petalCount; i++) {
                setTimeout(createPetal, Math.random() * 3000);
            }
        });
    </script>
</body>
</html>