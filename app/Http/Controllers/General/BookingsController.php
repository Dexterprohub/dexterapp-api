<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Booking;


// class BookingsController extends Controller
// {
//     //

//     // protected $bookings;
//     // public function __construct()
//     // {
//     //     $this->Booking = new Booking;
//     // }

//     public function index(Request $request) {   
//         //laravel automatically converts it to json and sends a response text too
//         //$auth = auth("admins")->authenticate($request->token);
       
//         // $bookings = $this->Booking::all();
//         $bookings = Booking::all();
        
//         return response()->json([
//             'success' => true,
//             'data' => $bookings,    
//         ]);
    

//     }


//     public function getBooking(Request $request, $id) {
//         $bookings =  Booking::where(["id" => $id])->get()->toArray();
//         return response()->json([
//             'success'=>true,
//             'data'=>$bookings,
//         ]);
//     }

//     public function BookingForParticularUser(Request $request, $id) {
    
//         $bookings =  Booking::where(["user_id" => $id])->get();
//         return response()->json([
//             'success'=> true,
//             'data'=> $bookings,
//         ]);            
//     }

//     public function BookingForParticularVendor(Request $request, $id) {

//         $bookings =  Booking::where(["vendor_id" => $id])->get();
//         return response()->json([
//             'success'=>true,
//             'data'=> $bookings,
//         ]);        
//     }


//     //booking/ booking_id/status/status_d
//     //booking/booking_id/set-status/status_id

//     //this function sets status of booking depending on the parameter passed one or two
//     public function setBookingStatusId(Request $request, $booking_id, $status_id){
    
//     $update_status = "";
//     $updateData = Booking::where(["id" => $booking_id])->count();

//     if($updateData == 0){
//         return response()->json([
//             "success" => false,
//             "message" => "invalid booking id entered",
//             ],400
//         );    
//     }

//     if($status_id == 1){
//         $update_status = 0;
//     }else if($status_id == 2){
//         $update_status = 1;
//     }else if ($status_id == 3){
//         $update_status = 2;
//     }else if ($status_id == 4){
//         $update_status = 3;
//     }
    
//     $booking_data = Booking::where(["id" => $booking_id])->update(["status" => $update_status]);
//     if($booking_data){
//         return response()->json([
//             'success'=> true,
//             "message" => "Booking status set successffully"
//             ]);
//         }

//     }

//     //pending booking for artisan  booking/pending-artisan/artisan_id/getstatus/status
//     public function getPendingBookingForArtisan(Request $request,$status,$artisan_id)
//     {
//     $pending_bookings = $this->Bookings::where(["artisan_id"=>$artisan_id])->count();
//     if($pending_bookings==0){
//         return response()->json([
//                 "success"=>false,
//                 "message"=>"invalid booking artsan id entered",
//                 ],400);    
//     } 

//     $getData = $this->Bookings::where(["artisan_id"=>$artisan_id,"status"=>0])->get()->toArray();

//     return response()->json([
//                 'success'=>true,
//                 'data'=>$getData,
//             ]);
//     }

//     //pending booking for a user  booking/pending-user/user_id/getstatus/status
//     public function getPendingBookingForUser(Request $request, $user_id, $status) {

//         $pending_bookings = Booking::where(["user_id" => $user_id])->count();
//         if ($pending_bookings == 0){
//             return response()->json([
//                 "success" => false,
//                 "message" => "invalid booking user " . $user_id . "entered",
//             ],400);    
//         } 

//         $getData = Booking::where(["user_id" => $user_id, "status" => 0])->get();

//         return response()->json([
//             'success'=>true,
//             'data'=>$getData,
//         ]); 
//     }


//     //bookings/get-approved/customers_id
//     public function getAllwhereUsersIdEqualsCustomersIdAndIsApproved(Request $request, $customers_id)
//     {
//     $check_id = Booking::where(["user_id" => $customers_id])->count();
//     if($check_id == 0){
//         return response()->json([
//             "success" => false,
//             "message" => "invalid booking user id entered",
//         ],400);    
//     }

//     $getData = Booking::where(["user_id" => $customers_id, "status"=> 1])->get();

//     return response()->json([
//             'success' => true,
//             'data' => $getData,
//         ]);
//     }
// }
