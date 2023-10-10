<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdireccion extends Model
{
    use HasFactory;

    protected $table = 'subdireccion';

    protected $fillable = [
        'name'
    ];
}
