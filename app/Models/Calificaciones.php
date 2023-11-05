<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';
    protected $primaryKey = 'id';


    protected $fillable = [
        'calificacion', 'docente_id', 'curso_id',
    ];

    public function docente_calificacion(){
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function curso_calificaciones(){
        return $this->belongsTo(DeteccionNecesidades::class, 'curso_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('docente_calificacion', function ($builder) {
            $builder->with('docente_calificacion');
        });
    }
}
