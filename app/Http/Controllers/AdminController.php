<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Salon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // 1. SEGURIDAD: Login requerido
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. OBTENER SALÓN
        $user = auth()->user();
        $salon = Salon::where('user_id', $user->id)->first();

        // Validación de existencia
        if (!$salon) {
            return "<h1>Hola " . $user->name . "</h1><p>Aún no tienes un salón registrado. Contacta a soporte.</p>";
        }

        // 3. BLOQUEO POR SUSPENSIÓN (Super Admin)
        if (!$salon->active) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Tu salón ha sido suspendido. Por favor contacta a soporte.']);
        }

        // --- 📅 LÓGICA DE FECHAS (CANDADO DE TIEMPO) ---
        
        // A. Definimos el "Big Bang" (Fecha de registro del salón)
        $fechaRegistro = $salon->created_at->startOfDay();
        
        // B. Obtenemos fecha solicitada o usamos HOY
        $fechaSeleccionada = $request->input('date') 
                            ? Carbon::parse($request->input('date'))->startOfDay() 
                            : Carbon::today();

        // C. 🛡️ VALIDACIÓN: Si intenta ir antes del registro, lo regresamos a la fecha de registro
        if ($fechaSeleccionada->lessThan($fechaRegistro)) {
            $fechaSeleccionada = $fechaRegistro;
        }

        // 4. CONSULTAS DE DATOS

        // A. Citas del Día Seleccionado
        $citasDia = Cita::where('salon_id', $salon->id)
                        ->whereDate('fecha_hora_inicio', $fechaSeleccionada)
                        ->orderBy('fecha_hora_inicio', 'asc')
                        ->with('servicio')
                        ->get();

        // B. Citas FUTURAS (Siempre desde HOY REAL hacia adelante)
        $citasFuturas = Cita::where('salon_id', $salon->id)
                        ->whereDate('fecha_hora_inicio', '>', Carbon::today())
                        ->where('estado', '!=', 'cancelada')
                        ->orderBy('fecha_hora_inicio', 'asc')
                        ->with('servicio')
                        ->take(5)
                        ->get();

        // C. Ganancias del Mes (Solo completadas/confirmadas)
        $gananciasMes = Cita::where('salon_id', $salon->id)
                        ->whereMonth('fecha_hora_inicio', Carbon::now()->month)
                        ->where('estado', '!=', 'cancelada')
                        ->with('servicio')
                        ->get()
                        ->sum(function($cita) {
                            return $cita->servicio ? $cita->servicio->precio : 0;
                        });

        return view('admin.dashboard', compact('salon', 'citasDia', 'citasFuturas', 'gananciasMes', 'fechaSeleccionada'));
    }

    // ✅ FUNCIÓN PARA CAMBIAR ESTADO DE CITA
    public function updateCitaStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completada,cancelada'
        ]);

        $cita = Cita::findOrFail($id);
        
        // Seguridad: Verificar dueño
        $miSalon = Salon::where('user_id', auth()->id())->first();

        // Usamos != para evitar problemas de tipos (string vs int)
        if (!$miSalon || $cita->salon_id != $miSalon->id) {
            abort(403, 'NO TIENES PERMISO PARA MODIFICAR ESTA CITA.');
        }

        $cita->estado = $request->status;
        $cita->save();

        return back()->with('success', 'Cita actualizada correctamente.');
    }
}