<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriosEvaluacion extends Model
{
    use HasFactory;

    protected $table = "criterios_evaluacion";

    protected $fillable = [
        'ficha_id', 'criterio', 'valor', 'instrumento_evaluacion'
    ];
}
