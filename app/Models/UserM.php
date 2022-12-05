<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserM extends Model
{
    protected $table='users';
    protected $fillable=
    ['id','name','email','image','email_verified_at','password','password2','ggId','status','idRole','remember_token','created_at','updated_at'];

    use HasFactory;
}
