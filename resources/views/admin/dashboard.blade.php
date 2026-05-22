<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Control | Glosy</title>
    
    <link rel="icon" href="/public/img/logo_glosy.png">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
<body class="bg-brand-bg text-slate-800 pb-20 relative min-h-screen">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-0 -left-10 w-96 h-96 bg-brand-accent rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 -right-10 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </div>

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-white/50 shadow-sm px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="/public/img/logo_glosy.png" alt="Glosy" class="h-10 w-auto object-contain">
                <div class="hidden md:block h-6 w-px bg-slate-200"></div>
                <span class="hidden md:block text-sm font-bold text-slate-500 tracking-wide uppercase">Panel de Control</span>
            </div>

            <div class="flex items-center gap-6" x-data="{ open: false }">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-bold text-brand-dark">{{ $salon->nombre_negocio }}</span>
                    <div class="flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[10px] font-bold text-emerald-600 tracking-wider">ONLINE</span>
                    </div>
                </div>
                
                <div class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-primary to-brand-dark p-0.5 shadow-lg shadow-pink-500/20 group-hover:scale-105 transition overflow-hidden">
                            @if($salon->logo_url)
                                <img src="{{ url($salon->logo_url) }}" alt="Perfil" class="w-full h-full object-cover rounded-full bg-white">
                            @else
                                <div class="w-full h-full bg-white rounded-full flex items-center justify-center text-brand-primary font-bold text-lg">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-pink-50 py-2 z-50 transform origin-top-right transition-all" style="display: none;">
                        <div class="px-5 py-3 border-b border-slate-50">
                            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-2 px-5 py-3 text-sm text-slate-600 hover:bg-pink-50 hover:text-brand-primary transition">
                            <i class="ph-bold ph-gear"></i> Configuración
                        </a>
                        <a href="{{ route('salon.show', $salon->slug) }}" target="_blank" class="flex items-center gap-2 px-5 py-3 text-sm text-slate-600 hover:bg-pink-50 hover:text-brand-primary transition">
                            <i class="ph-bold ph-eye"></i> Ver mi Página
                        </a>
                        <div class="border-t border-slate-50 mt-1 pt-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 px-5 py-3 text-sm text-red-500 hover:bg-red-50 font-bold transition">
                                    <i class="ph-bold ph-sign-out"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-serif font-bold text-brand-dark">Hola, {{ explode(' ', auth()->user()->name)[0] }} ✨</h1>
                <p class="text-slate-500 font-medium">Aquí está el resumen de tu negocio.</p>
            </div>
            
            <a href="{{ route('salon.show', $salon->slug) }}" target="_blank" class="bg-brand-dark text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-pink-900/20 hover:scale-105 active:scale-95 transition flex items-center gap-2">
                <i class="ph-bold ph-plus-circle text-xl"></i>
                Nueva Cita
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-3xl shadow-sm border border-white flex items-center justify-between group hover:shadow-md transition">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Citas ({{ $fechaSeleccionada->isToday() ? 'Hoy' : 'Día' }})</p>
                    <h3 class="text-4xl font-serif font-bold text-brand-dark mt-1">{{ $citasDia->count() }}</h3>
                </div>
                <div class="w-14 h-14 bg-pink-100 text-brand-primary rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 group-hover:rotate-12 transition duration-300">
                    <i class="ph-fill ph-calendar-check"></i>
                </div>
            </div>
            
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-3xl shadow-sm border border-white flex items-center justify-between group hover:shadow-md transition">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Próximas</p>
                    <h3 class="text-4xl font-serif font-bold text-slate-700 mt-1">{{ $citasFuturas->count() }}</h3>
                </div>
                <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 group-hover:-rotate-12 transition duration-300">
                    <i class="ph-fill ph-hourglass-high"></i>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-3xl shadow-sm border border-white flex items-center justify-between group hover:shadow-md transition">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Ventas Mes (Est.)</p>
                    <h3 class="text-4xl font-serif font-bold text-emerald-600 mt-1">${{ number_format($gananciasMes, 0) }}</h3>
                </div>
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition duration-300">
                    <i class="ph-fill ph-currency-dollar"></i>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
                    
                    @if($fechaSeleccionada->gt($salon->created_at->startOfDay()))
                        <a href="{{ route('admin.dashboard', ['date' => $fechaSeleccionada->copy()->subDay()->format('Y-m-d')]) }}" class="p-2 hover:bg-slate-50 text-slate-400 hover:text-brand-primary rounded-xl transition" title="Día Anterior">
                            <i class="ph-bold ph-caret-left text-xl"></i>
                        </a>
                    @else
                        <button disabled class="p-2 text-slate-200 cursor-not-allowed" title="Inicio de los tiempos">
                            <i class="ph-bold ph-caret-left text-xl"></i>
                        </button>
                    @endif

                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.dashboard') }}" method="GET" id="dateForm">
                            <label class="relative cursor-pointer group">
                                <input type="date" name="date" 
                                       value="{{ $fechaSeleccionada->format('Y-m-d') }}" 
                                       min="{{ $salon->created_at->format('Y-m-d') }}"
                                       class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                                       onchange="document.getElementById('dateForm').submit()">
                                
                                <div class="flex items-center gap-3 px-4 py-2 bg-slate-50 group-hover:bg-brand-bg rounded-xl border border-slate-100 group-hover:border-pink-200 transition">
                                    <i class="ph-duotone ph-calendar-blank text-brand-primary text-xl"></i>
                                    <span class="font-bold text-slate-700 capitalize">
                                        @if($fechaSeleccionada->isToday())
                                            Hoy, {{ $fechaSeleccionada->locale('es')->isoFormat('D [de] MMMM') }}
                                        @elseif($fechaSeleccionada->isYesterday())
                                            Ayer, {{ $fechaSeleccionada->locale('es')->isoFormat('D [de] MMMM') }}
                                        @else
                                            {{ $fechaSeleccionada->locale('es')->isoFormat('dddd D [de] MMMM') }}
                                        @endif
                                    </span>
                                    <i class="ph-bold ph-caret-down text-xs text-slate-400"></i>
                                </div>
                            </label>
                        </form>
                        
                        @if(!$fechaSeleccionada->isToday())
                            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-brand-primary bg-pink-50 px-3 py-2 rounded-lg hover:bg-pink-100 transition shadow-sm border border-pink-100">
                                Ir a Hoy
                            </a>
                        @endif
                    </div>

                    <a href="{{ route('admin.dashboard', ['date' => $fechaSeleccionada->copy()->addDay()->format('Y-m-d')]) }}" class="p-2 hover:bg-slate-50 text-slate-400 hover:text-brand-primary rounded-xl transition" title="Día Siguiente">
                        <i class="ph-bold ph-caret-right text-xl"></i>
                    </a>
                </div>

                @if($citasDia->isEmpty())
                    <div class="bg-white/60 p-12 rounded-3xl border-2 border-dashed border-slate-200 text-center flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-4 text-slate-300 text-4xl shadow-sm">
                            <i class="ph-duotone ph-calendar-x"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-600">Nada por aquí</h3>
                        <p class="text-slate-400 text-sm mt-1 max-w-xs">
                            No hay citas registradas para el <br>
                            <span class="font-bold text-brand-primary">{{ $fechaSeleccionada->format('d/m/Y') }}</span>.
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($citasDia as $cita)
                        <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:border-pink-200 transition-all">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $cita->estado == 'completada' ? 'bg-emerald-400' : ($cita->estado == 'cancelada' ? 'bg-red-400' : 'bg-brand-primary') }}"></div>

                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 pl-4">
                                <div class="flex flex-col items-center justify-center bg-brand-bg rounded-2xl w-20 h-20 shrink-0 border border-pink-100">
                                    <span class="font-bold text-2xl text-brand-dark leading-none">{{ \Carbon\Carbon::parse($cita->fecha_hora_inicio)->format('H:i') }}</span>
                                    <span class="text-[10px] font-bold text-brand-primary/60 uppercase mt-1">HRS</span>
                                </div>

                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold text-lg text-slate-800">{{ $cita->cliente_nombre }}</h4>
                                        <span class="font-bold text-slate-800 text-lg">${{ number_format(optional($cita->servicio)->precio ?? 0, 0) }}</span>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span class="bg-purple-50 text-purple-700 px-2.5 py-1 rounded-lg text-xs font-bold flex items-center gap-1 border border-purple-100">
                                            <i class="ph-fill ph-sparkle"></i>
                                            {{ optional($cita->servicio)->nombre ?? 'Servicio Eliminado' }}
                                        </span>
                                        <a href="https://wa.me/521{{ str_replace(' ', '', $cita->cliente_telefono) }}" target="_blank" class="bg-green-50 text-green-700 px-2.5 py-1 rounded-lg text-xs font-bold flex items-center gap-1 border border-green-100 hover:bg-green-100 transition">
                                            <i class="ph-fill ph-whatsapp-logo"></i> WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if($cita->estado != 'completada' && $cita->estado != 'cancelada')
                            <div class="mt-5 pt-4 border-t border-slate-50 flex gap-3 justify-end opacity-0 group-hover:opacity-100 transition-opacity">
                                <form action="{{ route('cita.status', $cita->id) }}" method="POST" onsubmit="return confirm('¿Cancelar esta cita?');">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelada">
                                    <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-600 px-3 py-2 rounded-lg hover:bg-red-50 transition flex items-center gap-1">
                                        <i class="ph-bold ph-x"></i> Cancelar
                                    </button>
                                </form>

                                <form action="{{ route('cita.status', $cita->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="completada">
                                    <button type="submit" class="text-xs font-bold bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 border border-emerald-200 px-4 py-2 rounded-xl transition flex items-center gap-1 shadow-sm">
                                        <i class="ph-bold ph-check"></i> Marcar Realizada
                                    </button>
                                </form>
                            </div>
                            @else
                                <div class="mt-4 pt-2 text-right">
                                    <span class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider {{ $cita->estado == 'completada' ? 'text-emerald-500' : 'text-red-500' }}">
                                        @if($cita->estado == 'completada')
                                            <i class="ph-bold ph-check-circle text-lg"></i> Completada
                                        @else
                                            <i class="ph-bold ph-x-circle text-lg"></i> Cancelada
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif

                @if($fechaSeleccionada->gte(\Carbon\Carbon::today()))
                <div class="pt-6">
                    <h2 class="text-lg font-bold mb-4 text-slate-600 flex items-center gap-2">
                        <i class="ph-bold ph-clock-countdown"></i> Próximos Días
                    </h2>
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                        @forelse($citasFuturas as $cita)
                        <div class="flex items-center gap-4 p-4 border-b border-slate-50 text-sm hover:bg-slate-50 transition last:border-0">
                            <div class="w-14 text-center bg-slate-50 rounded-xl py-2 border border-slate-100">
                                <span class="block font-bold text-slate-700 text-lg leading-none">{{ \Carbon\Carbon::parse($cita->fecha_hora_inicio)->format('d') }}</span>
                                <span class="block text-[10px] uppercase text-slate-400 font-bold">{{ \Carbon\Carbon::parse($cita->fecha_hora_inicio)->format('M') }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-slate-700">{{ $cita->cliente_nombre }}</p>
                                <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                    <i class="ph-bold ph-clock"></i> {{ \Carbon\Carbon::parse($cita->fecha_hora_inicio)->format('H:i') }}
                                    <span class="mx-1">•</span>
                                    {{ optional($cita->servicio)->nombre }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-slate-400 text-sm">
                            Sin citas futuras por ahora.
                        </div>
                        @endforelse
                    </div>
                </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-gradient-to-br from-brand-primary to-brand-dark text-white p-6 rounded-3xl shadow-xl shadow-pink-900/20 relative overflow-hidden group">
                    <div class="absolute -top-12 -right-12 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl group-hover:opacity-20 transition duration-700"></div>
                    <div class="relative z-10 text-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl backdrop-blur-md">
                            <i class="ph-fill ph-rocket-launch"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-1">Tu Agenda Online</h3>
                        <p class="text-white/80 text-xs mb-4 px-2">Envía este enlace para que reserven solas.</p>
                        <div class="bg-black/20 p-1.5 rounded-xl flex items-center backdrop-blur-sm border border-white/10">
                            <input type="text" id="linkInput" value="{{ route('salon.show', $salon->slug) }}" class="bg-transparent text-xs text-white px-2 py-2 w-full focus:outline-none font-mono truncate" readonly>
                            <button onclick="copyLink()" class="bg-white text-brand-primary hover:bg-pink-50 font-bold text-xs px-3 py-2 rounded-lg transition shadow-sm flex items-center gap-1 shrink-0">
                                <i class="ph-bold ph-copy"></i> Copiar
                            </button>
                        </div>
                        <p id="copyMsg" class="text-xs text-green-300 font-bold mt-2 h-4 transition-opacity opacity-0">¡Copiado! 🎉</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 space-y-3">
                    <h3 class="font-bold mb-2 text-slate-700 text-sm uppercase tracking-wider">Accesos Directos</h3>
                    
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition group border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 group-hover:bg-brand-primary group-hover:text-white transition">
                            <i class="ph-bold ph-sliders"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-sm text-slate-700">Configuración</p>
                            <p class="text-[10px] text-slate-400">Servicios y Horarios</p>
                        </div>
                        <i class="ph-bold ph-caret-right text-slate-300"></i>
                    </a>

                    <a href="{{ route('salon.show', $salon->slug) }}" target="_blank" class="flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition group border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 group-hover:bg-purple-500 group-hover:text-white transition">
                            <i class="ph-bold ph-eye"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-sm text-slate-700">Ver como Clienta</p>
                            <p class="text-[10px] text-slate-400">Vista previa pública</p>
                        </div>
                        <i class="ph-bold ph-caret-right text-slate-300"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyLink() {
            var copyText = document.getElementById("linkInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            var msg = document.getElementById("copyMsg");
            msg.classList.remove('opacity-0');
            setTimeout(function() { msg.classList.add('opacity-0'); }, 2000);
        }
    </script>
</body>
</html>