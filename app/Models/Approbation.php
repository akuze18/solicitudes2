<?php

namespace App\Models;

class Approbation extends MyModel
{
    protected $fillable=['id','solicitude_detail_id','solicitude_batch_id','order','action_id','format_id','approver_id','observation'];

    public function solicitud(){
        return $this->belongsTo(solicitudDetail::class,'solicitude_detail_id');
    }
    public function batch(){
        return $this->belongsTo(solicitudBatch::class,'solicitude_batch_id');
    }
    public function action(){
        return $this->belongsTo(ApprobationAction::class,'action_id');
    }
    public function formato(){
        return $this->belongsTo(ApprobationFormat::class,'format_id');
    }
    public function approver(){
        return $this->belongsTo(User::class,'approver_id');
    }


    public function getStatusAttribute(){
        if(is_null($this->action)){
            return 'Pendiente';
        }
        else{
            return $this->action->status;
        }
    }

    public function scopeBuscar($query, $id_batch){
        if (!is_null($id_batch)) {
            $batch = solicitudBatch::where('id', $id_batch)->first();
            $id_pisos = [];
            foreach ($batch->details as $detail) {
                array_push($id_pisos, $detail->id);
            }
            return $query->whereIn('solicitude_detail_id', $id_pisos);
        }
        else{
            return $query;
        }


    }
}
