<?php

namespace App\Models;

class solicitudType extends MyModel
{
    protected $table = 'solicitudes_type';
    protected $fillable = ['name','orderBy'];
    //protected $dateFormat = 'Ymj h:i:s.000';

    public function details(){
        return $this->hasMany(solicitudDetail::class,'type_id');
    }
    public function field_format(){
        return $this->hasMany(solicitudFormat::class,'solicitude_type_id');
    }
    public function actions(){
        return $this->hasMany(solicitudAction::class,'type');
    }

    public function getNamefullAttribute(){
        return $this->name;
    }

    public function getCamposAttribute(){
        return solicitudFormat::where('solicitude_type_id',$this->id)->orderBy('orderBy')->get();
    }
}
