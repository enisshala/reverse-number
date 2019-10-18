<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'phone_data' => 'array',
    ];
}
