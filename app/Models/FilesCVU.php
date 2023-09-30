<?php

namespace App\Models;

use App\Http\Controllers\DocenteController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesCVU extends Model
{
    use HasFactory;

    protected $table = 'files_cvu';

    protected $fillable = [
        'id_docente', 'path'
    ];


    public function docente_cvu(){
        return $this->belongsTo(Docente::class, 'id', 'id_docente');
    }


    public $timestamps = false;
}
