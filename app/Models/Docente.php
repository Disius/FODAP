<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Docente extends Model
{
    use HasFactory;
    protected $table = 'docente';

    protected $fillable = [ 'rfc', 'curp', 'nombre', 'apellidoPat', 'apellidoMat',
        'sexo', 'email', 'departamento_id', 'telefono', 'interno', 'carrera_id', 'user_id', 'id_puesto', 'tipo_plaza', 'licenciatura', 'id_posgrado', 'nombre_completo'
    ];

    public function facilitador_has_deteccion(){
        return $this->belongsToMany(DeteccionNecesidades::class, 'deteccion_has_facilitadores', 'docente_id', 'deteccion_id');
    }

    public function inscrito(){
        return $this->belongsToMany(DeteccionNecesidades::class, 'inscripcion', 'docente_id', 'curso_id');
    }

    public function deteccion(){
        return $this->hasMany(DeteccionNecesidades::class, 'id_jefe', 'id');
    }

    public function jefe_deteccion(){
        return $this->belongsTo(DeteccionNecesidades::class, 'id_jefe', 'id');
    }

    public function usuario(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function jefe_departamento(){
        return $this->belongsTo(Departamento::class, 'jefe_id', 'id');
    }
}
