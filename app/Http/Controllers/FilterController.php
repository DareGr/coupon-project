<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponType;
use Illuminate\Http\Request;
use App\Models\CouponPattern;
use App\Models\Email;
use Illuminate\Support\Facades\DB;

use App\Models\CouponSubtype;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;


class FilterController extends Controller
{
    public function filter(Request $request)
    {
        
        if($request->current_table == 'coupon.all')
        {
            $coupons = Coupon::query()
                    ->join('coupon_types', 'coupons.coupon_type', '=', 'coupon_types.id')
                    ->join('coupon_subtypes', 'coupons.coupon_subtype', '=', 'coupon_subtypes.id')
                    ->select('coupon_types.type_name', 'coupon_subtypes.subtype_name', 'coupons.*');
        }
        elseif($request->current_table == 'coupon.active')
        {
            $coupons = Coupon::query()
                    ->join('coupon_types', 'coupons.coupon_type', '=', 'coupon_types.id')
                    ->join('coupon_subtypes', 'coupons.coupon_subtype', '=', 'coupon_subtypes.id')
                    ->where('status', '=', 'active')
                    ->select('coupon_types.type_name', 'coupon_subtypes.subtype_name', 'coupons.*');
        }
        elseif($request->current_table == 'coupon.used')
        {
            $coupons = DB::table('used_coupons')
                ->join('coupons', 'coupons.id', '=', 'used_coupons.coupon_id')
                ->join('emails', 'emails.id', '=', 'used_coupons.user_id')
                ->join('coupon_types', 'coupons.coupon_type', '=', 'coupon_types.id')
                ->join('coupon_subtypes', 'coupons.coupon_subtype', '=', 'coupon_subtypes.id')
                ->select('coupon_types.type_name', 'coupon_subtypes.subtype_name', 'coupons.*', 'emails.*', 'used_coupons.*');
            
        }
        elseif($request->current_table == 'coupon.non_used')
        {
            $coupons = Coupon::query()
                    ->join('coupon_types', 'coupons.coupon_type', '=', 'coupon_types.id')
                    ->join('coupon_subtypes', 'coupons.coupon_subtype', '=', 'coupon_subtypes.id')
                    ->where('status', '=', 'non-used')
                    ->select('coupon_types.type_name', 'coupon_subtypes.subtype_name', 'coupons.*');
        }
        elseif($request->current_table == 'email.all')
        {
            $coupons = DB::table('emails')->select('emails.*');
        }

        $coupons->when(request('used_at', false), function ($q, $used_at) { 
            return $q->where('used_at', '>', $used_at);
        });
        $coupons->when(request('used_to', false), function ($q, $used_to) { 
            return $q->where('used_at', '<', $used_to);
        });         
        $coupons->when(request('created_at', false), function ($q, $created_at) { 
            return $q->where('created_at', '>', $created_at);
        });
        $coupons->when(request('created_to', false), function ($q, $created_to) { 
            return $q->where('created_at', '<', $created_to);
        });
        $coupons->when(request('coupon_type', false), function ($q, $coupon_type) { 
            return $q->where('coupon_type', $coupon_type);
        });
        $coupons->when(request('coupon_subtype', false), function ($q, $coupon_subtype) { 
            return $q->where('coupon_subtype', $coupon_subtype);
        });
        $coupons->when(request('value', false), function ($q, $value) { 
            return $q->where('value', $value);
        });
        $coupons->when(request('status', false), function ($q, $status) { 
            return $q->where('status', $status);
        });
        $coupons->when(request('used_times', false), function ($q, $used_times) { 
            return $q->where('used_times', $used_times);
        });
        $coupons->when(request('coupons_used', false), function ($q, $coupons_used) { 
            return $q->where('coupons_used', $coupons_used);
        });
        $coupons->when(request('creator_email', false), function ($q, $creator_email) { 
            return $q->where('creator_email', $creator_email);
        });
        $coupons->when(request('email', false), function ($q, $email) { 
            return $q->where('email', $email);
        });
        
        
        $coupons = $coupons->get();
        
        $types = CouponType::all();
        $subtypes = CouponSubtype::all();
        $filter = false;
        
        return view($request->current_table, compact('coupons', 'types', 'subtypes', 'filter'));

    }
}
