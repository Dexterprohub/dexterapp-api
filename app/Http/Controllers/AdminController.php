<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\VendorService;
use App\Models\User;
use App\Models\Shop;
use App\Http\Resources\VendorResourceDashboard;
use App\Http\Resources\UserResourceDashboard;
use Symfony\Component\HttpFoundation\Response;


class AdminController extends Controller
{
    
    public function AllVendors(){
        $vendor = Vendor::with(['basicdetail', 'service', 'reviews'])->get();
   
        return $vendor;
        $data = $vendor->concat($vendorShops);
        return response()->json([
            'success' => true, 
            'data' => $data
        ], Response::HTTP_ACCEPTED);
    
    }
    public function allUsers(){
        $users = User::with(['addresses'])->get();

        
        return response()->json([
            'success' => true, 
            'data' => UserResourceDashboard::collection($users)
        ], Response::HTTP_ACCEPTED);
    }

    public function getVendorCount(){
        $vendor = Vendor::count();
        return $vendor;
    }


    public function getUserCount(){
        $user = User::count();
        return response()->json(['sucess' => true, 'data' => $user]);
    }

    public function getType($id){
        $vendor = Vendor::findOrFail($id);
        $service_name = $vendor->vendorService->service->name;
        return response()->json(['success' => true, 'data' => $service_name]);
    }
}
