<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Comment\Doc;

class Plaza extends Model
{
    use HasFactory;

    protected $table = 'tipo_plaza';

    protected $fillable = [
        'nombre'
    ];

    public function docente_plaza(){
        return $this->belongsTo(Docente::class, 'tipo_plaza', 'id');
    }
}
