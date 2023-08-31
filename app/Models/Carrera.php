<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrera extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'carreras';

    protected $fillable = [
        'nameCarrera', 'departamento_id'
    ];

    protected $primaryKey = 'id';

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }
    public function deteccion(): BelongsTo
    {
        return $this->belongsTo(DeteccionNecesidades::class, 'carrera_dirigido', 'id');
    }
}
