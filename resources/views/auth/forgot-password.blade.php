<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | Glosy</title>
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
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-brand-primary text-3xl">
                <i class="ph-duotone ph-lock-key-open"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Recuperar Acceso</h1>
            <p class="text-slate-400 text-sm mt-2">Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-bold text-sm text-green-600 bg-green-50 p-3 rounded-xl text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Correo Electrónico</label>
                <div class="relative">
                    <i class="ph-bold ph-envelope-simple absolute left-4 top-3.5 text-slate-400 text-lg"></i>
                    <input type="email" name="email" required autofocus class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 pl-11 pr-4 text-sm font-medium text-slate-700 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition" placeholder="tu@correo.com">
                </div>
                @error('email') <span class="text-red-500 text-xs font-bold mt-1 ml-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-brand-primary hover:bg-brand-dark text-white font-bold py-3.5 rounded-xl shadow-lg shadow-pink-500/30 transition transform active:scale-95 flex items-center justify-center gap-2">
                Enviar Enlace <i class="ph-bold ph-paper-plane-right"></i>
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-400 hover:text-brand-primary transition flex items-center justify-center gap-1">
                <i class="ph-bold ph-arrow-left"></i> Volver al Login
            </a>
        </div>
    </div>
</body>
</html>