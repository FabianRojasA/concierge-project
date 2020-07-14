<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        "name", "lastname", "phone", "email", "rut"
    ];
}
