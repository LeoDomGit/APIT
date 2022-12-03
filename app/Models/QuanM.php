<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuanM extends Model
{
    protected $table='quantable';
    protected $fillable=['id','districtname','created_at','updated_at'];
    use HasFactory;
}
