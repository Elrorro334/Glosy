<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <--- OBLIGATORIO
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'clients'; // Apuntamos a la tabla correcta

    // $guarded = [] permite guardar CUALQUIER campo sin restricciones
    protected $guarded = []; 

    protected $hidden = [
        'remember_token',
    ];
}