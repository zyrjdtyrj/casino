<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gambler extends User
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bonus'
    ];

}
