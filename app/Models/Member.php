<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'firstname',
        'email',
        'registrationToken',
        'password',
        'newsletter',
        'registrationDate',
        'expirationDate',
        'subscriptionHistory',
        'reset',
        'lessons_history',
        'lmsAccessExpiration'
    ];
}
