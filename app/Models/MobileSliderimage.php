<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileSliderimage extends Model
{
    use HasFactory;

    protected $fillable = [
        'slider_id','image','title','description','target','display_order'  
    ];
}
