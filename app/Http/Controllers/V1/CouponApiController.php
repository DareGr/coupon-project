<?php

namespace App\Http\Controllers\V1;

use DateTime;

use Carbon\Carbon;
use App\Models\Email;
use App\Models\Coupon;
use App\Models\CouponType;
use App\Models\UsedCoupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CouponSubtype;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CouponRequest;
use App\Http\Resources\V1\CouponResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\V1\CouponCollection;


class CouponApiController extends Controller
{
   /**
    * Function for coupon create.
    */

    public function store(CouponRequest $request)
    {
        
        if(!in_array($request->coupon_type, range(1, 5)))
        {
            return response()->json([
                'status' => false,
                'message' => 'Set valid coupon type id.'
            ]);
        }

        if(!in_array($request->coupon_subtype, range(1, 3)))
        {
            return response()->json([
                'status' => false,
                'message' => 'Set valid coupon subtype id.'
            ]);
        }

        if($request->coupon_type != 2 && isset($request->limit))
        {
            return response()->json([
                'status' => false,
                'message' => 'You can set limit only with multi-limit type.'
            ]);
        }

        if($request->coupon_type == 2 && $request->limit < 1)
        {
            return response()->json([
                'status' => false,
                'message' => 'Limit can not be under 1!'
                ]);
        }

        // Validation for check does it date set for non expires coupon type.

        if(!in_array($request->coupon_type, [3, 4]) && isset($request->valid_until))
        {
            return response()->json([
                'status' => false,
                'message' => 'You can set date only with single-expires or multi-expires.'
            ]);
        }

        if(in_array($request->coupon_type, [3, 4]))
        {
            $format = ('Y-m-d');
            $d = DateTime::createFromFormat($format, $request->valid_until);
             $res = $d && $d->format($format) == $request->valid_until;
         
            if($res === false) {
                return response()->json([
                    'status' => false,
                    'message' => 'You must set valid date format.'
                ]);
            }

        }
        
        if(in_array($request->coupon_type, [3, 4]) && $request->valid_until < Carbon::now()->format('Y-m-d'))
        {
            return response()->json([
                'status' => false,
                'message' => 'You can not set a date in the past.'
            ]);
        }

        // Validation for check does it limit set for multi-limit coupon type.

        if($request->coupon_type == 2 && !isset($request->limit))
        {
            return response()->json([
                'status' => false,
                'message' => 'You must set limit with multi-limit coupon.'
            ]);
        }

        // Validation for check does it date set for expires coupon type.

        if(in_array($request->coupon_type, [3, 4]) && !isset($request->valid_until))
        {
            return response()->json([
                'status' => false,
                'message' => 'You must set date with expires coupons.'
            ]);
        }

        // Validation for check does it value set for %off and flat coupon subtype.

        if(in_array($request->coupon_subtype, [1, 2]) && !isset($request->value))
        {
            return response()->json([
                'status' => false,
                'message' => 'You must set a value'
            ]);
        }

        // Validation for check does it value set for free coupon subtype.

        if($request->coupon_subtype == 3 && isset($request->value))
        {
            return response()->json([
                'status' => false,
                'message' => 'You can not set a value with free coupons'
            ]);
        }

        // Validation for define percentage range for %off coupon subtype.

        if($request->coupon_subtype == 1 && !in_array($request->value, range(5, 95)))
        {
            return response()->json([
                'status' => false,
                'message' => 'You must set value between 5 and 95.'
            ]);
        }

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL) && $request->coupon_type != 1 && $request->email != null) 
        {
            return response()->json([
                'status'  => 'False',
                'data_error' => "Email is not valid"
        ]);
        }

        ////////////////////////////////////////////////////////////////////////////////////

        // Generating random coupon code 

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
                return response()->json([
                    'status' => false,
                    'message' => 'You must insert email with single coupon type!'
                ]);
            }
            
            if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) 
            {
                return response()->json([
                    'status'  => 'False',
                    'data_error' => "Email is not valid"
            ]);
            }

            $data['status'] = 'non-used';
    
            return new CouponResource(Coupon::create($data));
        }
        
        // If coupon type is not single. 
        
        $data['status'] = 'active';
        
        return new CouponResource(Coupon::create($data));
    }

    
    /**
    * Function for coupon use.
    */

    public function use(Request $request)
    {
        // Finding coupon based on code.

        $coupon = Coupon::where('code', $request->code)->first();
        
        
        if(!$coupon)
        {
            return response()->json([
                'status' => false,
                'message' => 'Coupon code does not exist!'
            ]);
        }

        if($coupon->coupon_type == 1)
        {
            $coupon = Coupon::where([
                'creator_email' => $request->email,
                'code' => $request->code
            ])->first();
            
            
            if(!$coupon)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Email is not owner of this coupon!'
                ]);
            }

            if($coupon->status == "used")
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Email is already used that coupon!'
                ]);
            }

            Coupon::where('id', $coupon->id)->update(['status' => 'used']);

        } elseif($coupon->coupon_type == in_array($coupon->coupon_type, [2, 3]))
        {

            $email = Email::where('email', $request->email)->first();
            
            if($email)
            {
            $used_coupon = UsedCoupon::where('user_id', $email->id)
                                    ->where('coupon_id', $coupon->id);

            if($used_coupon->exists())
            {
                return response()->json([
                'status' => false,
                'message' => 'You can use only one coupon per email address!'
                ]);
            }
            }
           
            if($coupon->used_times == $coupon->limit && $coupon->limit != null)
            {
                $coupon->status = 'inactive';
                $coupon->update();
                
                return response()->json([
                    'status' => false,
                    'message' => 'You can not use coupon because limit is reached!'
                    ]);
            }

            if(in_array($coupon->coupon_type, [3, 4]) && Carbon::now()->toDateString() > ($coupon->valid_until))
            {
                $coupon->status = 'inactive';
                $coupon->update();

                return response()->json([
                    'status' => false,
                    'message' => 'You can not use coupon because date is expired!'
                    ]);
            }

        } elseif($coupon->coupon_type == 4)
        {
          
            if(Carbon::now()->toDateString() > ($coupon->valid_until))
            {
                $coupon->status = 'inactive';
                $coupon->update();

                return response()->json([
                    'status' => false,
                    'message' => 'You can not use coupon because date is expired!'
                    ]);
            }
        } 
        
        $coupon->used_times++;
        $coupon->update();

        $email = Email::where('email', $request->email)->first();
            
        if(!$email)
        {
            $email = Email::create([
                'email' => $request->email
            ]);
        }

        if($email->first_coupon_use == null)
        {
            $email->update([
                'first_coupon_use' => Carbon::now()
            ]);
        }
        else
        {
            $email->update([
                'last_coupon_use' => Carbon::now()
            ]);
        }
            
        $email->coupons_used++;
        $email->save();
        
        UsedCoupon::create([
            'coupon_id' => $coupon->id,
            'user_id' => $email->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Coupon is valid!'
        ]);
    }
}
