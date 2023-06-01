<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserRegisterResource;
use App\Http\Resources\UserResource;
use App\Models\User;
// use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\WelcomeEmailNotification;
use App\Http\Requests\LoginRequest;
use App\Events\LoginHistory;
use App\Events\UserWelcomeEmail;

class AuthController extends Controller
{

    protected function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'password' => 'required',
            // 'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $otp = Str::random(4);

        // Convert string to uppercase and split it into an array of characters
        // $upperCaseOTP = strtoupper($generateOTP);
        // $characters = str_split($upperCaseOTP);
        //implode characters to get spaces between them
        // $otp = implode(' ', $characters);

        $user = new User();
        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->password = Hash::make($validatedData['password']);
        $user->otp = $otp;
        $user->otp_expiry = Carbon::now()->addMinutes(5); // Set OTP to expire after 5 minutes

        $user->save();

        $token = $user->createToken('userToken', ['api'])->plainTextToken;

        //  $user->notify(new WelcomeEmailNotification($user));

        // Dispatch the WelcomeEmail event with the newly created user as a parameter
        event(new UserWelcomeEmail($user));

        return response()->json(['success' => true, 'message' => 'Registration Successful', 'data' => $token], Response::HTTP_CREATED);

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

        // Query the users table to retrieve the user by email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Validate the password using Hash::check()
            if (Hash::check($password, $user->password)) {
                Auth::guard('api')->setUser($user);

                $authUser = auth()->guard('api')->user();

                $token = $user->createToken('apiToken', ['api']);

                return response()->json([
                    'success' => true,
                    'message' => 'log in successful',
                    'token' => $token->plainTextToken
                ], Response::HTTP_ACCEPTED);
            } else {
                $response = ['success' => false, "message" => "Password mismatch"];

                return response($response, 422);
            }
        } else {
            $response = ['success' => false, "message" =>'User does not exist'];
            return response($response, 422);
        }

        return response()->json(['success' => false, 'message' => 'Invalid Credentials']);
        event(new LoginHistory($user));

    }


    public function logout(Request $request) {

         if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $user->currentAccessToken()->delete();
            // Auth::guard('veuserdor')->logout();
            // $vendor->logout();
            return response(['success' => true, 'message' => 'You have been successfully logged out!']);
        }
    }

    public function user()
    {
        $user = Auth::guard('api')->user();

        return (new UserResource($user));

        // return (new UserResource($user))->additional([
        //     'permissions' => $user->permissions()
        // ]);
    }

    public function updateInfo(UpdateUserInfoRequest $request)
    {

        $user = Auth::guard('api')->user();

        $user->update($request->only('first_name', 'last_name'));

        return response()->json([
            'success' => true,
            'data' => new UserResource($user)], Response::HTTP_ACCEPTED
        );
    }

    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        $user = Auth::guard('api')->user();

        $user->update(['password' => Hash::make($request->input('password'))]);

        return response(['message' => 'Password updated successfully'], Response::HTTP_ACCEPTED);
    }

    //  public function pickupLocations(): array
    // {
    //     $pickupLocations = PickupLocation::all();

    //     return [
    //         'status' => 1,
    //         'pickup_locations' => $pickupLocations,
    //     ];
    // }





  /**
   * Handle api request for otp verification
   *
   * @param \App\Models\User $user
   * @param \App\Http\Requests\Api\User\VerifyOtpRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   * @author Abdullah Al-Faqeir <abdullah@devloops.net>
   */
//   public function verifyOtp(User $user, VerifyOtpRequest $request): JsonResponse {
//     if (!$request->failed()) {
//       if ($user->getOtp() === $request->otp) {
//         $user->status = (string) UserStatus::ACTIVE;
//         $user->save();

//         return JsonResponse::create(
//           [
//             'status' => 1,
//           ]
//         );
//       }

//       return JsonResponse::create(
//         [
//           'status' => 0,
//           'error' => __('Invalid OTP.'),
//         ]
//       );
//     }

//     return JsonResponse::create(
//       [
//         'status' => 0,
//         'error' => $request->errors()->first(),
//       ]
//     );
//   }


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



//  public function currentlyLoggedInArtisans()
//  {
//   $getCurrentlyLoggedIn = $this->user::where(["isOnline"=>1,"status"=>0])->get(["firstname","lastname","email","id","isOnline"]);
//   return response()->json([
//     'success' => true,
//     "data"=>$getCurrentlyLoggedIn
// ],200);
// }

// public function loggedIn(Request $request)
// {
//     $validator = Validator::make($request->all(),
//     [
//         "id"=>"required|integer",
//     ]);


//     if($validator->fails()){
//       return response()->json([
//        "success"=>false,
//        "message"=>$validator->messages()->toArray(),
//       ],400);
//   }

//   $user = $this->user->find($id);
//   if (!$user) {
//       return response()->json([
//           'success' => false,
//           'message' => 'Sorry, user with id ' . $id . ' cannot be found'
//       ], 400);
//   }
//    $user->isOnline = 1;
//    if($user->save()){
//       return response()->json([
//           'success' => true,
//           "message"=>"user last location updated successfully"
//       ],200);
//      }
// }

// public function loggedOut()
// {
//     $validator = Validator::make($request->all(),
//     [
//         "id"=>"required|integer"
//     ]);


//     if($validator->fails()){
//       return response()->json([
//        "success"=>false,
//        "message"=>$validator->messages()->toArray(),
//       ],400);
//   }

//   $user = $this->user->find($id);
//   if (!$user) {
//       return response()->json([
//           'success' => false,
//           'message' => 'Sorry, user with id ' . $id . ' cannot be found'
//       ], 400);
//   }
//    $user->isOnline = 0;
//    if($user->save()){
//       return response()->json([
//           'success' => true,
//           "message"=>"user last location updated successfully"
//       ],200);
//      }
// }



// public function AddSocialMediaAccount(Request $request,$id)
// {
//     $validator = Validator::make($request->all(),
//     [
//         "facebook_handle"=>"required|string",
//         "instagram_handle"=>"required|string"
//     ]);


//     if($validator->fails()){
//       return response()->json([
//        "success"=>false,
//        "message"=>$validator->messages()->toArray(),
//       ],400);
//   }

//   $user = $this->user->find($id);
//   if (!$user) {
//       return response()->json([
//           'success' => false,
//           'message' => 'Sorry, user with id ' . $id . ' cannot be found'
//       ], 400);
//   }


//  $user->facebook_handle = $request->facebook_handle;
//  $user->instagram_handle = $request->instagram_handle;
//  if($user->save()){
//     return response()->json([
//         'success' => true,
//         "message"=>"social media account updated"
//     ],200);
//    }
// }


// public function GetSocialMediaAccount($id)
// {
//     $user = $this->user->find($id);
//     if (!$user) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Sorry, user with id ' . $id . ' cannot be found'
//         ], 400);
//     }

//  $facebook_handle = $user->facebook_handle;
//  $instagram_handle = $user->instagram_handle;
//  $data = array("facebook_handle"=>$facebook_handle,"instagram_handle"=>$instagram_handle);
//     return response()->json([
//         'success' => true,
//         "data"=>$data
//     ],200);
// }



// public function AddBankDetails(Request $request,$id)
// {
//     $validator = Validator::make($request->all(),
//     [
//         "account_number"=>"required|integer",
//         "gaurantors_name"=>"required|string",
//         "bank_name"=>"required|string"
//     ]);


//     if($validator->fails()){
//       return response()->json([
//        "success"=>false,
//        "message"=>$validator->messages()->toArray(),
//       ],400);
//   }

//   $user = $this->user->find($id);
//   if (!$user) {
//       return response()->json([
//           'success' => false,
//           'message' => 'Sorry, user with id ' . $id . ' cannot be found'
//       ], 400);
//   }


//  $user->gaurantors_name = $request->gaurantors_name;
//  $user->bank = $request->bank_name;
// $user->account_number = $request->account_number;
//  if($user->save()){
//     return response()->json([
//         'success' => true,
//         "message"=>"social media account updated"
//     ],200);
//    }
// }

// public function GetBankDetails($id)
// {
//     $user = $this->user->find($id);
//     if (!$user) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Sorry, user with id ' . $id . ' cannot be found'
//         ], 400);
//     }

//  $bank = $user->bank;
//  $account_number = $user->account_number;
//  $gaurantors_name = $user->gaurantors_name;
//  $data = array("bank"=>$bank,"account_number"=>$account_number,"gaurantors_name"=>$gaurantors_name);
//     return response()->json([
//         'success' => true,
//         "data"=>$data
//     ],200);
// }









 /**
   * Handle api request for resending otp code
   *
   * @param \App\Models\User $user
   *
   * @return \Illuminate\Http\JsonResponse
   * @author Abdullah Al-Faqeir <abdullah@devloops.net>
   */
//   public function resendOtp(User $user): JsonResponse {
//     SendOtp::dispatch($user);
//     return JsonResponse::create(
//       [
//         'status' => 1,
//       ]
//     );
//   }

  /**
   * Handle facebook social login request
   *
   * @param string $fbId
   *
   * @return \Illuminate\Http\JsonResponse|null
   * @author Abdullah Al-Faqeir <abdullah@devloops.net>
   */
//   public function socialLogin(string $fbId): ?JsonResponse {
//     try {
//       $User = User::withFacebookId($fbId)->firstOrFail();
//       $User->firebase_token = request()->get('firebase_token');
//       $User->save();
//       return JsonResponse::create(
//         [
//           'status' => 1,
//           'user' => $User,
//           'access_token' => ($User->token() ?? $User->createToken('facebookToken'))->accessToken,
//         ]
//       );
//     } catch (Exception $exception) {
//       return JsonResponse::create(
//         [
//           'status' => 0,
//         ]
//       );
//     }
//   }

  /**
   * Log user in, in case the phone number doesn't exist, create a new user and inform the api
   *
   * @param UserLoginRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   * @author Abdullah Al-Faqeir <abdullah@devloops.net>
   */
//   public function login(UserLoginRequest $request): JsonResponse {
//     if (!$request->failed()) {
//       /**
//        * @var $User User
//        */
//       $User = User::withPhoneNumber($request->phone_number)->get()->first();
//       $Response = [
//         'status' => 1,
//       ];

//       if ($User === NULL) {
//         return JsonResponse::create(
//           [
//             'status' => 0,
//             'error' => __('Phone number not registered.'),
//           ]
//         );
//       }

//       if ((int) $User->status === UserStatus::INACTIVE) {
//         SendOtp::dispatch($User);
//         return JsonResponse::create(
//           [
//             'status' => 2,
//             'user_id' => $User->id,
//           ]
//         );
//       }

//       try {
//         $http = new Client();
//         $response = $http->post(env('APP_URL') . '/oauth/token', [
//           'form_params' => [
//             'grant_type' => 'password',
//             'client_id' => env('API_CLIENT_ID'),
//             'client_secret' => env('API_CLIENT_SECRET'),
//             'username' => $User->phone_number,
//             'password' => $request->password,
//             'scope' => '*',
//             'provider' => 'users',
//           ],
//           //'verify' => false,
//         ]);

//         $AccessTokenResponse = json_decode((string) $response->getBody(), TRUE);
//         $User->firebase_token = $request->firebase_token;
//         $Response['access_token'] = $AccessTokenResponse;
//         $Response['user'] = $User;

//         return JsonResponse::create($Response);
//       } catch (ClientException $e) {
//         switch ($e->getCode()) {
//           case 400:
//           case 401:
//             return JsonResponse::create(
//               [
//                 'status' => 0,
//                 'error' => __('Your credentials are incorrect. Please try again'),
//                 'code' => $e->getCode(),
//                 'message' => $e->getMessage(),
//               ]
//             );
//           default:
//             return JsonResponse::create(
//               [
//                 'status' => 0,
//                 'error' => __('Something went wrong, please try again.'),
//                 'code' => $e->getCode(),
//                 'message' => $e->getMessage(),
//               ]
//             );
//         }
//       }
//     }

//     return JsonResponse::create(
//       [
//         'status' => 0,
//         'error' => $request->errors()->first(),
//       ]
//     );
//   }


}
