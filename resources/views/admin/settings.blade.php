<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configurar Negocio | Glosy</title>
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
                    },
                    fontFamily: {
                        'sans': ['"Plus Jakarta Sans"', 'sans-serif'],
                        'serif': ['"Playfair Display"', 'serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-brand-bg text-slate-800 pb-20">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-white/50 shadow-sm px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-brand-primary rounded-lg flex items-center justify-center text-white text-lg shadow-md">
                <i class="ph-bold ph-sliders"></i>
            </div>
            <span class="font-bold text-lg text-slate-700">Configuración</span>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-brand-primary flex items-center gap-1 transition">
            <i class="ph-bold ph-arrow-left"></i> Volver al Dashboard
        </a>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 p-4 mb-8 rounded-2xl shadow-sm flex items-center gap-3">
                <i class="ph-fill ph-check-circle text-xl"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-500 p-4 mb-8 rounded-2xl shadow-sm">
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <h2 class="font-serif font-bold text-xl mb-6 text-brand-dark flex items-center gap-2">
                        <i class="ph-duotone ph-storefront text-brand-primary"></i> Tu Salón
                    </h2>
                    
                    <form action="{{ route('settings.updateSalon') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <div class="text-center mb-6">
                            <div class="w-28 h-28 mx-auto rounded-full bg-brand-bg border-2 border-dashed border-pink-200 flex items-center justify-center overflow-hidden mb-3 relative group transition hover:border-brand-primary">
                                @if($salon->logo_url)
                                    <img src="{{ url($salon->logo_url) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center text-pink-300">
                                        <i class="ph-duotone ph-image text-3xl"></i>
                                        <span class="block text-[10px] mt-1">Sin Logo</span>
                                    </div>
                                @endif
                                <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer" onchange="this.form.submit()">
                            </div>
                            <p class="text-[10px] text-slate-400 font-medium">Click para cambiar</p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Nombre</label>
                                <input type="text" name="nombre_negocio" value="{{ $salon->nombre_negocio }}" class="w-full mt-1 px-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:border-brand-primary outline-none transition" required>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Descripción</label>
                                <textarea name="descripcion" rows="2" class="w-full mt-1 px-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:border-brand-primary outline-none transition resize-none">{{ $salon->descripcion }}</textarea>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Ubicación</label>
                                <div class="flex gap-2 mt-1">
                                    <input type="text" id="direccionInput" name="direccion" value="{{ $salon->direccion }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-xs focus:bg-white focus:border-brand-primary outline-none transition font-mono" placeholder="Pega Link de Maps o usa el botón ->">
                                    
                                    <button type="button" onclick="getGPS()" class="bg-brand-primary text-white px-3 rounded-xl hover:bg-brand-dark transition shadow-sm flex items-center justify-center" title="Obtener mi ubicación actual">
                                        <i class="ph-bold ph-map-pin text-xl"></i>
                                    </button>
                                </div>
                                <p id="gpsStatus" class="text-[10px] text-slate-400 mt-1 ml-1">Usa el botón para guardar tus coordenadas exactas.</p>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Horarios</label>
                                <input type="text" name="horario_texto" value="{{ $salon->horario_texto }}" class="w-full mt-1 px-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:border-brand-primary outline-none transition" placeholder="Lun-Vie 10am - 7pm">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">WhatsApp</label>
                                <input type="text" name="telefono_publico" value="{{ $salon->telefono_publico }}" class="w-full mt-1 px-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:border-brand-primary outline-none transition" placeholder="55 1234 5678">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-brand-dark text-white font-bold py-3 rounded-xl shadow-lg hover:scale-[1.02] active:scale-95 transition flex items-center justify-center gap-2">
                                <i class="ph-bold ph-floppy-disk"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <h2 class="font-serif font-bold text-xl mb-6 text-brand-dark flex items-center gap-2">
                        <i class="ph-duotone ph-sparkle text-brand-primary"></i> Agregar Servicio
                    </h2>
                    <form action="{{ route('settings.storeServicio') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-6">
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Nombre</label>
                            <input type="text" name="nombre" placeholder="Ej: Gelish Liso" class="w-full mt-1 px-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:border-brand-primary outline-none transition" required>
                        </div>
                        <div class="md:col-span-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Precio</label>
                            <div class="relative mt-1">
                                <span class="absolute left-3 top-2.5 text-slate-400 font-bold">$</span>
                                <input type="number" name="precio" placeholder="0" class="w-full pl-7 pr-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:border-brand-primary outline-none transition" required>
                            </div>
                        </div>
                        <div class="md:col-span-3">
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Duración</label>
                            <select name="duracion_minutos" class="w-full mt-1 px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:bg-white focus:border-brand-primary outline-none transition cursor-pointer">
                                <option value="30">30 min</option>
                                <option value="45">45 min</option>
                                <option value="60" selected>1 hr</option>
                                <option value="90">1.5 hrs</option>
                                <option value="120">2 hrs</option>
                            </select>
                        </div>
                        <div class="md:col-span-12 mt-2">
                            <button type="submit" class="w-full bg-brand-primary text-white font-bold py-3 rounded-xl shadow-lg hover:bg-pink-600 hover:scale-[1.01] active:scale-95 transition flex items-center justify-center gap-2">
                                <i class="ph-bold ph-plus"></i> Agregar al Menú
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden" x-data="{ editing: null }">
                    <div class="p-5 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-700 flex items-center gap-2">
                            <i class="ph-bold ph-list-dashes text-brand-primary"></i> Menú Activo
                        </h3>
                        <span class="bg-white border border-slate-200 text-slate-500 px-2.5 py-0.5 rounded-lg text-xs font-bold">{{ $salon->servicios->count() }}</span>
                    </div>
                    
                    <div class="divide-y divide-slate-50">
                        @foreach($salon->servicios as $servicio)
                        <div class="p-4 hover:bg-pink-50/30 transition group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-brand-bg text-brand-primary rounded-xl flex items-center justify-center font-bold text-lg border border-pink-100">
                                        {{ substr($servicio->nombre, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">{{ $servicio->nombre }}</h4>
                                        <div class="flex items-center gap-3 text-xs text-slate-400 mt-0.5">
                                            <span class="flex items-center gap-1"><i class="ph-bold ph-clock"></i> {{ $servicio->duracion_minutos }} min</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded-lg text-sm border border-slate-200">${{ number_format($servicio->precio, 0) }}</span>
                                    
                                    <button @click="editing = {{ $servicio->id }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 hover:text-blue-500 hover:bg-blue-50 transition">
                                        <i class="ph-bold ph-pencil-simple"></i>
                                    </button>

                                    <form action="{{ route('settings.destroyServicio', $servicio->id) }}" method="POST" onsubmit="return confirm('¿Borrar?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 transition">
                                            <i class="ph-bold ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div x-show="editing === {{ $servicio->id }}" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
                                <div @click.away="editing = null" class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl m-4">
                                    <h3 class="font-bold text-lg mb-4 text-brand-dark">Editar Servicio</h3>
                                    <form action="{{ route('settings.updateServicio', $servicio->id) }}" method="POST" class="space-y-4">
                                        @csrf @method('PUT')
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-400 uppercase">Nombre</label>
                                            <input type="text" name="nombre" value="{{ $servicio->nombre }}" class="w-full mt-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-brand-primary outline-none">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-[10px] font-bold text-slate-400 uppercase">Precio</label>
                                                <input type="number" name="precio" value="{{ $servicio->precio }}" class="w-full mt-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-brand-primary outline-none">
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold text-slate-400 uppercase">Minutos</label>
                                                <input type="number" name="duracion_minutos" value="{{ $servicio->duracion_minutos }}" class="w-full mt-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-brand-primary outline-none">
                                            </div>
                                        </div>
                                        <div class="flex gap-3 mt-4 pt-2">
                                            <button type="button" @click="editing = null" class="flex-1 py-2 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-xl transition">Cancelar</button>
                                            <button type="submit" class="flex-1 py-2 text-sm font-bold text-white bg-brand-primary hover:bg-brand-dark rounded-xl transition shadow-lg">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getGPS() {
            const status = document.getElementById('gpsStatus');
            const input = document.getElementById('direccionInput');
            
            if (!navigator.geolocation) {
                status.innerText = "Tu navegador no soporta GPS.";
                return;
            }

            status.innerText = "Obteniendo ubicación...";
            status.classList.add('text-brand-primary');

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    // Genera un link de Google Maps
                    input.value = `https://www.google.com/maps?q=${lat},${lng}`;
                    status.innerText = "¡Ubicación obtenida! Dale guardar.";
                    status.classList.remove('text-brand-primary');
                    status.classList.add('text-green-500', 'font-bold');
                },
                () => {
                    status.innerText = "Error: No pudimos obtener tu ubicación. Revisa permisos.";
                    status.classList.add('text-red-500');
                }
            );
        }
    </script>
</body>
</html>