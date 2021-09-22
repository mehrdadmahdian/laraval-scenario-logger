<?php

namespace Tests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends AuthUser
{
    protected $guarded= ['id'];
    use HasFactory;
}
