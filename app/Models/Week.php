<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;
    protected $table='weeks';
    static public function getRecord(){
        return self::get();
    }
    static public function getWeekUsingName($week_name){
        return self::get()->where('name', $week_name)->first();
    }

}
