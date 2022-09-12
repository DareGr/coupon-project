<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CouponPattern;
use App\Models\ActiveCoupon;
use App\Models\UsedCoupon;
use App\Models\Non_UsedCoupon;

class Coupon extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = []; 

    public function type()
    {
        return $this->hasOne(CouponType::class, 'id', 'coupon_type');
    }

    public function subtype()
    {
        return $this->hasOne(CouponSubtype::class, 'id', 'coupon_subtype');
    }
    
    public function pattern()
    {
        return $this->hasOne(CouponPattern::class, 'id', 'coupon_id');
    }

    public function active_coupons()
    {
        return $this->hasMany(ActiveCoupon::class);
    }

    public function used_coupons()
    {
        return $this->belongsTo(UsedCoupon::class);
    }

    public function non_used_coupons()
    {
        return $this->hasMany(Non_UsedCoupon::class);
    }
}

