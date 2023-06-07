<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Shop;
use App\Models\Vendor;
use App\Models\Shopdetail;
use Validator;
use App\Http\Requests\ShopCreateRequest;
use App\Http\Requests\ShopUpdateRequest;
use App\Http\Resources\ShopResource;
use App\Http\Controllers\SanitizeController;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Carbon;
use App\Http\Resources\TopRatedShopResource;
use App\Http\Resources\TopRatedShopNewResource;

class ShopController
{
    public function getShops(){

        $shops = Shop::all();
        $data = $shops;

        return response([
            'success' => true,
            'Shops' => $data
        ]);
    }

    public function topRatedShops() {

        // get all vendors, sort by reviews rating, get top 10
        $topVendors = Vendor::withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(10)
            ->get();

        return response([
            'message' => 'successful',
            'data' => $topVendors
        ],Response::HTTP_ACCEPTED);
    }

    public function createShop(Request $request){


        $validatedData = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'name' => 'required|unique:shops| max:255',
            'bio' => 'required',
            'cover_image' => 'required|image',
            'opened_from' => 'required',
            'opened_to' => 'required',
            'address' => 'required',
            'email' => 'required| unique:shops',
            'phone' => 'required| unique:shops',
            'discount' => 'nullable',
            'min_order' => 'nullable',
            'shippingcost' => 'nullable',
            'additionalcharge' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
        ]);


        $image = $request->file("cover_image");

        if($image == NULL){
            return response()->json([
                'success' => false,
                'message' => 'please select an image'
            ], 400);
        }

        $image_extension = $image->getClientOriginalExtension();

        if(SanitizeController::CheckFileExtensions($image_extension, array("png","jpg","jpeg","PNG","JPG","JPEG")) == FALSE) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, this is not an image please ensure your images are png or jpeg files'
            ], 400);

        }

        $rename_image = uniqid()."_".time().date("Ymd")."_ICO." .$image_extension; //change file name

        $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'shops'])->getSecurePath();

        if ($upload){
            // Create a new Product instance
            $shop = new Shop([
                'name' => $validatedData['name'],
                'bio' => $validatedData['bio'],
                'cover_image' => $upload,
                'opened_from' => $validatedData['opened_from'],
                'opened_to' => $validatedData['opened_to'],
                'address' => $validatedData['address'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'discount' => $request->discount,
                'min_order' => $request->min_order,
                'additionalcharge' => $request->additionalcharge,
                'shippingcost' => $request->shippingcost,
            ]);

            // Get the Service and Vendor instances from the database using their IDs
            $vendor = Vendor::find($request->vendor_id);

            // Associate the Shop with the Vendor
            $shop->vendor()->associate($vendor);

            // Save the Shop, Service and Vendor
            $shop->save();
            $vendor->save();

            return response()->json([
                'success' => true,
                'message' => 'Shop created successfully',
                'data' => new ShopResource($shop)

            ], Response::HTTP_ACCEPTED);
        }else {
            return response()->json(['success' => false, 'message' => 'bad internet connection']);
        }

        return response()->json(['success' => false, 'message' => 'shop upload failed']);
    }

    public function update(Request $request, $id){
        $shop = Shop::find($id);

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, shop with id ' . $id . ' cannot be found'
            ], 400);
        }
        // check if currently authenticated user is the owner of the buisness

        $data = $request->all();

        if($request->hasFile('cover_image')){
            $image = $request->file('cover_image');

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

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'shops/updatedShops'])->getSecurePath();

            if($upload){
                $shop->cover_image = $upload;
            }
        }

        $shop->update($request->only('name', 'bio','address', 'phone', 'email', 'discount', 'additionalcharge', 'shippingcost', 'min_order', 'opened_from', 'opened_to'));

        return response()->json([
            'success' => true,
            'message'=> "Shop updated successfully",
            'updatedShop' => $shop,
        ]);
    }

    public function show($id)
    {
        //get shop
        $shop = Shop::find($id);

        if (!$shop || $shop == null) {
            return response()->json(['status' => 'Business was deleted'], 404);
        }
        //return single shop
        return response()->json($shop);
    }

    public function destroy($id){
       //get Shop
        $shop = Shop::find($id);

        // // check if currently authenticated user is the owner of the shop
        // if ($shop->id == null) {
        //     return response()->json(['error' => 'shop has been deleted or doesnt exist'], 403);
        // }
        // // check if currently authenticated user is the owner of the shop
        // if ($ven->id !== $shop->vendor_id) {
        //     return response()->json(['error' => 'You can only edit your own shop.'], 403);
        // }
        //return single shop
        if ($shop->delete()) {
            return response()->json(['status' => 'shop was deleted'], 200);
        }

    }
    //  public function create(Request $request)
    // {

    //     $request->validate([
    //         'service_id'=>'required',
    //         'vendor_id'=>'required',
    //         'name'=>'required',
    //         'bio'=>'required',
    //         'description'=>'required',
    //         'image'=>'required',
    //     ]);

    //     $product=new Product();

    //     $product->name=$request->name;
    //     $product->category_id=$request->category_id;
    //     $product->sub_category_id=$request->subcategory_id;
    //     $product->brand_id=$request->brand_id;

    //     if($product->category_id && $product->brand_id)
    //     {
    //         $brand=Brand::find($product->brand_id);
    //         $cat=Category::find($product->category_id);
    //         if($brand && $cat){
    //             if(!$brand->categories()->where('category_id',$product->category_id)->exists())
    //                 $brand->categories()->attach($product->category_id);
    //         }
    //         else
    //         return response()->json(['status'=>0,'msg'=>'brand or category not found'],404);
    //     }

    //     $product->details=$request->details;
    //     $product->price=$request->price;
    //     $product->size=$request->size;
    //     $product->color=$request->color;
    //     $product->discount_price=$request->discount_price;
    //     $product->stockout=$request->stockout;
    //     $product->hot_deal=$request->hot_deal;
    //     $product->buy_one_get_one=$request->buy_one_get_one;
    //     $image=$request->image;
    //     $product->image=$image;
    //     if($image){
    //         $image_f=uniqid().'.'.'png';
    //         // $path = public_path()$image_f;
    //         Image::make($image)->resize(500,300)->save(public_path('storage/images/products/'.$image_f).'',100,'png');
    //         $product->image=$image_f;
    //     }

    //     $product->save();
    //     $last=DB::table('products')->latest()->first();
    //     return response()->json(['status'=>1,'data'=>$last,'msg'=>'product added'],200);
    // }
}
