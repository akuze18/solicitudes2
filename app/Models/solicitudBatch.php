<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class solicitudBatch extends MyModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'solicitudes';
    protected $fillable =['user_id','estado'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function details(){
        return $this->hasMany(solicitudDetail::class,'solicitude_id');
    }

    public function scopeMySolicitud($query,$estado){
        $query = $query->where('user_id',auth()->user()->id);
        if(!is_null($estado)){
            $ids = [];
            $details = solicitudDetail::status($estado)->get();
            foreach($details as $detail){
                array_push($ids,$detail->batch->id);
            }
            return $query->whereIn('id',$ids);
        }
        else{
            return $query;
        }
    }

    public function status($estado,$reference=false){
        if($reference){
            return $this->details()->status($estado)->whereNotNull('reference')->get();
        }
        else{
            return $this->details()->status($estado)->get();
        }

    }
}
