<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Docente extends Model
{
    use HasFactory;
    protected $table = 'docente';

    protected $fillable = [ 'rfc', 'curp', 'nombre', 'apellidoPat', 'apellidoMat',
        'sexo', 'email', 'departamento_id', 'telefono', 'interno', 'carrera_id', 'user_id', 'id_puesto', 'tipo_plaza', 'licenciatura', 'id_posgrado', 'nombre_completo'
    ];
    protected $primaryKey = 'id';

//    protected $with = ['inscrito', 'calificacion_docente'];
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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jefe_departamento(){
        return $this->belongsTo(Departamento::class, 'jefe_id', 'id');
    }

    public function academia_presidente(): BelongsTo {
        return $this->belongsTo(Carrera::class, 'presidente_academia', 'id');
    }

    public function posgrado(){
        return $this->hasOne(Posgrado::class, 'id', 'id_posgrado');
    }

    public function plaza(){
        return $this->hasOne(Plaza::class, 'id', 'tipo_plaza');
    }

    public function departamento(){
        return $this->hasOne(Departamento::class, 'id', 'departamento_id');
    }

    public function puesto(){
        return $this->hasOne(Puesto::class, 'id', 'id_puesto');
    }

    public function cvu(){
        return $this->hasOne(FilesCVU::class, 'id_docente', 'id');
    }
    public function carrera(){
        return $this->hasOne(Carrera::class, 'id', 'carrera_id');
    }

    public function calificacion_docente(){
        return $this->hasOne(Calificaciones::class, 'docente_id', 'id');
    }
}
