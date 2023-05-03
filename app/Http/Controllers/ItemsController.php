<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(){

    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'item' => 'required',
            'image' => 'nullable'
        ]);

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

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'serviceItems'])->getSecurePath();
            
            if ($upload){
                // Create a new Product instance
                $item = new Item([
                    'item' => $request->item,
                    'image' => $upload,
                ]);

                // Get the Category instance from the database using its ID
                $service = Service::find($request->service_id);
                
                // Associate the Product with the Category
                $item->service()->associate($service);
                
                // Save the Product, Category and Shop
                $service->save();
                $item->save();
        
                return response([
                    'success' => true,
                    'message' => 'Item added successfully',
                    'data' => collect($item), 
                ], Response::HTTP_CREATED);
            }
        }


        $item = new Item;
        $item->item = $validatedData['item'];

        // Get the Category instance from the database using its ID
        $service = Service::find($request->service_id);
            
        // Associate the Product with the Category
        $item->service()->associate($service);
        
        // Save the Product, Category and Shop
        $service->save();
        $item->save();
    
        return response([
            'success' => true,
            'message' => 'Item added successfully',
            'data' => collect($item), 
        ], Response::HTTP_CREATED);


    }
}
