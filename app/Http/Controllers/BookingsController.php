<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Booking;
use App\Models\Vendor;
use App\Http\Requests\BookingsStoreRequest;
use App\Http\Requests\BookingsUpdateRequest;
use App\Events\ServiceRequestBroadcasted;
use Validator;
use Auth;


class BookingsController extends Controller
{

    public function index() {   
        //laravel automatically converts it to json and sends a response text too
        //$auth = auth("admins")->authenticate($request->token);
    
        $bookings = Booking::all();

        return response()->json([
            'success' => true,
            'data'=> $bookings,    
        ], Response::HTTP_ACCEPTED);

    }

    public function getBooking(Request $request, $id) {
        $bookings =  Booking::find($id);
        return response()->json([
            'success'=> true,
            'data'=>$bookings,
        ]);
    }


    //booking/ booking_id/status/status_d
    //booking/booking_id/set-status/status_id

    //this function sets status of booking depending on the parameter passed one or two
    public function setBookingStatusId(Request $request, $booking_id, $status_id) {
        $update_status = "";
        $updateData = Booking::where(["id" => $booking_id])->count();

        if($updateData == 0){
            return response()->json([
                "success" => false,
                "message" => "invalid booking id entered" 
            ]);    
        }

        if ($status_id == 1){
            $update_status = 0;
        } else if($status_id == 2){
            $update_status = 1;
        }

        $booking_data = Booking::where(["id" => $booking_id])->update(["status" => $update_status]);
        
        if($booking_data){
            return response()->json([
                'success'=>true,
                "message"=>" bookng set successffully"
            ]);
        }
    }

    public function store(Request $request){      
        
        $user = \Auth::user();

        $validatedData = $request->validate( 
            [
                'user_id' => 'required | exists:users,id',
                'service_id' => 'required | exists:services,id',
                //'vendor_id' => 'required | exists:vendors,id',
                'item_id' => 'nullable | exists:items,id',
                'optional_service_item' => 'nullable | required_without:item_id',
                'scheduledDate' => 'required',
                'period' => 'required',
                'message' => 'required',
                'image' => 'nullable',
                'address' => 'required'
            ]
        );

        
        // Determine which service item to use
        // $itemId = $validatedData['item_id'];
        // if (empty($itemId) && !empty($validatedData['optional_service_item'])) {
        //     $itemId = null;
        // }

        $status = 'pending';
        $payment_status = 'pending';
        $payment_method = 'payment on delivery';

        $booking = new Booking();
        
        $booking->user_id = $user->id; 
        $booking->vendor_id = $request->vendor_id;
        $booking->service_id = $validatedData['service_id'];
        $booking->item_id = $request->item_id;
        $booking->optional_service_item = $request->optional_service_item; 
        $booking->scheduledDate = $validatedData['scheduledDate']; 
        $booking->period = $validatedData['period']; 
        $booking->message = $validatedData['message'];
        $booking->address = $validatedData['address'];
        $booking->status = $status;
        $booking->payment_status = $payment_status;
        $booking->payment_method = $payment_method;

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
            
            // $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'bookings'])->getSecurePath();
            $booking->image = '';
            // if($upload){
            // }
            
        }

        $booking->save();

        if($booking){
            // Notify all vendors associated with the service
            

            // Get all vendors associated with the service
            $vendors = Vendor::whereHas('service', function ($query) use ($request) {
                $query->where('id', $request->service_id);
            })->get();

            // Broadcast the service request to vendors online status is 1
            event(new ServiceRequestBroadcasted($booking));

            return response()->json([
                'success' => true,
                'message' => 'booking placed successfully',
                'data' => $booking,
            ], Response::HTTP_ACCEPTED);

        } else{
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Service not booked',
            ], 500);
        }   
        
        // Check if the requested service item is available for the vendor
        // $vendor = Vendor::find($request->vendor_id);
        // $itemId = $request->item_id;
        // $serviceItem = $vendor->items()->where('id', $itemId)->first();
        // if (!$serviceItem) {
        //     return response()->json(['error' => 'The requested service item is not available for the vendor.'], 422);
        // }

        // if the optional service item field is not empty, we set the service_item_id to null
        // if (!empty($validatedData['optional_service_item'])) {
        //     $booking->item_id = null;
        // }
    }

    public function acceptBooking(Request $request, $id){

        $booking = Booking::find($id);
        $vendor = Auth::guard('vendor')->user();
        $serviceId = $booking->service_id;
        $itemId = $booking->item_id;
        $status = 'accepted';
        $validatedData = $request->validate(['price' => 'required']);
        // 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
        // Update the vendor_id, status, price,  and expiry_time columns on the bookings table
        $booking->vendor_id = $vendor->id;
        $booking->status = $status;
        $booking->price = $validatedData['price'];
        $booking->expiry_time = \Carbon::now()->addMinutes(1);
        $booking->save();

        return response()->json(['success' => true, 'message' => 'booking accepted', 'status' => $booking->status]);

        // // Find all vendors associated with the service and service item
        // $vendors = Vendor::whereHas('service', function ($query) use ($serviceId) {
        //     $query->where('service_id', $serviceId);
        // })->get();
        

        // // Find all accepted bookings for the current user and service
        // $acceptedBookings = Booking::where('user_id', 2)
        //     ->where('service_id', $serviceId) 
        //     ->where('item_id', $itemId)
        //     ->where('status', $status)
        //     ->with(['vendor' => function ($query) {
        //         $query->select('id', 'first_name', 'last_name', 'email', 'phone', 'image');
        //     }])->orderBy('updated_at', 'asc')
        // ->get();

        // // Create an empty array to hold the sorted list of vendors
        // $sortedVendors = [];

        // // Loop through the accepted bookings to get the vendors
        // foreach ($acceptedBookings as $bookie) {
            
        //     $sortedVendors[] = [
        //         'vendor_name' => $bookie->vendor->first_name . ' ' . $bookie->vendor->last_name,
        //         'email' => $bookie->vendor->email,
        //         'phone' => $bookie->vendor->phone,
        //         'image' => $bookie->vendor->image,
        //         'price' => $bookie->price,
        //         'accepted_at' => $bookie->updated_at,
        //     ];
        //     return $sortedVendors;
        //     // Check if the vendor has already been added to the sorted list
        //     $vendorIndex = array_search($bookie->vendor_id, array_column($sortedVendors, 'id'));
            
        //     // If the vendor is not in the sorted list, add them
        //     if ($vendorIndex === false) {
                
        //         $vendor = $bookie->vendor;
                
        //         $sortedVendors[] = $vendor;
        //     }
        // }

        // // Return the sorted list of vendors
        // return $sortedVendors;
    }

    public function broadcastBookingAccepted(Request $request, $bookingId)
    {
        $booking = Booking::find($request->bookingId);
        $vendors = $booking->vendors()->where('is_vendor', 1)->orderBy('updated_at', 'ASC')->get();
       // $vendors = $booking->item->service->vendors()->where('status', 1)->orderBy('pivot_created_at', 'ASC')->get();

        $vendorPrices = [];
        foreach ($vendors as $vendor) {
            $vendorPrices[] = [
                'vendor_id' => $vendor->id,
                'vendor_name' => $vendor->first_name . ' ' . $vendor->last_name,
                'price' => $booking->price,
                'expiry_time' => $booking->created_at->addMinutes(1)->toDateTimeString()
            ];
        }

        return response()->json([
            'status' => 'success',
            'vendors' => $vendorPrices
        ]);
    }

    public function delete(Request $request,$id){
        $bookings = Booking::find($id);
 
        if (!$bookings) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, service form options with id ' . $id . ' cannot be found'
            ], 400);
        }
 
        if ($bookings->delete()) {
            return response()->json([
                'success' => true,
                'message'=>'delete successful'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'service form options could not be deleted'
            ], 500);
        }
    }

    public function BookingsForParticularUser(Request $request) {
        $user = Auth::user();

        // $validator = Validator::make($request->only('api_token'), ['api_token' => 'required']);

        // if($validator->fails()){
        //     return response()->json([
        //         "success" => false,
        //         "message" => $validator->messages()->toArray(),
        //     ],400);    
        // }
    
        //$user = Auth::authenticate($request->api_token);

        $bookings =  Booking::where(["user_id" => $user->id])->get();

        return response()->json([
            'success' => true,
            'data'=> $bookings,
        ], Response::HTTP_ACCEPTED);          

    }
    
    public function BookingForParticularArtisan(Request $request, $id){
        $data = array();
        // $Bookings =  Booking::where(["vendor_id" => $id, "status" => 0])->orderBy("id","DESC")->get();
        $bookings =  Booking::where(["vendor_id" => $id])->orderBy("id","DESC")->get();

        foreach ($bookings as $key => $value) {
            $vendorId = $value->vendor_id;
            $getVendor = Vendor::find($vendorId);
            $name = $getVendor->vendor->service->name;
            $image = $getVendor->basicdetail->image;

            $data[] = array("booking_id" => $value->id,
                "service_id" => $service_id,
                "user_id" => $value->user_id,
                "name" => $name,
                "image" => $image,
                // "created_at" => $value->scheduledate,
                "created_at" => $value->created_at,
                // "total_cost" => $value->total_cost
                "total_cost" => $value->price
            );
            # code...
        }
        $final_data = array("data" => $data, "file_path" => $this->base_url."/images/services_images");
        return response()->json([
            'success'=>true,
            'data'=>$final_data,
        ]);          
    }

   
    //pending booking for vendor  booking/pending-artisan/artisan_id/getstatus/status
    public function getPendingBookingForArtisan(Request $request, $status, $vendor_id) {
        $pendingBookings = Booking::where(["vendor_id" => $vendor_id])->count();
       
        if($pendingBookings == 0){
            return response()->json([
                "success" => false,
                "message" => "invalid booking artsan id entered",
            ],400);    
        } 

        $getData = Booking::where(["vendor_id" => $vendor_id, "status" => 1])->get()->toArray();

        return response()->json([
            'success' => true,
            'data'=>$getData,
        ]);
    }


    //pending booking for a user  booking/pending-user/user_id/getstatus/status
    public function getpendngBookingForUser(Request $request, $status, $user_id){
        $pendingBookings = Bookings::where(["user_id" => $user_id])->count();
        
        if($pendingBookings == 0){
            return response()->json([
                "success" => false,
                "message" => "invalid booking user id entered",
            ],400);    
        } 

        $getData = Bookings::where(["user_id" => $user_id, "status" => 1])->get()->toArray();

        return response()->json([
            'success' => true,
            'data' => $getData,
        ]); 
    }


    //bookings/get-approved/customers_id
    public function getAllWhereUsersIdEqualsCustomersIdAndIsApproved(Request $request,$customers_id){
        $check_id = Booking::where(["user_id" => $customers_id])->count();
        
        if($check_id == 0){
            return response()->json([
                "success" => false,
                "message" => "invalid booking user id entered",
            ],400);    
        }

        $getData = Booking::where(["user_id" => $customers_id, "status"=>2])->get()->toArray();

        return response()->json([
            'success'=>true,
            'data'=>$getData,
        ]);
    }

}
