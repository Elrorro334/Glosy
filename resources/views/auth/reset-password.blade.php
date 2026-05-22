<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña | Glosy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-primary': '#AB3E86',
                        'brand-dark': '#5C0A43',
                        'brand-bg': '#FFF5F8',
                    },
                    fontFamily: { 'sans': ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-bg h-screen flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md p-8 rounded-[2rem] shadow-xl shadow-pink-100/50 border border-white relative overflow-hidden">
        
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Nueva Contraseña</h1>
            <p class="text-slate-400 text-sm mt-1">Elige una contraseña segura.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-500 p-3 rounded-xl text-xs font-bold mb-4">
                <ul>@foreach ($errors->all() as $error) <li>• {{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1 ml-1">Correo</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl py-3 px-4 text-sm font-medium text-slate-500 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1 ml-1">Nueva Contraseña</label>
                <div class="relative">
                    <i class="ph-bold ph-lock absolute left-4 top-3.5 text-slate-400 text-lg"></i>
                    <input type="password" name="password" required autofocus class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 pl-11 pr-4 text-sm font-medium text-slate-700 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1 ml-1">Confirmar Contraseña</label>
                <div class="relative">
                    <i class="ph-bold ph-lock-key absolute left-4 top-3.5 text-slate-400 text-lg"></i>
                    <input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 pl-11 pr-4 text-sm font-medium text-slate-700 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-brand-primary hover:bg-brand-dark text-white font-bold py-3.5 rounded-xl shadow-lg shadow-pink-500/30 transition transform active:scale-95">
                Restablecer Contraseña
            </button>
        </form>
    </div>
</body>
</html>