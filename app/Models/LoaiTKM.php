<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiTKM extends Model
{
    use HasFactory;
    protected $table='userrole';
    protected $fillable=[
    'id',
    'name',
    'status',
    'created_at',
    'updated_at']
    ;
}
