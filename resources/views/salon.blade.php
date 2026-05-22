<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ $salon->nombre_negocio }} | Reservar Cita</title>
    
    {{-- FAVICON DINÁMICO --}}
    @if($salon->logo_url)
        <link rel="icon" href="{{ asset($salon->logo_url) }}">
    @else
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💅</text></svg>">
    @endif

    {{-- FUENTES --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    {{-- ICONOS --}}
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    {{-- LIBRERÍAS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- ADSENSE --}}
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1759897583511097" crossorigin="anonymous"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': '{{ $salon->color_brand ?? "#ec4899" }}', 
                        'brand-light': '{{ $salon->color_brand ?? "#ec4899" }}10', 
                    },
                    fontFamily: {
                        'sans': ['"Plus Jakarta Sans"', 'sans-serif'],
                        'serif': ['"Playfair Display"', 'serif'],
                    },
                    boxShadow: {
                        'soft': '0 10px 40px -10px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        input[type="date"], input[type="time"] { -webkit-appearance: none; }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
    </style>
</head>
<body class="bg-[#FFFCFE] text-slate-700 antialiased min-h-screen pb-24 selection:bg-brand selection:text-white" x-data="{ modalOpen: false, servicioSelected: null, servicioNombre: '', servicioPrecio: '', servicioDuracion: '' }">

    {{-- ALERTAS --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-4 left-4 right-4 bg-emerald-500 text-white p-4 rounded-[2rem] shadow-xl z-[60] flex items-center gap-3 animate-bounce">
            <div class="bg-white/20 p-2 rounded-full"><i class="ph-bold ph-check text-xl"></i></div>
            <div>
                <p class="font-bold text-sm">¡Listo!</p>
                <p class="text-xs text-emerald-50 opacity-90">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div x-data="{ show: true }" x-show="show" class="fixed top-4 left-4 right-4 bg-red-400 text-white p-4 rounded-[2rem] shadow-xl z-[60] flex items-start gap-3">
            <div class="bg-white/20 p-2 rounded-full mt-1"><i class="ph-bold ph-warning text-xl"></i></div>
            <div class="flex-1">
                <p class="font-bold text-sm">Algo salió mal</p>
                <ul class="text-xs text-red-50 list-disc pl-4 mt-1 space-y-1">
                    @if(session('error')) <li>{{ session('error') }}</li> @endif
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
                <button @click="show = false" class="text-xs font-bold underline mt-2 text-white/80">Cerrar</button>
            </div>
        </div>
    @endif

    {{-- PORTADA --}}
    <div class="relative bg-brand pb-28 rounded-b-[3.5rem] shadow-soft overflow-hidden">
        <div class="absolute inset-0 opacity-15 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/5 to-transparent"></div>
        
        <div class="relative px-6 pt-10 text-center z-10">
            {{-- Header --}}
            <div class="flex justify-between items-start mb-6 h-8">
                <div></div>
                
                {{-- 🔴 BOTÓN DE PERFIL CLICKEABLE --}}
                @auth('client')
                    <a href="{{ route('perfil.index') }}" class="flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-1.5 rounded-full text-white text-xs font-bold border border-white/30 shadow-sm hover:bg-white/30 transition-all cursor-pointer active:scale-95">
                        @if(Auth::guard('client')->user()->avatar)
                            <img src="{{ Auth::guard('client')->user()->avatar }}" class="w-6 h-6 rounded-full border-2 border-white">
                        @else
                             <div class="w-6 h-6 rounded-full bg-white/30 flex items-center justify-center"><i class="ph-bold ph-user"></i></div>
                        @endif
                        <span class="tracking-wide">{{ explode(' ', Auth::guard('client')->user()->nombre)[0] }}</span>
                    </a>
                @endauth
            </div>

            <div class="w-32 h-32 mx-auto bg-white p-1.5 rounded-full shadow-2xl mb-5 relative transition transform hover:scale-105 duration-500">
                @if($salon->logo_url)
                    <img src="{{ asset($salon->logo_url) }}" class="w-full h-full object-cover rounded-full border-4 border-brand-light">
                @else
                    <div class="w-full h-full bg-brand rounded-full flex items-center justify-center text-5xl font-serif text-white border-4 border-white font-bold">
                        {{ substr($salon->nombre_negocio, 0, 1) }}
                    </div>
                @endif
                <div class="absolute bottom-2 right-2 w-6 h-6 bg-emerald-400 border-[3px] border-white rounded-full shadow-sm animate-pulse"></div>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-serif font-bold tracking-wide text-white mb-3 text-shadow-sm leading-tight">
                {{ $salon->nombre_negocio }}
            </h1>
            
            <div class="inline-flex items-center gap-2 bg-white/25 backdrop-blur-md px-5 py-2 rounded-full text-xs font-bold text-white border border-white/30 shadow-sm">
                <i class="ph-fill ph-calendar-check text-emerald-200 text-sm"></i> 
                <span class="tracking-widest uppercase text-[10px]">Agenda Abierta</span>
            </div>
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="px-5 -mt-20 relative z-20 mb-8">
        <div class="glass rounded-[2.5rem] p-6 shadow-soft text-center space-y-5">
            @if($salon->descripcion)
                <p class="text-slate-500 text-sm leading-relaxed font-medium italic">"{{ $salon->descripcion }}"</p>
            @endif

            <div class="flex flex-wrap justify-center gap-3">
                @if($salon->horario_texto)
                    <div class="bg-brand-light px-4 py-2.5 rounded-2xl border border-brand/10 flex items-center gap-2 text-xs font-bold text-slate-600">
                        <i class="ph-bold ph-clock text-brand text-base"></i> {{ $salon->horario_texto }}
                    </div>
                @endif
                
                @if($salon->direccion)
                    {{-- 🔴 BOTÓN DE UBICACIÓN DIRECTO (DB LINK) --}}
                     <a href="{{ $salon->direccion }}" target="_blank" class="bg-brand-light px-4 py-2.5 rounded-2xl border border-brand/10 flex items-center gap-2 text-xs font-bold text-slate-600 hover:bg-brand hover:text-white transition-all duration-300 shadow-sm hover:shadow-md cursor-pointer group">
                        <i class="ph-fill ph-map-pin text-brand text-base group-hover:text-white transition-colors"></i> 
                        <span>Ver Ubicación</span>
                    </a>
                @endif
            </div>

            @if($salon->telefono_publico)
                <a href="https://wa.me/521{{ preg_replace('/[^0-9]/', '', $salon->telefono_publico) }}" target="_blank" class="flex items-center justify-center gap-3 w-full bg-gradient-to-r from-[#25D366] to-[#128C7E] text-white font-bold py-4 rounded-2xl shadow-lg shadow-green-500/20 hover:shadow-green-500/40 hover:-translate-y-0.5 transition-all duration-300">
                    <i class="ph-fill ph-whatsapp-logo text-2xl"></i> 
                    <span>Enviar Mensaje</span>
                </a>
            @endif
        </div>
    </div>

    {{-- ANUNCIO 1 --}}
    <x-ad-banner />

    {{-- SERVICIOS --}}
    <div class="px-5 max-w-lg mx-auto pb-6">
        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="font-bold text-slate-800 text-xl font-serif flex items-center gap-2">
                <i class="ph-fill ph-sparkle text-brand"></i> Servicios
            </h2>
            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-full tracking-wide">{{ $salon->servicios->count() }} DISP.</span>
        </div>
        
        <div class="space-y-4">
            @forelse($salon->servicios as $servicio)
            <div @click="modalOpen = true; servicioSelected = {{ $servicio->id }}; servicioNombre = '{{ $servicio->nombre }}'; servicioPrecio = '{{ $servicio->precio }}'; servicioDuracion = '{{ $servicio->duracion_minutos }}'" 
                 class="group bg-white rounded-[2rem] p-5 shadow-sm border border-slate-100 cursor-pointer relative overflow-hidden transition-all duration-300 hover:shadow-md hover:border-brand/30 active:scale-[0.98]">
                
                <div class="flex justify-between items-center relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-brand-light text-brand rounded-2xl flex items-center justify-center text-xl font-serif font-bold group-hover:bg-brand group-hover:text-white transition-colors duration-300 shadow-sm">
                            {{ substr($servicio->nombre, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight group-hover:text-brand transition-colors">{{ $servicio->nombre }}</h3>
                            <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1.5 font-medium">
                                <i class="ph-bold ph-hourglass text-brand"></i> {{ $servicio->duracion_minutos }} min
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block font-bold text-slate-800 text-lg">${{ number_format($servicio->precio, 0) }}</span>
                        <div class="mt-1">
                            <span class="text-[10px] font-bold text-white bg-brand px-3 py-1 rounded-lg opacity-0 transform translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 shadow-sm">RESERVAR</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16 bg-white rounded-[2.5rem] border border-dashed border-slate-200">
                <p class="text-slate-400 font-medium text-sm">No hay servicios disponibles.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ANUNCIO 2 --}}
    <x-ad-banner />

    <div class="text-center mt-10 text-[10px] text-slate-400 pb-8">
        <p class="opacity-60">Tecnología por <a href="https://rodnix.com.mx" target="_blank" class="font-bold text-slate-600 hover:text-brand">RODNIX</a></p>
    </div>

    {{-- MODAL --}}
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="modalOpen = false" x-transition.opacity></div>
        
        <div class="bg-white w-full max-w-md rounded-t-[2.5rem] sm:rounded-[2.5rem] p-8 shadow-2xl relative z-10 max-h-[90vh] overflow-y-auto" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0">
            
            <div class="w-12 h-1.5 bg-slate-100 rounded-full mx-auto mb-8"></div>

            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-2xl font-serif font-bold text-slate-800">Confirmar Cita</h3>
                    <p class="text-slate-400 text-xs mt-1 font-medium">
                        @auth('client') Revisa los detalles @else Identifícate para continuar @endauth
                    </p>
                </div>
                <button @click="modalOpen = false" class="bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-red-400 w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>

            <div class="bg-brand-light border border-brand/10 p-5 rounded-3xl mb-8 flex justify-between items-center relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[10px] text-brand font-bold uppercase tracking-wider mb-1 opacity-70">Servicio</p>
                    <p class="font-serif font-bold text-slate-800 text-xl leading-tight" x-text="servicioNombre"></p>
                    <p class="text-xs text-slate-500 mt-1 font-medium flex items-center gap-1">
                        <i class="ph-fill ph-clock"></i> <span x-text="servicioDuracion + ' min'"></span>
                    </p>
                </div>
                <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-brand/10 relative z-10">
                    <span class="font-bold text-brand text-xl" x-text="'$' + servicioPrecio"></span>
                </div>
                <div class="absolute -right-6 -bottom-6 text-brand opacity-5 text-9xl"><i class="ph-fill ph-sparkle"></i></div>
            </div>

            @guest('client')
                <div class="text-center py-2 space-y-6">
                    <div class="relative w-20 h-20 mx-auto bg-white border border-slate-100 rounded-full flex items-center justify-center text-3xl shadow-sm">
                         <i class="ph-duotone ph-user-circle text-brand"></i>
                    </div>
                    <div class="space-y-2">
                        <h4 class="font-bold text-slate-800 text-lg">¿Quién eres?</h4>
                        <p class="text-xs text-slate-500 px-6 leading-relaxed">Para proteger tu reserva, necesitamos verificar tu identidad de forma segura.</p>
                    </div>
                    
                    {{-- BOTÓN GOOGLE OFICIAL --}}
                    <a href="{{ route('google.login') }}?return_to={{ urlencode(url()->current()) }}" class="block w-full bg-white text-slate-600 font-bold py-3.5 rounded-2xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-all duration-300 flex items-center justify-center gap-3 group relative overflow-hidden">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-6 h-6" alt="G">
                        <span class="font-sans">Continuar con Google</span>
                    </a>
                    
                    <p class="text-[10px] text-slate-300 flex items-center justify-center gap-1 mt-2">
                        <i class="ph-fill ph-lock-key"></i> Datos 100% seguros
                    </p>
                </div>
            @else
                <form action="{{ route('reservar.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="salon_id" value="{{ $salon->id }}">
                    <input type="hidden" name="servicio_id" x-model="servicioSelected">

                    <div class="relative group">
                        <i class="ph-bold ph-user absolute left-4 top-4 text-slate-400"></i>
                        <input type="text" value="{{ Auth::guard('client')->user()->nombre }}" disabled class="w-full bg-slate-50 border-none rounded-2xl pl-11 pr-4 py-3.5 text-sm font-bold text-slate-500">
                        <div class="absolute right-4 top-4 text-emerald-500 text-lg"><i class="ph-fill ph-check-circle"></i></div>
                    </div>

                    <div class="relative group">
                        <i class="ph-bold ph-whatsapp-logo absolute left-4 top-4 text-slate-400 group-focus-within:text-brand transition-colors"></i>
                        <input type="tel" name="cliente_telefono" required 
                               value="{{ Auth::guard('client')->user()->telefono }}"
                               maxlength="10"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3.5 text-sm font-medium text-slate-700 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all placeholder:text-slate-300" 
                               placeholder="Tu WhatsApp (10 dígitos)">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-2 tracking-wider">Fecha</label>
                            <div class="relative">
                                <i class="ph-bold ph-calendar-blank absolute left-3.5 top-3.5 text-brand"></i>
                                <input type="date" name="fecha" required min="{{ date('Y-m-d') }}" class="w-full bg-white border border-slate-200 rounded-2xl pl-10 pr-2 py-3 text-sm font-bold text-slate-700 focus:border-brand focus:ring-2 focus:ring-brand/10 outline-none appearance-none">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-2 tracking-wider">Hora</label>
                            <div class="relative">
                                <i class="ph-bold ph-clock absolute left-3.5 top-3.5 text-brand"></i>
                                <input type="time" name="hora" required min="07:00" max="21:00" class="w-full bg-white border border-slate-200 rounded-2xl pl-10 pr-2 py-3 text-sm font-bold text-slate-700 focus:border-brand focus:ring-2 focus:ring-brand/10 outline-none appearance-none">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-brand text-white font-bold text-base py-4 rounded-2xl shadow-lg shadow-brand/30 mt-2 hover:brightness-110 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 group">
                        <span>Confirmar Reserva</span>
                        <i class="ph-bold ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            @endguest
        </div>
    </div>

</body>
</html>