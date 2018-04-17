<?php

namespace App\Models;

class Menu extends MyModel
{
    protected $fillable=['header','contain','route','icon_name','parameter1','parameter2','permission','orderBy'];

    public function getParametersAttribute(){
        $parameter = [];
        if($this->parameter1){
            array_push($parameter,$this->parameter1);
        }
        if($this->parameter2){
            array_push($parameter,$this->parameter2);
        }
        return $parameter;
    }
}
