<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Coupon;
use App\Models\CouponType;
use App\Models\CouponSubtype;

class CouponPattern extends Model
{
    use HasFactory;

    // public $timestamps = false;
    protected $guarded = [];
    
    public function coupons()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function used_coupons()
    {
        return $this->belongsTo(UsedCoupon::class);
    }

    
}
