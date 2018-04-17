<?php

namespace App\Models;


class ApprobationAction extends MyModel
{
    protected $fillable=['description', 'status'];

    public function estado(){
        return $this->belongsTo(Estado::class,'status');
    }
}
