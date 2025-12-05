<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    protected $guarded = 'admin';

    protected $fillable = [
        'name',
        'role',
        'mobile',
        'email',
        'password',
        'image',
        'status',
    ];
}