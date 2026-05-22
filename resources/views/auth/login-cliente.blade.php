<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Soy Cliente | Glosy</title>
    <link rel="icon" href="/public/img/logo_glosy.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'sans': ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-pink-200 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute top-1/2 -right-20 w-64 h-64 bg-purple-200 rounded-full blur-3xl opacity-30"></div>
    </div>

    <a href="/" class="mb-8 hover:scale-105 transition transform">
        <img src="/public/img/logo_glosy.png" alt="Glosy" class="h-16 w-auto drop-shadow-sm">
    </a>

    <div class="bg-white w-full max-w-md p-8 rounded-[2rem] shadow-xl border border-slate-100 text-center relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-500 to-purple-600"></div>

        <h1 class="text-2xl font-bold text-slate-800 mb-2">¡Hola! 👋</h1>
        <p class="text-slate-500 text-sm mb-8">Ingresa para ver tus próximas citas y tu historial.</p>

        <a href="{{ route('google.login') }}?return_to={{ route('perfil.index') }}" 
           class="group w-full bg-white border-2 border-slate-100 hover:border-red-100 hover:bg-red-50 text-slate-700 font-bold py-4 px-6 rounded-2xl transition-all duration-300 flex items-center justify-center gap-4 shadow-sm hover:shadow-md">
            
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 transition">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="G" class="w-5 h-5">
            </div>
            
            <span class="text-sm sm:text-base group-hover:text-red-600">Continuar con Google</span>
        </a>

        <div class="my-6 flex items-center gap-4 opacity-50">
            <div class="h-px bg-slate-300 flex-1"></div>
            <span class="text-xs font-medium text-slate-400">seguro y sin contraseñas</span>
            <div class="h-px bg-slate-300 flex-1"></div>
        </div>

        <div class="bg-slate-50 p-4 rounded-xl text-xs text-slate-500 leading-relaxed border border-slate-100">
            <i class="fa-solid fa-shield-heart text-pink-400 mb-1 text-lg block"></i>
            Usamos tu cuenta de Google solo para verificar que eres una persona real y evitar citas falsas en los salones.
        </div>

        <div class="mt-8 pt-6 border-t border-slate-50">
            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-400 hover:text-pink-600 transition">
                ¿Eres dueño de un salón? Ingresa aquí
            </a>
        </div>
    </div>

    <p class="mt-8 text-[10px] text-slate-400">© 2025 Glosy App</p>

</body>
</html>