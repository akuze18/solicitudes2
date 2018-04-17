<?php

namespace App\Models;

class solicitudFormat extends MyModel
{
    protected $table = 'solicitudes_format';
    protected $fillable = ['solicitude_type_id','name_field','type_field','long_field','orderBy','required','title'];
    protected $casts = [
        'required' => 'boolean',
        'title' => 'boolean',
    ];

    public function type(){
        return $this->belongsTo(solicitudType::class,'solicitude_type_id');
    }

    public function formatLists(){
        return $this->hasMany(FormatList::class,'format_id');
    }

    public function getNameDisplayAttribute(){
        $value = preg_replace('/(?<=\\w)(?=[A-Z])/'," $1", $this->name_field);
        $value = trim($value);
        return $value;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($solicitudes_format) {
            $actual = $solicitudes_format->name_field;
            $actual = ucwords($actual);
            $actual = str_replace(' ','',$actual);
            $solicitudes_format->name_field = $actual;
        });
    }
}
