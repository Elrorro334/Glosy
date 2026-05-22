<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salon;
use App\Models\Servicio;

class SettingsController extends Controller
{
    public function index()
    {
        $salon = Salon::where('user_id', auth()->id())->with('servicios')->firstOrFail();
        return view('admin.settings', compact('salon'));
    }

    public function updateSalon(Request $request)
    {
        $request->validate([
            'nombre_negocio' => 'required|string|max:191',
            'descripcion'    => 'nullable|string|max:500',
            'horario_texto'  => 'nullable|string|max:100',
            'telefono_publico' => 'nullable|string|max:20',
            'direccion'      => 'nullable|string', // Aquí guardaremos las coordenadas o link
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $salon = Salon::where('user_id', auth()->id())->firstOrFail();

        // Logo
        if ($request->hasFile('logo')) {
            if ($salon->logo_url && file_exists(public_path($salon->logo_url))) {
                @unlink(public_path($salon->logo_url));
            }
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $salon->logo_url = 'uploads/' . $filename;
        }

        $salon->nombre_negocio = $request->nombre_negocio;
        $salon->descripcion = $request->descripcion;
        $salon->horario_texto = $request->horario_texto;
        $salon->telefono_publico = $request->telefono_publico;
        $salon->direccion = $request->direccion; // Guardado directo
        $salon->save();

        return back()->with('success', 'Configuración guardada correctamente.');
    }

    public function storeServicio(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:5',
        ]);

        $salon = Salon::where('user_id', auth()->id())->firstOrFail();

        Servicio::create([
            'salon_id' => $salon->id,
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'duracion_minutos' => $request->duracion_minutos,
        ]);

        return back()->with('success', 'Servicio creado.');
    }

    public function updateServicio(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:5',
        ]);

        $servicio = Servicio::findOrFail($id);
        
        // 🔒 SEGURIDAD MANUAL INFALIBLE
        // Buscamos el ID del salón del usuario actual
        $miSalonId = Salon::where('user_id', auth()->id())->value('id');

        // Comparamos números. Si el servicio no pertenece a mi salón, error.
        if ($servicio->salon_id != $miSalonId) {
            abort(403, 'No tienes permiso para editar este servicio.');
        }

        $servicio->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'duracion_minutos' => $request->duracion_minutos,
        ]);

        return back()->with('success', 'Servicio actualizado.');
    }

    public function destroyServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        $miSalonId = Salon::where('user_id', auth()->id())->value('id');
        
        if ($servicio->salon_id != $miSalonId) {
            abort(403);
        }

        $servicio->delete();
        return back()->with('success', 'Servicio eliminado.');
    }
}