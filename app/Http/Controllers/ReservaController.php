<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Salon;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        // 1. SEGURIDAD: Verificar que sea una CLIENTA logueada
        // Usamos el guard 'client' específicamente
        if (!Auth::guard('client')->check()) {
            // Si no está logueada, guardamos a dónde quería ir y la mandamos a Google
            session(['volver_al_salon' => url()->previous()]);
            return redirect()->route('google.login')
                   ->with('error', 'Por seguridad, inicia sesión con Google para agendar.');
        }

        $client = Auth::guard('client')->user(); // Obtenemos la clienta de la tabla 'clients'

        // 2. VALIDACIÓN DE DATOS
        $request->validate([
            'salon_id' => 'required|exists:salons,id',
            'servicio_id' => 'required|exists:servicios,id',
            'cliente_telefono' => 'required|numeric|digits:10', // 10 dígitos exactos
            'fecha' => 'required|date|after_or_equal:today', 
            'hora' => 'required',
        ], [
            'cliente_telefono.digits' => 'El teléfono debe tener 10 dígitos.',
            'cliente_telefono.numeric' => 'Solo números en el teléfono.',
        ]);

        // 3. VALIDAR DISPONIBILIDAD DEL SALÓN
        $salon = Salon::findOrFail($request->salon_id);
        if (!$salon->active) {
            return back()->with('error', 'Este salón no está aceptando citas por el momento.');
        }

        // 4. LÓGICA DE TIEMPO
        $fechaHoraInicio = Carbon::parse($request->fecha . ' ' . $request->hora);
        
        if ($fechaHoraInicio->lt(Carbon::now()->subMinutes(5))) {
            return back()->with('error', 'No puedes agendar en el pasado.');
        }
        if ($fechaHoraInicio->hour < 7 || $fechaHoraInicio->hour > 21) {
            return back()->with('error', 'El salón está cerrado en ese horario (7am - 9pm).');
        }

        // 5. VALIDAR SERVICIO Y CHOQUES DE HORARIO
        $servicio = Servicio::findOrFail($request->servicio_id);
        if ($servicio->salon_id != $salon->id) abort(403);

        $fechaHoraFin = $fechaHoraInicio->copy()->addMinutes((int) $servicio->duracion_minutos);

        $conflicto = Cita::where('salon_id', $request->salon_id)
            ->where('estado', '!=', 'cancelada')
            ->where(function ($query) use ($fechaHoraInicio, $fechaHoraFin) {
                $query->where(function ($q) use ($fechaHoraInicio, $fechaHoraFin) {
                    $q->where('fecha_hora_inicio', '<', $fechaHoraFin)
                      ->whereRaw('DATE_ADD(fecha_hora_inicio, INTERVAL (SELECT duracion_minutos FROM servicios WHERE id = citas.servicio_id) MINUTE) > ?', [$fechaHoraInicio]);
                });
            })
            ->exists();

        if ($conflicto) {
            return back()->with('error', '¡Ese horario ya está ocupado! Intenta otro.');
        }

        // 6. ACTUALIZAR TELÉFONO DEL CLIENTE
        // Como Google no nos da el teléfono, lo guardamos ahora que lo ingresó en el form
        $client->update(['telefono' => $request->cliente_telefono]);

        // 7. GUARDAR LA CITA
        $cita = Cita::create([
            'salon_id' => $request->salon_id,
            'servicio_id' => $request->servicio_id,
            'client_id' => $client->id,           // ID de tabla clients
            'cliente_nombre' => $client->nombre,  // Snapshot del nombre
            'cliente_telefono' => $request->cliente_telefono,
            'fecha_hora_inicio' => $fechaHoraInicio,
            'estado' => 'confirmada' // Confirmada porque ya validamos identidad
        ]);

        // 8. REDIRIGIR A WHATSAPP
        $telefonoDuena = preg_replace('/[^0-9]/', '', $salon->telefono_publico);
        
        if (empty($telefonoDuena)) {
            return redirect()->route('perfil.index')->with('success', 'Cita agendada correctamente.');
        }

        Carbon::setLocale('es');
        $fechaTexto = ucfirst($fechaHoraInicio->translatedFormat('l j \d\e F'));

        $mensaje = "Hola! Soy *{$client->nombre}* 👋\n";
        $mensaje .= "Acabo de reservar desde Glosy ✅.\n\n";
        $mensaje .= "💅 *Servicio:* {$servicio->nombre}\n";
        $mensaje .= "📅 *Fecha:* {$fechaTexto}\n";
        $mensaje .= "⏰ *Hora:* " . $fechaHoraInicio->format('h:i A') . "\n";
        $mensaje .= "📱 *Mi Cel:* {$request->cliente_telefono}\n\n";
        $mensaje .= "¡Nos vemos!";

        $linkWhatsApp = "https://wa.me/521{$telefonoDuena}?text=" . urlencode($mensaje);

        return redirect()->away($linkWhatsApp);
    }
}