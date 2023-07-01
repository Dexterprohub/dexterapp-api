<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\Vendor\UpdateVendorInfoRequest;
use App\Http\Requests\Vendor\UpdateVendorPasswordRequest;
use App\Http\Requests\Vendor\VendorRegisterRequest;
use App\Http\Resources\Vendor\VendorRegisterResource;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use App\Models\VendorService;
use App\Http\Requests\VendorLoginRequest;
use Auth;
use Hash;
use Validator;
use Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Auth\AuthenticationException;
use App\Providers\RouteServiceProvider;
use App\Notifications\VendorWelcomeEmailNotification;
use App\Models\Basicdetail;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\SanitizeController;
use App\Events\SendVerificationOTPEvent;
use App\Events\VendorWelcomeEmailEvent;
use App\Http\Resources\GetAuthVendorResource;
class VendorAuthController extends Controller
{

    public function register(VendorRegisterRequest $request){

        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:vendors|max:255',
            'phone' => 'required|min:6',
            'password' => 'required',
            // 'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $otp = rand(1000,9999);

        // Convert string to uppercase and split it into an array of characters
        // $otp = strtoupper($generateOTP);
        // $characters = str_split($upperCaseOTP);
        //implode characters to get spaces between them
        // $otp = implode(' ', $characters);

        $vendor = new Vendor();
        $vendor->first_name = $validatedData['first_name'];
        $vendor->last_name = $validatedData['last_name'];
        $vendor->email = $validatedData['email'];
        $vendor->phone = $validatedData['phone'];
        $vendor->password = Hash::make($validatedData['password']);
        $vendor->otp = $otp;
        $vendor->otp_expiry = Carbon::now()->addMinutes(5); // Set OTP to expire after 5 minutes

        $vendor->save();

        Auth::guard('vendor')->setUser($vendor);

        $authUser = auth()->guard('vendor')->user();

        $token = $vendor->createToken('vendorToken', ['vendors']);


        // $vendor->notify(new VendorWelcomeEmailNotification($vendor));

        // Dispatch the WelcomeEmail event with the newly created user as a parameter
        event(new VendorWelcomeEmailEvent($vendor));

        // Dispatch the SendVerificationOTP event with the newly created user as a parameter
        event(new SendVerificationOTPEvent($vendor, $otp));

        return response([
            'success' => true,
            'message' => 'Registration successful',
            'token' => $token->plainTextToken,
        ], Response::HTTP_CREATED);

    }

    public function login(Request $request){

        // Validate login form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve credentials from the request
        $email = $request->input('email');
        $password = $request->input('password');

        // Query the vendors table to retrieve the vendor by email
        $vendor = Vendor::where('email', $email)->first();

        if ($vendor) {
            // Validate the password using Hash::check()
            if (Hash::check($password, $vendor->password)) {
                Auth::guard('vendor')->setUser($vendor);

                $authUser = auth()->guard('vendor')->user();

                $token = $vendor->createToken('vendorToken', ['vendors']);

                return response()->json([
                    'success' => true,
                    'message' => 'log in successful',
                    'token' => $token->plainTextToken,
                ], Response::HTTP_ACCEPTED);
            } else {
                $response = ['success' => false, "message" => "Password mismatch"];

                return response($response, 422);
            }
        } else {
            $response = ['success' => false, "message" =>'User does not exist'];
            return response($response, 422);
        }

    }

    public function storeVendorType(Request $request){

        $validatedData = $request->validate([
            'vendor_id' => 'required |exists:vendors,id',
            'service_id' => 'required |exists:services,id',
        ]);

        $vendor = Vendor::findOrFail($validatedData['vendor_id']);

        $vendor->service_id = $validatedData['service_id'];
        $vendor->save();

        return response()->json(['success' => true, 'message' => 'Vendor service stored', 'service' => $vendor->service]);
    }

    public function getAuthVendor(){
        $vendor = Auth::guard('vendor')->user();

        $vendor->load('shop');

        return response()->json(['success' => true, 'data' => $vendor ]);
    }

    public function logout(Request $request) {
        if (Auth::guard('vendor')->check()) {
            $vendor = Auth::guard('vendor')->user();
            // $vendor = $this->getAuthVendor();
            $vendor->currentAccessToken()->delete();
            // Auth::guard('vendor')->logout();
            // $vendor->logout();
            return response(['success' => true, 'message' => 'You have been successfully logged out!']);
        }

    }

    public function update(Request $request)
    {

        $vendor = Auth::guard('vendor')->user();

        $validatedData = $request->validate(
            [
                'state' => 'required',
                'city' => 'required',
                'street' => 'required',
            ]
        );

        if($request->hasFile('image')){

            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();

            if(SanitizeController::CheckFileExtensions($image_extension,array("png","jpg","jpeg","PNG","JPG","JPEG"))==FALSE){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Sorry, this is not an image please ensure your images are png or jpeg files'
                    ], 500
                );
            }

            $rename_image = uniqid()."_".time().date("Ymd")."_IMG.".$image_extension; //change file name

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'vendor/updatedVendor'])->getSecurePath();

            if($upload){
               $vendor->image = $upload;
               $vendor->save();
            }
        }

        $vendor->update($request->only('first_name', 'last_name', 'qualification', 'nin', 'state', 'city', 'street'));

        // $vendor->first_name = $request->first_name;
        // $vendor->last_name = $request->last_name;
        // $vendor->qualification = $request->qualification;
        // $vendor->nin = $request->nin;
        // $vendor->state = $validatedData['state'];
        // $vendor->city = $validatedData['city'];
        // $vendor->street = $validatedData['street'];



        return response()->json(['success' => true, 'message' => 'Detail updated successfully', 'detail' => $vendor]);

    }


    public function updatePassword(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();

        $vendor->update(['password' => Hash::make($request->password)]);

        // return response(new VendorResource($vendor), Response::HTTP_ACCEPTED);
        return response(['message' => 'Password updated successfully'], Response::HTTP_ACCEPTED);
    }

    public function verifyOTP(Request $request)
    {
        // Get vendor input
        $vendorInput = $request->otp;
        $validatedData = $request->validate([
            'email' => 'required|exists:vendors,email',
            'otp' => 'required'
        ]);
        // Retrieve the vendor by email
        $vendor = Vendor::where('email', $validatedData['email'])->first();

        // Compare vendor input with saved OTP
        if ($vendor && $vendor->otp === $validatedData['otp'] &&  Carbon::now()->lt($vendor->otp_expiry) ) {
            // Update verify_at column
            $vendor->email_verified_at = Carbon::now();
            $vendor->save();

            return response()->json(['success' => true, 'message' => 'Email verification successful'], Response::HTTP_ACCEPTED);
        } else {
            // Invalid OTP, show error
            return response()->json(['otp' => 'Invalid OTP. Please try again.']);
        }
    }

    public function resendOTP(Request $request){

        // $validatedData = $request->validate([
        //     'email' => 'required|email |exists:vendors,email'
        // ]);


        $vendor = Auth::guard('vendor')->user();

        $email = $vendor->email;

        if (!$email) {
            return response()->json(['message' => 'User not found or OTP session expired'], 404);
        }

        // Generate new OTP
        $otp = rand(1000, 9999);


        // Update user's OTP session data
        $vendor->otp = $otp;
        $vendor->otp_expiry = now()->addMinutes(5);
        $vendor->save();

        // Send OTP via SMS, email, etc.
        // Dispatch the SendVerificationOTP event with the newly created user as a parameter
        event(new SendVerificationOTPEvent($vendor, $otp));

    }

    // public function changePassword(Request $request){
    //     $user = Auth::user();
    //     $oldpass = $request->old_password;
    //     $ok = password_verify($oldpass, $user->password);
    //     if ( $ok == true) {
    //         if($request->new_password == $request->confirm__password){
    //             $user->password = bcrypt($request->new_password);
    //             $user->save();
    //             return response()->json(['data' => $user, 'message' => 'User Password Updated successfully'],200);
    //         } else {
    //             return response()->json(['message' => 'Password doesn\'t match'],200);
    //         }
    //     } else {
    //         return response()->json(['message' => 'Old password doesn\'t match'],200);
    //     }
    // }





    // public function login(){
    //     if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
    //         $user = Auth::user();
    //         $success['token'] = $user->createToken('mandu')->accessToken;
    //         $user->api_token = $success['token'];
    //         $user->save();
    //         return response()->json(['success' => $success], 200);
    //     } else {
    //         return response()->json(['error' => 'Unauthorised'], 401);
    //     }
    // }

    // public function register(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'c_password' => 'required|same:password',
    //         'phone' => 'required|numeric',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json(['error' => $validator->errors()], 401);
    //     }

    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $user = User::create($input);
    //     $success['token'] = $user->createToken('mandu')->accessToken;
    //     $user->api_token = $success['token'];
    //     $user->save();
    //     $success['name'] = $user->first_name.' '.$user->last_name;
    //     return response()->json(['success'=>$success], 200);
    // }

    // public function logout(Request $request)
    // {
    //     $user = Auth::guard('api')->user();

    //     if ($user) {
    //         $user->api_token = null;
    //         $user->save();
    //     }

    //     return response()->json(['data' => 'User logged out.'], 200);
    // }
}
