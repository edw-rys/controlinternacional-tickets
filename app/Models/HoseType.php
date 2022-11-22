<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoseType extends Model
{
    protected $table = 'hose_types';

    protected $fillable = [
        'id',
        'name',
        'code',
        'octane_type',
        'color',
        'active',
        'reference_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function hoses()
    {
        return $this->hasMany('App\Models\Hose');
    }
}
