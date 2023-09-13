<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigDates extends Model
{
    use HasFactory;

    protected $table = 'config_dates';

    protected $fillable = [
        'fecha_inicio', 'fecha_final'
    ];

    protected $dates = [
      'fecha_inicio',
      'fehca_final'
    ];

    public $timestamps = false;
}
