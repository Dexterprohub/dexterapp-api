<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;
use App\Http\Resources\ProductResource;
use Illuminate\Validation\Rules\File;
use Storage;
use Str;
use Auth;
use Validator;
use App\Http\Controllers\SanitizeController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index() {
        return Product::all();
    }

    public function productsInCategory(Request $request, $category_id){

        $products = Product::where('category_id', $request->category_id)->orderBy('name', 'asc')->get();
        // $data = FoodResource::collection($food);

        return response([
            'message' => 'successful',
            'products' => $products], Response::HTTP_ACCEPTED
        );
    }
    public function productsOfShop($shop_id){

        if($products = Product::where('shop_id', $shop_id)->count() > 0){
            $products = $products = Product::where('shop_id', $shop_id)->get();
            $data = collect($products);
            return response()->json(['success' => 'true', 'message' => 'Products in shop', 'data' => ProductResource::collection($products)]);
        }

        return response()->json(['success' => true, 'message' => 'No products in shop', 'data' => []]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'shop_id' => ['required', 'exists:shops,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:255'],
            'description' => ['nullable'],
            'price' => ['required', 'numeric'],
            'image' => ['nullable', File::image()],
            'in_stock' => ['nullable', 'boolean']
        ]);

        // Check if the request is valid
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()->first()]);
        }

        // Get the validated data
        $attributes = $validator->validated();

        // upload the image to cloudinary
        $result = $request->file('image')?->storeOnCloudinary('products');

        $attributes['image'] = $result?->getSecurePath();

        $product = Product::create($attributes);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added successfully.',
            'data' => $product,
        ]);
    }

    public function show($id){
       $product = Product::find($id);
       return response()->json(['success' => true, 'product' => $product]);
    }

    public function update(Request $request, $id){
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

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

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'products/updatedProducts'])->getSecurePath();

            if($upload){
                $product->image = $upload;
                $product->save();
            }

        }

        $product->update($request->only('name', 'description', 'price'));
        return response()->json([
            'success' => true,
            'message'=> "Product updated successfully",
            'updated_product' => $product,

        ]);

        $product->update($request->only('category_id','name', 'description', 'price'));

        return response()->json([
            'success' => true,
            'message'=> "Product updated successfully",
            'updated_product' => $product,
        ]);

    }

    public function destroy(Request $request,$id){
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($product->delete()) {
            // unlink(public_path('images/'.$categories_prev_image));
            return response()->json([
                'success' => true,
                'message'=>'delete successful'
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'product could not be deleted'
            ], 500);
        }
    }


}
