<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

        class User extends Authenticatable
    {
        use Notifiable;

        protected $guard = 'user';

        protected $fillable = [
            'name', 'email','order_total', 'password','username','phone','status','profile_pic','about','hide_promo_email','surname','position','country_id','usertype','company','address','seller_type','parent_id','token_number','varification_status','email_status'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
        function BuyerCompany() {
            return $this->hasOne('App\Models\BuyerCompany')->withDefault();
        }
        function CompanyRegion() {
            return $this->hasOne('App\Models\CompanyRegion')->withDefault();
        }
        function OrderDetail() {
            return $this->hasMany('App\Models\OrderDetail','user_id','id');
        }
        function SellerMessageUser() {
            return $this->hasMany('App\Models\SellerMessage','user_id','id');
        }
        function SellerMessageSeller() {
            return $this->hasMany('App\Models\SellerMessage','seller_id','id');
        }
        function Subscription() {
            return $this->hasMany('App\Models\Subscription','user_id','id');
        }
        function KycFile() {
            return $this->hasMany('App\Models\KycFile','user_id','id');
        }
        function SellerProduct() {
            return $this->hasMany('App\Models\SellerProduct','user_id','id');
        }
        function InsertedBy() {
            return $this->hasMany('App\Models\SellerProduct','inserted_by','id');
        }
        function SellerOpeningTime() {
            return $this->hasMany('App\Models\SellerOpeningTime','seller_id','id');
        }

        function ProductReview() {
            return $this->hasMany('App\Models\ProductReview','user_id','id');
        }
        function Country() {
        return $this->hasOne('App\Models\Country','id','country_id');
}
        
    }