<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class VendorSubmenu extends Model
{
    protected $table = 'vendor_submenu';
 
    protected $guarded = [];
    public function products()
    {
        return $this->hasMany(VendorProduct::class,'vendor_products.submenu_id');
    }
}
