<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\MiscellaneousMaster;
use App\Models\Coupon;
use Exception;
use JWTFactory;
use JWTAuth,JWTException;
use Validator,DB,Str;
use Response;

class RegisterController extends Controller
{
    //

    public function register(Request $request)
	{

		$validator = Validator::make($request->all(), [

            'name' => 'required',
            'password'=> 'required|min:6|confirmed',
			'mobile'=> 'required|numeric',
			'device_id'=> 'required',
			'fcm_token'=>'required'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}
        $otp = mt_rand(100000, 999999);

        $first_offer = Coupon::where([['is_active',1],['coupon_type','first_offer']])->first();
        $offer_months = MiscellaneousMaster::where([['status',1],['type','first_offer_months']])->first();
        $cust = Customer::where([['device_id',$request->device_id],['status',1]])->first();
		if($cust){
			$free_offer = 0;
		}
		else
		$free_offer = $first_offer->max_coupon_use;
        $offer_month = '+'.$offer_months->master_value.' months';
		$offer_vaild_to = date('Y-m-d', strtotime($offer_month));
		DB::beginTransaction();
		try {
			$customerPhoneExist = Customer::where([['mobile',$request->mobile],['otp_verified','!=',null],['status',1]])->first();
			if($customerPhoneExist != null){
				return response()->json(['success'=>false,'error'=>'Phone no already exists']);
			}
			Customer::where([['email',$request->email],['otp_verified','!=',null],['status',0]])->orWhere([['mobile',$request->mobile],['otp_verified','=',null],['status',0]])->delete();
				$customer = Customer::create([
                    'uuid' => (String) Str::uuid(),
                    'name' => $request->name,
					'email' => $request->email,
					'password' => bcrypt($request->password),
					'mobile' => $request->mobile,
					'device_id' => $request->device_id,
                    'otp' => $otp,
                    'free_offer'=>$free_offer,
                    'free_offer_valid_to'=>$offer_vaild_to
				]);
				DB::commit();
				sendNewSMS($request->mobile,"Your otp verification code is ".$otp);
				return response()->json(['success'=>true,'msg'=>'Otp sent succesfully','customer_details'=>$customer]);
			}
		catch (\Exception $e) {
				DB::rollback();
			    return response()->json($e->getMessage());
			}

    }


    public function verify(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'mobile' => 'required|numeric',
			'otp' => 'required|numeric',
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}

        $customer = Customer::where([['mobile',$request->mobile],['otp_verified',null],['otp_attempt','<=',10],['status',0]])->first();

		if($customer){
			$customer->increment('otp_attempt');
			if($request->otp == $customer->otp){
				$credentials = $request->only('mobile');
				$credentials['status'] = 0;
				try {

        			$token = JWTAuth::fromUser($customer);
        			$dt = date('Y-m-d H:i:s');
        			Customer::where('mobile',$request->mobile)->update(['status'=>1,'otp_verified'=>$dt]);
					return response()->json(['success' => true,'token'=>$token,'customer_details'=>['name'=>$customer->name,'mobile'=>$customer->mobile,'id'=>$customer->id]]);
				} catch (JWTException $e) {
				            // something went wrong whilst attempting to encode the token
					return response()->json(['success' => false, 'error' => 'Failed to login, please try again.']);
				}
				        // all good so return the token
			}
			else{
				return response()->json(["success"=>false,"msg"=>"Invalid Otp"]);
			}
		}
		else{
			return response()->json(["success"=>false,"msg"=>"Invalid User"]);
		}

	}

	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'mobile'=> 'required|numeric',
            'password'=> 'required',

		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}
		$credentials = $request->only('mobile', 'password');
		$credentials['status'] = 1;

		 try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Your username or password is incorrect']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
		// all good so return the token
		if(auth('api')->user()->email != null){
			$r_email = auth('api')->user()->email;
		}
		else{
			$r_email = "";
		}
        return response()->json(['success' => true, 'token' => $token, 'customer_details' => [
                    'name'          => auth('api')->user()->name,
                    'email'         => $r_email,
                    'mobile'         => auth('api')->user()->mobile,
                    'device_id'         => auth('api')->user()->device_id,
                    'id'            => auth('api')->user()->id
                ] ]);
    }

    public function resendOtp(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'mobile'=> 'required|numeric'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}
		if (Customer::where([['mobile', '=', $request->mobile],['status',0]])->exists()) {
                $otp = mt_rand(100000, 999999);
                try{
                    $update = Customer::where([['mobile',$request->mobile],['status',0],['otp_verified',null]])->update(['otp_attempt'=>0,'otp'=>$otp]);
					sendNewSMS($request->mobile,"Your otp verification code is ".$otp);
					return response()->json(['success'=>true,'msg'=>'Otp sent successfully']);
                }
                catch(\Exception $e){
                    return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
                }


			}
			else{
				return response()->json(['success'=>false,'error'=>'The phone no does not exist']);
			}

	}



}
