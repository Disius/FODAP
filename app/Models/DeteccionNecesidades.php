<?php

namespace App\Models;

use GrahamCampbell\ResultType\Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeteccionNecesidades extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'deteccion_necesidades';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asignaturaFA', 'contenidosTM', 'numeroProfesores', 'periodo',
        'nombreCurso', 'fecha_I', 'fecha_F', 'hora_I', 'hora_F', 'objetivoEvento', 'tipo_FDoAP', 'tipo_actividad',
        'carrera_dirigido', 'observaciones', 'id_jefe', 'obs', 'aceptado', 'modalidad', 'facilitador_externo', 'total_horas', 'id_departamento', 'id_lugar', 'estado', 'anio_realizacion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_I',
        'fecha_F',
        'anio_realizacion'
    ];

    public function deteccion_facilitador(){
        return $this->belongsToMany(Docente::class, 'deteccion_has_facilitadores', 'deteccion_id', 'docente_id');
    }

    public function carrera(): HasOne
    {
        return $this->hasOne(Carrera::class, 'id', 'carrera_dirigido');
    }

    public function departamento(): HasOne
    {
        return $this->hasOne(Departamento::class, 'id', 'id_departamento');
    }

    public function jefe(): HasOne
    {
        return $this->hasOne(Docente::class, 'id', 'id_jefe');
    }

    public function docente_inscrito(): BelongsToMany
    {
        return $this->belongsToMany(Docente::class, 'inscripcion', 'curso_id', 'docente_id');
    }

    public function lugar(): BelongsTo {
        return $this->belongsTo(Lugar::class, 'id', 'id_lugar');
    }

    public function ficha_tecnica(): HasOne {
        return $this->hasOne(FichaTecnica::class, 'id_curso');
    }

    public function calificaciones_curso(){
        return $this->hasMany(Calificaciones::class, 'curso_id', 'id');
    }
}
