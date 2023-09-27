<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;

    protected $table = 'puesto';

    protected $fillable = [
      'nombre'
    ];

    public function puesto_docente(){
        return $this->belongsTo(Docente::class, 'id_puesto', 'id');
    }
}
