<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table='settings';

    static public function getSingle(){
        return self::find(1);
    }
    public function getLogo(){
        if(!empty($this->logo) && file_exists('users/settings/'.$this->logo)){
            return url('users/settings/'.$this->logo);
    }else{
        return '';
    }
  }
    public function getFeviconIcon(){
        if(!empty($this->fevicon_icon) && file_exists('users/settings/'.$this->fevicon_icon)){
            return url('users/settings/'.$this->fevicon_icon);
    }else{
        return '';
    }
}
}
