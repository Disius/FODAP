<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaveValidacion extends Model
{
    use HasFactory;

    protected $table = 'clave_validacion';

    protected $fillable = [
        'curso_id', 'clave'
    ];

    public function curso_clave_validacion(){
        return $this->belongsTo(DeteccionNecesidades::class, 'curso_id');
    }
}
