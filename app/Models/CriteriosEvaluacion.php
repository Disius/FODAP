<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CriteriosEvaluacion extends Model
{
    use HasFactory;

    protected $table = "criterios_evaluacion";

    protected $fillable = [
        'ficha_id', 'criterio', 'valor', 'instrumento_evaluacion'
    ];

    public function ficha_has_criterios(): BelongsTo
    {
        return $this->belongsTo(FichaTecnica::class, 'ficha_id');
    }
}
