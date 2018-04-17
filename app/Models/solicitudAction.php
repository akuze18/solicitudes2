<?php

namespace App\Models;

class solicitudAction extends MyModel
{
    protected $table='solicitudes_action';
    protected $fillable =['code','name','orderBy','type'];

    public function tipo(){
        return $this->belongsTo(solicitudType::class,'type');
    }

}
