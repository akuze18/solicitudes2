<?php

namespace App\Models;

class FormatList extends MyModel
{
    protected $table = 'format_list';
    protected $fillable = ['format_id','value','display'];

    public function format(){
        return $this->belongsTo(solicitudFormat::class,'format_id');
    }

    public function getNameFullAttribute(){
        return $this->display;
    }
}
