<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRegion extends Model 
{   
    
    protected $fillable = ['user_id','active_countries','expand_countries' ];
   

}
