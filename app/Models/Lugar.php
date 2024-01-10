<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lugar extends Model
{
    use HasFactory;
    protected $table = 'lugar';


    protected $fillable = [
      'nombreAula', 'ocupado'
    ];

    public function curso(){
        return $this->belongsTo(DeteccionNecesidades::class, 'id_lugar', 'id');
    }

    public $timestamps = false;
}
