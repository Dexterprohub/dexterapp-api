<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SanitizeController;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ServiceItem;
use App\Models\Item;

class ServiceItemController extends Controller
{

    public function itemsOfService($service_id){
                
        if(ServiceItem::where('service_id', $service_id)->count() > 0){
           $item = ServiceItem::where('service_id', $service_id)->get();
            return response()->json([
                'success' => true, 
                'message' => 'Service items of ' . $item->item . 'retrieved successfully', 'data' => $item
            ], Response::HTTP_ACCEPTED);
        }
        return response([
            'success' => 'true',
            'message' => 'No item in service'], Response::HTTP_ACCEPTED
        ); 
    }

    public function store(Request $request){

         // Define validation rules for the input data
        $rules = [
            'service_id' => 'required|exists:services,id',
            'item' => 'required',
            'image' => 'nullable',
        ];
        
        // Validate the input data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()->first()]);
        }

        if($request->hasFile('image') === true){
            $image = $request->file('image');
            
            if(SanitizeController::CheckFileExtensions($image,array("png","jpg","jpeg","PNG","JPG","JPEG"))==FALSE){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Sorry, this is not an image please ensure your images are png or jpeg files'
                    ], 500
                );
            }
 
            $rename_image = uniqid()."_".time().date("Ymd")."_IMG.".$image_extension; //change file name

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'serviceItem'])->getSecurePath();
            
            $item = ServiceItem::create([
                'service_id' => $validated['service_id'],
                'item' => $validated['item'],
                'image' => $upload,
            ]);

            return response()->json(['success' => true, 'message' => 'item and image created successfully', 'data' => $item], Response::HTTP_CREATED);
        }
        
        $item = ServiceItem::create($request->only('service_id', 'item'));

        return response()->json(['success' => true, 'message' => 'item created successfully', 'data' => $item], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id){
       
        $item = Item::find($id);
        if(!$item){
            return response()->json(['success' => false, 'message' => 'item with id' . $id . 'cannot be found']);
        }
         
        if($request->hasFile('image') === true){
            $image = $request->file('image');

            // $image_extension = $image->getClientOriginalExtension();
            
            if(SanitizeController::CheckFileExtensions($image,array("png","jpg","jpeg","PNG","JPG","JPEG"))==FALSE){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Sorry, this is not an image please ensure your images are png or jpeg files'
                    ], 500
                );
            }
 
            $rename_image = uniqid()."_".time().date("Ymd")."_IMG.".$image_extension; //change file name

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'serviceItem/updatedServiceItem'])->getSecurePath();
            
            $item =  $item->update([
                'service_id' => $validated['service_id'],
                'item' => $validated['item'],
                'image' => $upload,
            ]);

            return response()->json(['success' => true, 'message' => 'item updated with image successfully', 'data' => $item], Response::HTTP_ACCEPTED);
        
        }

        $item =  $item->update($request->only('service_id', 'item'));

        return response()->json(['success' => true, 'message' => 'item updated successfully', 'data' => $item], Response::HTTP_ACCEPTED);
    }

    public function destroy($id){
        $item = ServiceItem::find($id);

        if(!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, item with id ' . $id . ' cannot be found'
            ], 400);
        }
       
        if ($item->delete()) {
            
            return response()->json([
                'success' => true,
                'message'=>'Delete successful'
            ], Response::HTTP_ACCEPTED);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'item could not be deleted'
            ], 500);
        }
    }
}
