<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Vendor extends Model
{
    protected $table = 'vendors';
 
    protected $guarded = [];

    public function orders()
    {
        return Order::where('vendor_id', $this->id)->where('status', 'delivered')->get();
    }

    public function businessCategories()
    {
        return $this->belongsToMany(BusinessCategory::class, 'vendor_business_categories', 'vendor_id', 'business_category_id');
        // return $this->hasMany('App\VendorBusinessCategory');
    }

    public function vendorWorkingHours()
    {
        return $this->hasMany('App\VendorWorkingHours');
    }


}
