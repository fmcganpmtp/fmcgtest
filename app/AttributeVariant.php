<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeVariant extends Model
{
    protected $table = 'attribute_variants';

    public $timestamps = false;
 
    protected $guarded = [];
    
}
