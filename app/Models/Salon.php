<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relaci車n: Un sal車n tiene muchos servicios
    public function servicios() {
        return $this->hasMany(Servicio::class);
    }

    // Relaci車n: Un sal車n pertenece a un Usuario (ESTA ES LA QUE FALTABA)
    public function user() {
        return $this->belongsTo(User::class);
    }
}