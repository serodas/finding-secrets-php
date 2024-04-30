<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    protected $table = 'secrets';
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'location_name'
    ];
}
