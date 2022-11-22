<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hose extends Model
{
    protected $table = 'hoses';
    protected $fillable = [
        'id',
        'name',
        'current_seal',
        'color',
        'company_id',
        'station_id',
        'user_id',
        'hose_type_id',
        'active',
        'reference_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    public function hose_type()
    {
        return $this->belongsTo('App\Models\HoseType');
    }
}
