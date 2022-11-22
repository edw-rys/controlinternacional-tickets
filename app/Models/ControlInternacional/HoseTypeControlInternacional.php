<?php

namespace App\Models\ControlInternacional;

use Illuminate\Database\Eloquent\Model;

class HoseTypeControlInternacional extends Model
{
    protected $connection = 'control-backend';
    protected $table = 'hose_types';

    public function hoses()
    {
        return $this->hasMany('App\Models\ControlInternacional\HoseControlInternacional');
    }
}
