<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $fillable = ['nombreEntidad', 'logo', 'ubicacion', 'contacto'];
}
