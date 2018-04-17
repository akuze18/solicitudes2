<?php

namespace App\Models;

class solicitudeExecution extends MyModel
{

    public function imageable()
    {
        return $this->morphTo();
    }
}
