<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','rut','first_name', 'last_name', 'email', 'password','rol_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    public function getRutStyleAttribute(){
        $rutA = str_split($this->rut);
        $maxL = count($rutA)-1;
        $full = '';
        for($i=$maxL;$i>=0;$i--){
            $full = $rutA[$i]. $full;
            if(($maxL-$i)==0){
                $full = '-'. $full;
            }
            elseif(($maxL-$i)%3==0 and $i!=0){
                $full = '.'. $full;
            }
        }
        return $full;
    }

    public function solicitudes(){
        return $this->hasMany(solicitudBatch::class);
    }
}
