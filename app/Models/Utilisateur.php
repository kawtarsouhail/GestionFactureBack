<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Utilisateur extends Authenticatable implements AuthenticatableContract
{
    protected $fillable = [
        'nom', 'prenom', 'email', 'role', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}