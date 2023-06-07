<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function productsInCategory(Request $request, $category_id)
    {
        $products = Product::where('category_id', $request->category_id)->orderBy('name', 'asc')->get();
        // $data = FoodResource::collection($food);

        return response([
            'message' => 'successful',
            'products' => $products
        ], Response::HTTP_ACCEPTED
        );
    }

    public function productsOfShop($shop_id)
    {
        if ($products = Product::where('shop_id', $shop_id)->count() > 0) {
            $products = $products = Product::where('shop_id', $shop_id)->get();
            $data = collect($products);
            return response()->json([
                'success' => 'true', 'message' => 'Products in shop', 'data' => ProductResource::collection($products)
            ]);
        }

        return response()->json(['success' => true, 'message' => 'No products in shop', 'data' => []]);
    }

    public function store(Request $request)
    {
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
            return response()->json(['status' => 'error', 'message' => $validator->messages()->first()], Response::HTTP_UNPROCESSABLE_ENTITY);
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

    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Product retrieved successfully.',
            'data' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
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

        // if new image is added, upload the image to cloudinary
        if ($request->hasFile('image')) {
            // TODO: delete the previous image from cloudinary
            $result = $request->file('image')->storeOnCloudinary('products');
            $attributes['image'] = $result->getSecurePath();
        }

        $product->update($attributes);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully.',
            'data' => $product->fresh()
        ]);
    }

    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'data' => $product
        ]);
    }
}
