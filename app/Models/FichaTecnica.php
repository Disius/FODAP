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
        'temas', 'actividades_aprendizaje', 'elementos_didacticos',
        'criterio_evaluacion', 'competencias', 'bibliografia'
    ];

    public $timestamps = false;
}
