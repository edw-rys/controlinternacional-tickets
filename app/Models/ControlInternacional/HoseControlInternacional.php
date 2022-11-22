<?php

namespace App\Models\ControlInternacional;

use Illuminate\Database\Eloquent\Model;

class HoseControlInternacional extends Model
{
    protected $connection = 'control-backend';
    protected $table = 'hoses';

    public function hose_type()
    {
        return $this->belongsTo('App\Models\ControlInternacional\HoseTypeControlInternacional');
    }
}
