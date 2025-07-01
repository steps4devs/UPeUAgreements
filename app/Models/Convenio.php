<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreConvenio', 'descripcion', 'fecha_inicio', 'fecha_fin', 'estado', 'alcance',
        'convenio_creador', 'convenio_id_entidad', 'facultad_id', 'carrera_id',
        'ambito_1', 'ambito_2', 'ambito_3'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'convenio_id_entidad');
    }

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'facultad_id');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
    
    public function documentos()
    {
        return $this->hasMany(\App\Models\DocumentoConvenio::class, 'convenio_id');
    }
}
