<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Address extends Model
{
    protected $table = 'address';
 
    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
