<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temas extends Model
{
    use HasFactory;

    protected $table = 'temas';

    protected $fillable = [
        'ficha_id', 'name_tema', 'tiempo_programado', 'act_aprendizaje'
    ];
}
