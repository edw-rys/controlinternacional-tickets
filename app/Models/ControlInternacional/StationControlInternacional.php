<?php

namespace App\Models\ControlInternacional;

use Illuminate\Database\Eloquent\Model;

class StationControlInternacional extends Model
{
    protected $table = 'stations';
    protected $connection = 'control-backend';

		public function station_type()
    {
        return $this->belongsTo('App\Models\StationTypes');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }
}
