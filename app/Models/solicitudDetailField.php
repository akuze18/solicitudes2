<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class solicitudDetailField extends MyModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'solicitude_detail_field';
    protected $fillable =['solicitude_detail_id','format_field','value_field'];

    public function detail(){
        return $this->belongsTo(solicitudDetail::class,'solicitude_detail_id');
    }

    public function format(){
        return $this->belongsTo(solicitudFormat::class,'format_field');
    }

    public function getValorAttribute(){
        $tipo = $this->format->type_field;
        $newValor = $this->value_field;
        if($tipo=="select"){
            $lista_formato = FormatList::where('format_id',$this->format_field)
            ->where('id',$newValor)->first();
            $newValor = $lista_formato->display;
        }
        return $newValor;
    }
}
