<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoConvenio extends Model
{
    protected $fillable = [
        'nombreArchivo',
        'tipo_documento',
        'fecha_subida',
        'hora_subida',
        'convenio_id',
        'ruta',
    ];
}
