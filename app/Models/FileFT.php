<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileFT extends Model
{
    use HasFactory;

    protected $table = "ficha_file";

    protected $fillable = [
      'id_curso', 'path',
    ];
}
