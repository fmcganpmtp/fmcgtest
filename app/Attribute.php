<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Attribute extends Model
{
    protected $table = 'attributes';
 
    protected $guarded = [];

    public function variants()
    {
        return $this->belongsToMany('App\Variant', 'attribute_variants');
    }

}
