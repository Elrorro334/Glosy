<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    const ADMIN_EMAIL = 'contacto@rodnix.com.mx'; 

    /**
     * Seguridad manual infalible
     */
    private function checkAccess()
    {
        if (!Auth::check() || Auth::user()->email !== self::ADMIN_EMAIL) {
            abort(403, 'ACCESO DENEGADO: Zona restringida para Rodnix.');
        }
    }

    public function index(Request $request)
    {
        $this->checkAccess();

        $query = Salon::with('user')->latest();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nombre_negocio', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $salons = $query->paginate(20);

        return view('superadmin', compact('salons'));
    }

    // ✅ NUEVA FUNCIÓN: Suspender / Activar
    public function toggleStatus($id)
    {
        $this->checkAccess();

        $salon = Salon::findOrFail($id);
        
        // Invertimos el valor (si es true pasa a false, y viceversa)
        $salon->active = !$salon->active; 
        $salon->save();

        $status = $salon->active ? 'activado' : 'suspendido';
        
        return back()->with('success', "El salón ha sido $status correctamente.");
    }

    public function loginAs($id)
    {
        $this->checkAccess();
        $salon = Salon::findOrFail($id);
        
        if ($salon->user) {
            Auth::login($salon->user);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Este salón no tiene usuario asignado.');
    }

    public function destroy($id)
    {
        $this->checkAccess();

        DB::transaction(function () use ($id) {
            $salon = Salon::findOrFail($id);
            $user = $salon->user;
            $salon->delete();
            if ($user) {
                $user->delete();
            }
        });

        return back()->with('success', "Salón y Usuario eliminados correctamente.");
    }
}