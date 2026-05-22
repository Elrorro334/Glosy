<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        // Verificar sesión con guardia 'client'
        if (!Auth::guard('client')->check()) {
            return redirect()->route('login.cliente');
        }

        $client = Auth::guard('client')->user();

        // Traer citas
        $citas = Cita::where('client_id', $client->id)
                     ->with(['salon', 'servicio'])
                     ->orderBy('fecha_hora_inicio', 'desc')
                     ->get();

        $proximasCitas = $citas->filter(function ($cita) {
            return Carbon::parse($cita->fecha_hora_inicio)->isFuture() && $cita->estado != 'cancelada';
        });

        $historialCitas = $citas->filter(function ($cita) {
            return Carbon::parse($cita->fecha_hora_inicio)->isPast() || $cita->estado == 'cancelada';
        });

        return view('client.perfil', compact('client', 'proximasCitas', 'historialCitas'));
    }
}