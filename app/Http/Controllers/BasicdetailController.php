<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Http\Controllers\SanitizeController;
use App\Models\Basicdetail;
use App\Models\Vendor;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\StoreBasicdetailResource;
class BasicdetailController extends Controller
{
    public function getVendorBasicDetail($id){
        $basic = Basicdetail::where('vendor_id', $id)->get();
        return response()->json(['success' => true, 'message' => 'Vendor Basic Detail Fetched Successfully', 'data' => $basic]);
    }

    public function store(Request $request){
        
        // $vendor = Auth::guard('vendor')->user();
        
        // Define validation rules for the input data
        $validatedData = $request->validate(
            [
                'vendor_id' => 'required|exists:vendors,id',
                'state' => 'required|string',
                'city' => 'required|string',
                'street' => 'required|string',
                
            ]
        );
 
        $vendor = new Vendor();
        $vendor->qualification = $request->qualification;
        $vendor->nin = $request->nin;
        $vendor->street = $validatedData['street'];
        $vendor->city = $validatedData['city'];
        $vendor->state = $validatedData['state'];
        
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

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'basicdetail'])->getSecurePath();

            if($upload){
                $basicdetail->image = $upload;
            }      
        }

        $vendor = Vendor::findOrFail($validatedData['vendor_id']);
        
        $basicdetail->vendor()->associate($vendor);

        $basicdetail->save();
        $vendor->save();

        // $basicdetail->setRelation('vendor', 'null');
        $basicdetail->makeHidden('vendor');

        return response()->json([
            'success' => true,
            'message'=> "Basic detail stored",
            'detail' => collect($basicdetail),
            // 'detail' => new StoreBasicdetailResource($basicdetail),
            
        ]);
    }

    public function update(Request $request){

        
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required ',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            
        ]);
        
        
        if($validator->fails()){
            return response()->json([ 
                "success" => false,
                "message" => $validator->errors()->first(),
            ], 400);  
        }
        
        $vendor_id = $request->vendor_id;
        $vendor = Vendor::find($vendor_id);
        return $vendor;
        return $validatedData['vendor_id'];
        $basicdetail = new Basicdetail();

        $basicdetail->vendor()->associate($vendor);
        $basicdetail->qualification = $request->qualification; 
        $basicdetail->nin = $request->nin; 
        $basicdetail->street = $request->street; 
        $basicdetail->city = $request->city; 
        $basicdetail->state = $request->state; 


        if( $request->hasFile('image')){ 
            return true;
            $image = $request->file('image');
            return $basicdetail;
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

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'basicdetail/updatedBasicdetail'])->getSecurePath();
            return $upload;
            if($upload){
               $basicdetail->image = $upload;
               
            }
            
            return $basicdetail;
        }
        $basicdetail->save();
        return response()->json([
            'success' => false,
            'message' => 'Check internet connection'
        ], 500);

        $basic->update($request->only('qualification', 'nin', 'street', 'city', 'state'));

        return response()->json([
            'success' => true,
            'message'=> "Detail updated successfully",
            'updated_detail' => $basic,
        ]);
    }

}
