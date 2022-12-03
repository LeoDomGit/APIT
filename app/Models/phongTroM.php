<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phongTroM extends Model
{
    protected $table='roomtable';
    protected $filable=['id','roomname','address','price','phone','image','dientich','mota','idQuan','status','created_at','updated_at'];
    use HasFactory;
}
