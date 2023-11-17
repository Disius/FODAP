<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaveCurso extends Model
{
    use HasFactory;

    public $table = "clave_curso";

    protected $fillable = [
        'curso_id', 'clave'
    ];

    public function curso_clave(){
        return $this->belongsTo(DeteccionNecesidades::class, 'curso_id');
    }
}
