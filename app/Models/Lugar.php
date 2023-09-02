<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lugar extends Model
{
    use HasFactory;
    protected $table = 'lugar';


    protected $fillable = [
      'nombreAula'
    ];

    public function curso(): BelongsTo {
        return $this->belongsTo(DeteccionNecesidades::class, 'id_lugar', 'id');
    }


}
