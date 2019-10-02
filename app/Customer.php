<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'total_buy',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
