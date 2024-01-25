<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FichaTecnica extends Model
{
    use HasFactory;


    protected $table = 'ficha_tecnica';

    protected $fillable = [
        'id_curso', 'introduccion', 'justificacion', 'objetivo_general',
        'descripcion_servicio', 'elementos_didacticos', 'competencias_desarrollar', 'fuentes_informacion', 'tipo_servicio',
        'duracion'
    ];

    protected $with = ['temas', 'evaluacion_criterio', 'curso_ficha'];
    public function curso_ficha(): BelongsTo {
        return $this->belongsTo(DeteccionNecesidades::class, 'id_curso');
    }

    public function temas(): HasMany {
        return $this->hasMany(Temas::class, 'ficha_id');
    }

    public function evaluacion_criterio(): HasMany {
        return $this->hasMany(CriteriosEvaluacion::class, 'ficha_id');
    }

}
