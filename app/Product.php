<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    protected $table = 'products';
 
    protected $guarded = [];

    public function variation()
    {
        return Product::where('combination_key', $this->combination_key)->get();
    }

    
}
