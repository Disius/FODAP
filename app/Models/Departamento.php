<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamento';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nameDepartamento', 'jefe_id',
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

    public function carerras(): HasMany
    {
        return $this->hasMany(Carrera::class);
    }
    public function detecciones(): BelongsTo
    {
        return $this->belongsTo(DeteccionNecesidades::class, 'id_departamento', 'id');
    }


    public function jefe_docente(){
        return $this->hasOne(Docente::class, 'id', 'jefe_id');
    }

    public function docente_adscrito(){
        return $this->belongsTo(Docente::class, 'departamento_id', 'id');
    }
    public function user_departamento(){
        return $this->belongsTo(User::class, 'departamento_id', 'id');
    }

    public $timestamps = false;

}
