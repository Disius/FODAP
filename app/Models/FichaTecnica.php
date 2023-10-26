<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTecnica extends Model
{
    use HasFactory;


    protected $table = 'ficha_tecnica';

    protected $fillable = [
        'id_curso', 'introduccion', 'justificacion', 'objetivo_general',
        'descripcion_servicio', 'elementos_didacticos', 'competencias_desarrollar', 'fuentes_informacion', 'tipo_servicio',
        'duracion'
    ];

}
