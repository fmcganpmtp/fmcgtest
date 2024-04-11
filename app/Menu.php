<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
 
class Menu extends Model
{
    protected $table = 'menu';
 
    protected $guarded = [];

    public function businessCategory()
    {
        return $this->belongsTo('App\BusinessCategory');
    }
}
