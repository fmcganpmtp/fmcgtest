<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Variant extends Model
{
    protected $table = 'variants';
 
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany('App\VariantOption');
    }
}
