<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    public $timestamps = false;
 
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function variantOption()
    {
        return $this->belongsTo('App\VariantOption');
    }

}
