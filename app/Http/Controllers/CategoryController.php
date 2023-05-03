<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use App\Models\Category;
use App\Models\Shop;
use App\Http\Controllers\SanitizeController;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Auth;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller{

    protected $request;
    public function index(Request $request) {

        //laravel automatically converts it to json and sends a response text too
        //$auth = auth("admins")->authenticate($request->token);
        $categories = Category::all();

        if ($categories->count() == 0){
            return response(['success' => true, 'data' => 'No category found'], Response::HTTP_ACCEPTED);
        }
        return response()->json([
            'success'=> true,
            'data'=> CategoryResource::collection($categories),
        ], Response::HTTP_ACCEPTED);

    }

    public function categoriesOfShop(Request $request, $shop_id){
        $categories = Category::where('shop_id', $request->shop_id);

        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function store(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'name' => 'required|string',
            'cover_image' => 'nullable',
            
        ]);
        
        if($validator->fails()){
            return response()->json([ 
                "success" => false,
                "message" => $validator->errors()->first(),
            ], 400);  
        }

        if($request->hasFile('cover_image')){
            $image = $request->file("cover_image");
        
            if($image==NULL){
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
            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'categories'])->getSecurePath();

            if ($upload){
            
                $categories = new Category(
                    [
                        'cover_image' => $upload,
                    ]
                );

            }

            $categories = new Category();
            $categories->name = $request->name;

            // Get the Shop instance from the database using its ID
            $shop = Shop::find($request->shop_id);

            // Associate the Category with the Shop
            $categories->shop()->associate($shop);
            
            $categories->save();
            $shop->save();

            $categories->setRelation('shop', null);
            $categories->makeHidden('shop');

            return response()->json([
                'success' => true,
                'message' => 'category added successfully',
                'data' => $categories
                
            ], Response::HTTP_ACCEPTED);

        }

        $categories = new Category(['name' => $request->name,]);

        // Get the Shop instance from the database using its ID
        $shop = Shop::find($request->shop_id);

        // Associate the Category with the Shop
        $categories->shop()->associate($shop);
        
        $categories->save();
        $shop->save();

        return response()->json([
            'success' => true,
            'message' => 'category added successfully',
            'data' => new CategoryResource($categories)    
        ], Response::HTTP_ACCEPTED);
    }

    public function show($id){
        $category = Category::find($id);

        return response()->json(['success' => true, 'data' => $category]);
    }

    public function update(Request $request,$id){
        
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, category with id ' . $id . ' cannot be found'
            ], 400);
        }

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

            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'categories/updatedCategories'])->getSecurePath();
            
            if($upload){
                $category->cover_image = $upload;
                $category->save();
            }
        }

        $category->update($request->only('name'));
        
        return response()->json([
            'success' => true,
            'message'=> "Category updated successfully",
            'updated_category' => $category,
        ]);
    }

    public function delete(Request $request,$id){
        $category = Category::find($id);
    
        if(!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, category with id ' . $id . ' cannot be found'
            ], 400);
        }
        if ($category->delete()) {
            return response()->json([
                'success' => true,
                'message'=>'delete successful'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'categories could not be deleted'
            ], 500);
        }
    }

    public function categoryInShop($id){
        $categories = Category::where('shop_id', $id)->get();
        return response([
            'success' => true,
            'message' => 'successful',
            'categories' => $categories], Response::HTTP_ACCEPTED
        );

        return response()->json(['success' => true, 'message' => 'No Category In Restaurant']);
    }

}
