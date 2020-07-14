<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $fillable = [
        "rut", "name", "phone", "email"
    ];
}
