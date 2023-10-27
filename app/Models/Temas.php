<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Temas extends Model
{
    use HasFactory;

    protected $table = 'temas';

    protected $fillable = [
        'ficha_id', 'name_tema', 'tiempo_programado', 'act_aprendizaje'
    ];

    public function ficha_has_temas(): BelongsTo {
        return $this->belongsTo(FichaTecnica::class, 'ficha_id');
    }
}
