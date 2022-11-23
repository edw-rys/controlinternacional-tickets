<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait ;
use Spatie\MediaLibrary\HasMedia\HasMedia ;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use /*HasFactory,*/ HasMediaTrait;

    protected $fillable = [
        
        'name',
        'description',
        'designation',
        'image',
    ];

    protected $guarded = ['id']; 
}
