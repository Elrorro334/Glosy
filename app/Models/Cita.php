<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class); // Laravel buscar¨¢ autom¨¢ticamente 'client_id'
    }
}