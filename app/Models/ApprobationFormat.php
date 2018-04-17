<?php

namespace App\Models;

class ApprobationFormat extends MyModel
{
    protected $fillable = ['solicitude_type_id','order','pattern_approver','wait','required'];
}
