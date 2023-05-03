<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Business;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\BeautyServiceResource;
use App\Http\Resources\TechnicalServiceResource;
use App\Models\Category;

use App\Models\Item;
use App\Models\Vendor;
class ServiceController extends Controller
{
    public function index(){
        $service = Service::with('items')->get();
        
        return response($service, Response::HTTP_ACCEPTED);
    }

    public function store(Request $request) {
        $service = Service::create($request->all());

        return response()->json($service, Response::HTTP_CREATED);
    }

    public function show($id) {
        $service = Service::find($id);
        $with = $service->items()->get();
        $name = $service->name;
        return response()->json(['success' => true,'service_name' => $name, 'items' => $with], Response::HTTP_ACCEPTED );
    }

    public function update(Request $request, $id){
        $service = Service::find($id);

        $service->update($request->all());

        return response()->json($service, Response::HTTP_ACCEPTED);
    }

    public function destroy($id) {
        $service = Service::destroy($id);

        return response(NULL,  Response::HTTP_NO_CONTENT);
    }


     public function notifyVendors($serviceId)
    {
        // Retrieve the service from the database
        $service = Service::findOrFail($serviceId);
        
        // Retrieve the vendors associated with the service
        $vendors = $service->vendors;
        return $vendors;
        // Send a notification to each vendor
        foreach ($vendors as $vendor) {
            $this->sendNotificationToVendor($vendor, $service);
        }

        return response()->json(['message' => 'Notifications sent to vendors.']);
    }
    
}
