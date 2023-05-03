<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(){
        $item = Item::all();
        return response()->json($item);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'item' => 'required',
        ]);

       
        $item = new Item();
        $item->item = $validatedData['item'];
        
        if($request->hasFile('image')){
            $image = $request->file('image');
           
            if(SanitizeController::CheckFileExtensions($image_extension,array("png","jpg","jpeg","PNG","JPG","JPEG"))==FALSE){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Sorry, this is not an image please ensure your images are png or jpeg files'
                    ], 500
                );
            }

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'items'])->getSecurePath();
            
            if ($upload){
                // Create a new Product instance
                $item->image = $upload;
            }
        }

        $item->save();

        return response()->json($item);
    }

    public function update(Request $request, $id){
        $item = Item::find($id);

        if(!$item){
            return response()->json(['success' => false, 'message' => 'item with id' . $id . 'not found!']);
        }

        $item->service_id = $request->service_id;
        $item->item = $request->item;

        if($request->hasFile('image')){
            $image = $request->file('image');
        
            if(SanitizeController::CheckFileExtensions($image_extension,array("png","jpg","jpeg","PNG","JPG","JPEG"))==FALSE){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Sorry, this is not an image please ensure your images are png or jpeg files'
                    ], 500
                );
            }

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'items'])->getSecurePath();
                
            if ($upload){
                // Create a new Product instance
                $item->image = $upload;
            }
            
        }

        $item->save();

        return response()->json(['success' => true, 'message' => 'item updated successfully!']);

    }

    public function delete($id){
        $item = Item::find($id);

        if(!$item){
            return response()->json(['success' => false, 'message' => 'Item with id' . $id . 'has already been deleted!']);
        }

        $item->delete();

        return response()->json(['success' => true, 'message' => 'Item deleted successfully!']);
    }
}
