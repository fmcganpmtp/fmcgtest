<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTax extends Model
{
    protected $table = 'product_taxs';

    public $timestamps = false;
 
    protected $guarded = [];

    public function tax()
    {
        return $this->belongsTo('App\Tax');
    }

}
