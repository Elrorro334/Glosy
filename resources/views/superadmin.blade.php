<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Super Admin | Glosy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen p-6 antialiased">

    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Panel de Control
                </h1>
                <p class="text-slate-400 mt-1 text-sm">Administración central de Glosy</p>
            </div>
            
            <div class="flex gap-3">
                <div class="bg-slate-900 px-4 py-2 rounded-lg border border-slate-800 text-center">
                    <span class="block text-xs text-slate-500 uppercase font-bold">Total Salones</span>
                    <span class="text-xl font-bold text-white">{{ $salons->total() }}</span>
                </div>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold bg-slate-800 hover:bg-slate-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 border border-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Volver
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 p-4 rounded-xl mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <form action="{{ route('superadmin.index') }}" method="GET" class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-slate-900 border border-slate-700 text-slate-200 rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition placeholder-slate-600" placeholder="Buscar por nombre, email o salón...">
            </form>
        </div>

        <div class="bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-800">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-950 border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider font-semibold">
                            <th class="p-5">ID</th>
                            <th class="p-5">Salón</th>
                            <th class="p-5">Dueña</th>
                            <th class="p-5 text-center">Acciones Rápidas</th>
                            <th class="p-5 text-center">Estado (Click para cambiar)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($salons as $salon)
                        <tr class="hover:bg-slate-800/50 transition group">
                            <td class="p-5 text-slate-600 font-mono text-xs">#{{ $salon->id }}</td>
                            
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold text-lg">
                                        {{ substr($salon->nombre_negocio, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white">{{ $salon->nombre_negocio }}</div>
                                        <a href="{{ route('salon.show', $salon->slug) }}" target="_blank" class="text-xs text-indigo-400 hover:text-indigo-300 flex items-center gap-1">
                                            glosy.com.mx/{{ $salon->slug }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td class="p-5">
                                @if($salon->user)
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-slate-200">{{ $salon->user->name }}</span>
                                        <span class="text-xs text-slate-500">{{ $salon->user->email }}</span>
                                    </div>
                                @else
                                    <span class="text-xs bg-red-500/10 text-red-400 px-2 py-1 rounded border border-red-500/20">Sin Usuario</span>
                                @endif
                            </td>

                            <td class="p-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('superadmin.loginAs', $salon->id) }}" title="Iniciar sesión como usuaria" class="p-2 bg-indigo-500/10 text-indigo-400 rounded-lg hover:bg-indigo-500 hover:text-white transition border border-indigo-500/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <form action="{{ route('superadmin.destroy', $salon->id) }}" method="POST" onsubmit="return confirm('¿ESTÁS SEGURO? Esta acción es IRREVERSIBLE.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar Salón" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition border border-red-500/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <td class="p-5 text-center">
                                <form action="{{ route('superadmin.status', $salon->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Click para cambiar estado" class="w-full inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-bold border transition hover:scale-105 {{ $salon->active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30 hover:bg-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/30 hover:bg-rose-500/20' }}">
                                        @if($salon->active)
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span> Activo
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-rose-400 mr-2"></span> Suspendido
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($salons->isEmpty())
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    </div>
                    <h3 class="text-lg font-medium text-white">No se encontraron salones</h3>
                </div>
            @endif
        </div>
        
        <div class="mt-6">
            {{ $salons->withQueryString()->links() }}
        </div>

    </div>

</body>
</html>