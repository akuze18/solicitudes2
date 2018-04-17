<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class MyModel extends Model {
    //protected $dateFormat = 'Ymd H:i:s.000';    //Linea solo para SQL Server  // h:i:s.000A
    //protected $dateFormat = 'M j Y h:i:s:000A';
    protected function getNameFullAttribute(){
        return is_null($this->name) ? '' : $this->name;
    }
}