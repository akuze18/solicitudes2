<?php

namespace App\Models;

use App\Repositories\EstadoRepository;

use Illuminate\Database\Eloquent\SoftDeletes;

class solicitudDetail extends MyModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'solicitude_details';
    protected $fillable =['solicitude_id','action','type_id','comments','estado_id','reference','observation'];

    public function batch(){
        return $this->belongsTo(solicitudBatch::class,'solicitude_id');
    }
    public function type(){
        return $this->belongsTo(solicitudType::class,'type_id');
    }
    public function fields(){
        return $this->hasMany(solicitudDetailField::class,'solicitude_detail_id');
    }
    public function actionObj(){
        return $this->belongsTo(solicitudAction::class,'action');
    }
    public function approbations(){
        return $this->hasMany(Approbation::class,'solicitude_detail_id');
    }
    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function getTitleAttribute(){
        $titulos =[];
        //dd($this->type->id);
        //$principals = $this->type->field_format()->where('title',1);
        $principals = $this->type->field_format;
        //dd($principals);
        foreach($principals as $principal){
            if($principal->title==1){
                $campoEspecial = $this->fields->where('format_field',$principal->id)->first();
                //dd($campoEspecial);
                array_push($titulos,$campoEspecial->value_field);
            }
        }
        return implode(' - ',$titulos);
    }

    public function getDisplayAttribute(){
        return $this->type->name.' ('.$this->actionObj->name.'): '.$this->title;
    }

    public function getMaxApprobationAttribute(){
        return $this->approbations()->count();
    }
    public function getActualApprobationAttribute(){
        $approbated = ApprobationAction::where('description','Aprobar')->first();
        return $this->approbations()->where('action_id',$approbated->id)->count();
    }

    public function scopeStatus($query,$estado){
        //$query = $query->where('id',$this->id);
        $estados = new EstadoRepository;
        if($estado=='OBJETADO'){$estado='ESPERA';}
        switch($estado){
            case 'ESPERA':
                return $query->whereIn('estado_id',[$estados->Espera()->id,$estados->Objetado()->id]);
            case 'ENVIADO':
                return $query->where('estado_id',$estados->Enviado()->id);
            case 'APROBADO':
                return $query->where('estado_id',$estados->Aprobado()->id);
            case 'RECHAZADO':
                return $query->where('estado_id',$estados->Rechazado()->id);
            default:
                return $query->where(false);

        }
    }
}
