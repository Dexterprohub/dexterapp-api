<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Business;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\BusinessResource;
use App\Models\Offer;
use App\Models\VendorOnlineStatus;

class VendorController extends Controller
{

    public function getVendorOnlineStatus() {
        // $vendor_api = Auth::getDefaultDriver();
        $vendor = Auth::guard('vendor')->user();
      
        $online = true; // Replace with the current online status
        $offline = false;

        $latestOnlineStatus = VendorOnlineStatus::where('vendor_id', $vendor->id)->orderBy('created_at', 'desc')->first();

        if ($latestOnlineStatus) {
            $latestOnlineStatus->online = $online;
            $latestOnlineStatus->save();
        } else {
            // Create a new record if there is no existing record for the vendor
            $vendorOnlineStatus = new VendorOnlineStatus;
            $vendorOnlineStatus->vendor_id = $vendor_id;
            $vendorOnlineStatus->online = $online;
            $vendorOnlineStatus->save();
        }
    }


    



    
    public function offers(){
        $offers = Offer::all();
        return response([
            'message' => 'Successful' , 
            'data' => $offers], Response::HTTP_ACCEPTED
                       

        );
    }

    public function showOffers($id){
        $offer = Offer::find($id);

        return response([
            'message' => 'successful', 
            'data' => $offer], Response::HTTP_ACCEPTED
        );
    }
}
