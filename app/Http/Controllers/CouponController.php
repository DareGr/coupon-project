<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Email;
use App\Models\Coupon;
use App\Models\CouponType;

use App\Models\UsedCoupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CouponPattern;
use App\Models\CouponSubtype;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\CouponAdminRequest;

class CouponController extends Controller
{
    public function create()
    {
        $coupon_types = CouponType::all();
        $coupon_subtypes = CouponSubtype::all();
       
        return view('coupon.create', compact('coupon_types', 'coupon_subtypes'));
    }

    public function store(CouponAdminRequest $request)
    {
        
        if($request->coupon_type != 2 && isset($request->limit))
        {
            return back()->withErrors(['message' => 'You can set limit only with multi-limit type.']);
        }

        if($request->coupon_type == 2 && $request->limit < 1)
        {
            return back()->withErrors(['message' => 'Limit can not be under 1']);
    
        }
        
        if(in_array($request->coupon_type, [3, 4]) && $request->valid_until < Carbon::now()->format('Y-m-d'))
        {
            return back()->withErrors(['message' => 'You can not set a date in the past.']);
          
        }

        if(!in_array($request->coupon_type, [3, 4]) && isset($request->valid_until))
        {
            return back()->withErrors(['message' => 'You can set date only with single-expires or multi-expires.']);
        }

        if($request->coupon_type == 2 && !isset($request->limit))
        {
            return back()->withErrors(['message' => 'You must set limit with multi-limit coupon.']);
        }

        if(in_array($request->coupon_type, [3, 4]) && !isset($request->valid_until))
        {
            return back()->withErrors(['message' => 'You must set date with expires coupons.']);
        }

        if(in_array($request->coupon_subtype, [1, 2]) && !isset($request->value))
        {
            return back()->withErrors(['message' => 'You must set a value.']);
        }

        if($request->coupon_subtype == 3 && isset($request->value))
        {
            return back()->withErrors(['message' => 'You can not set a value with free coupons.']);
        }

        if($request->coupon_subtype == 1 && !in_array($request->value, range(5, 95)))
        {
            return back()->withErrors(['message' => 'You must set value between 5 and 95.']);
        }
        
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL) && $request->coupon_type != 1 && $request->email != null) 
        {
            return back()->withErrors(['message' => 'Email is not valid']);
        }

        $coupon_code = strtoupper(Str::random(6));

        // Preparing data for coupon create.
        
        $data = [
            'creator_email' => $request->email,
            'coupon_type' => $request->coupon_type,
            'coupon_subtype' => $request->coupon_subtype,
            'code' => $coupon_code,
            'value' => $request->value,
            'limit' => $request->limit,
            'used_times' => $request->used_times,
            'valid_until' => $request->valid_until
        ];
    
        // Check if coupon type is single.

        if($request->coupon_type == 1)
        {
            if(empty($request->email))
            {
                return back()->withErrors(['message' => 'You must insert email with single coupon type!']);
            }

            $data['status'] = 'non-used';
    
            Coupon::create($data);
        }
        else
        {
            $data['status'] = 'active';
        
            Coupon::create($data);
        }
        
        return redirect('/admin_dashboard')->with('message', 'Coupon has been successfully created');
    }
    
    public function edit(Request $request)
    {
        $coupon = Coupon::where('id', $request->id)->first();
        
        return view('coupon.edit', compact('coupon'));
    }

    public function update(Request $request)
    {
        
        Coupon::where('id', $request->id)->update($request->except(['_token', '_method', 'id']));

        return redirect('/all_coupons')->with('message', "Coupon has been successfully updated");
    }

    public function delete(Request $request)
    {
        Coupon::destroy($request->id);

        return redirect('/all_coupons')->with('message', "Coupon has been successfully deleted");
    }
    
    public function all()
    {
        $coupons = Coupon::with('type', 'subtype')->paginate(10);
        
        $types = CouponType::all();
        $subtypes = CouponSubtype::all();
        
        $filter = true;

        return view('coupon.all', compact('coupons', 'types', 'subtypes', 'filter'));
    }

    public function active()
    {
        $coupons = Coupon::with('type', 'subtype')->where('status', '=', 'active')->paginate(10);
        
        $types = CouponType::all();
        $subtypes = CouponSubtype::all();
        
        $filter = true;

        return view('coupon.active', compact('coupons','types', 'subtypes', 'filter'));
    }

    public function used()
    {   
        $coupons = DB::table('used_coupons')
                ->join('coupons', 'coupons.id', '=', 'used_coupons.coupon_id')
                ->join('emails', 'emails.id', '=', 'used_coupons.user_id')
                ->join('coupon_types', 'coupons.coupon_type', '=', 'coupon_types.id')
                ->join('coupon_subtypes', 'coupons.coupon_subtype', '=', 'coupon_subtypes.id')
                ->select('coupon_types.type_name', 'coupon_subtypes.subtype_name', 'coupons.*', 'emails.*', 'used_coupons.*')
                ->paginate(10);
        
        $types = CouponType::all();
        $subtypes = CouponSubtype::all();
        
        $filter = true;

        return view('coupon.used', compact('coupons', 'types', 'subtypes', 'filter'));
    }

    public function non_used()
    {
        $coupons = Coupon::with('type', 'subtype')
                        ->where('status', '=', 'non-used')
                        ->paginate(10);
        
        $types = CouponType::all();
        $subtypes = CouponSubtype::all();
        
        $filter = true;

        return view('coupon.non_used', compact('coupons', 'types', 'subtypes', 'filter'));
        
    }
}
