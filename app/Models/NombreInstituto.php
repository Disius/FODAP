<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NombreInstituto extends Model
{
    use HasFactory;

    protected $table = 'nombre_instituto';

    protected $fillable = [
        'name'
    ];
}
