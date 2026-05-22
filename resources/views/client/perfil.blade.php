<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Mi Perfil | Glosy</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 pb-20">

    <div class="bg-white p-6 pb-12 rounded-b-[2.5rem] shadow-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-pink-500/5 to-purple-500/5"></div>
        
        <div class="relative z-10 flex flex-col items-center text-center">
            
            <div class="w-24 h-24 rounded-full border-4 border-white shadow-xl mb-4 overflow-hidden bg-slate-100 flex items-center justify-center relative">
                @if($client->avatar)
                    <img src="{{ $client->avatar }}" alt="Perfil" class="w-full h-full object-cover">
                @else
                    <i class="ph-fill ph-user text-4xl text-slate-300"></i>
                @endif
            </div>

            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                Hola, {{ explode(' ', $client->nombre)[0] }} 
                <i class="ph-fill ph-hand-waving text-yellow-400"></i>
            </h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">{{ $client->email }}</p>
        </div>
    </div>

    <div class="px-5 -mt-8 relative z-20 space-y-6">

        <div>
            <h2 class="font-bold text-lg mb-4 flex items-center gap-2 text-slate-700">
                <div class="bg-pink-100 p-1.5 rounded-lg text-pink-500">
                    <i class="ph-fill ph-calendar-check text-lg"></i>
                </div>
                Próximas Citas
            </h2>
            
            @if(isset($proximasCitas) && count($proximasCitas) > 0)
                <div class="space-y-4">
                    @foreach($proximasCitas as $cita)
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex gap-4 items-center transition-transform active:scale-[0.98]">
                        
                        <div class="bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 flex flex-col items-center justify-center min-w-[65px]">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">
                                {{ \Carbon\Carbon::parse($cita->fecha_hora_inicio)->translatedFormat('M') }}
                            </span>
                            <span class="text-xl font-bold text-slate-800 leading-none mt-0.5">
                                {{ \Carbon\Carbon::parse($cita->fecha_hora_inicio)->format('d') }}
                            </span>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-slate-800 truncate text-sm">
                                {{ $cita->servicio->nombre ?? 'Servicio no disponible' }}
                            </h3>
                            <p class="text-xs text-slate-500 mb-1.5 truncate">
                                {{ $cita->salon->nombre_negocio ?? 'Salón no disponible' }}
                            </p>
                            
                            <div class="inline-flex items-center gap-1.5 bg-slate-100 px-2 py-1 rounded-md text-[10px] font-bold text-slate-600">
                                <i class="ph-bold ph-clock text-pink-500"></i> 
                                {{ \Carbon\Carbon::parse($cita->fecha_hora_inicio)->format('h:i A') }}
                            </div>
                        </div>

                        @if($cita->salon && $cita->salon->telefono_publico)
                            <a href="https://wa.me/521{{ preg_replace('/[^0-9]/', '', $cita->salon->telefono_publico) }}" 
                               target="_blank" 
                               class="w-10 h-10 flex items-center justify-center rounded-full bg-[#E7FCEB] text-[#25D366] hover:bg-[#dcfce3] transition shadow-sm">
                                <i class="ph-fill ph-whatsapp-logo text-xl"></i>
                            </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-8 rounded-2xl text-center border-2 border-dashed border-slate-200">
                    <div class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                        <i class="ph-duotone ph-calendar-slash text-2xl"></i>
                    </div>
                    <p class="text-slate-400 text-sm font-medium mb-5">No tienes citas programadas</p>
                    <a href="/" class="inline-flex items-center gap-2 bg-slate-800 text-white font-bold py-3 px-6 rounded-xl text-xs shadow-lg shadow-slate-800/20 hover:bg-slate-900 transition">
                        <i class="ph-bold ph-magnifying-glass"></i> Explorar Salones
                    </a>
                </div>
            @endif
        </div>

        <form action="{{ route('logout') }}" method="POST" class="pt-6">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 text-red-500 font-bold text-sm py-4 rounded-xl hover:bg-red-50 transition border border-transparent hover:border-red-100 group">
                <i class="ph-bold ph-sign-out group-hover:scale-110 transition-transform"></i> 
                Cerrar Sesión
            </button>
        </form>

    </div>
</body>
</html>