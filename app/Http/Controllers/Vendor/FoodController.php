<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Food;
use App\Http\Resources\FoodResource;
use App\Models\Restaurant;
use App\Models\FoodCategory;
use App\Http\Resources\FoodCategoryResource;
use Auth;
use App\Http\Controllers\SanitizeController;

class FoodController
{
    public function getAllFood(){
        $foods = Food::all();
        $data = FoodResource::collection($foods);
        return response([
            'message' => 'successful' , 
            'food' => $data], Response::HTTP_ACCEPTED
        );
    }

    public function createFood(Request $request){
        $validator =\Validator::make($request->all(), [
            'restaurant_id'   => 'required',
            'food_category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);

        if($validator->fails()){
            return response->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        
        $image = $request->file("image");
        
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
          
        $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'food'])->getSecurePath();
        if ($upload){
            
            $food = Food::create([
                'restaurant_id'   => $request->restaurant_id,
                'food_category_id' => $request->food_category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $upload,
                
            ]);

            return response()->json([
                'message' => 'Food added successfully',

                'data' => $food

            ], Response::HTTP_ACCEPTED);
        }

        return response(['success' => false, 'message' => 'Unsuccessful. Please try agaian'],404);

    }

    public function getFood($id){

        $food = Food::find($id);

        return response()->json(['success' => true, 'food' => new FoodResource($food)]);

    }

    public function updateFood(Request $request, $restaurant_id, $id){
       
        // $vendor = \Auth::getDefaultDriver();
        // $vend = \Auth::guard($vendor)->user();
        // $isRestaurant = $vend->restaurant;        
        // $isFood = $isRestaurant->food;

        // return $isFood_id;
        // $data = $request->only('food_category_id', 'name', 'discription', 'price','image');

        // $food = Food::find($id);
        $request->all();
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $validator = \Validator::make($request->all(), [
                'image' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->first()]);
            }
            $image_extension = $image->getClientOriginalExtension();
          
            if(SanitizeController::CheckFileExtensions($image_extension, array("png","jpg","jpeg","PNG","JPG","JPEG")) == FALSE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, this is not an image please ensure your images are png or jpeg files'
                ], 400);
            }
            
            $upload = \Cloudinary::upload($image->getRealPath(), ['folder' => 'updatedFood'])->getSecurePath();
            
            if($upload){
                return $upload;
                $food->update($request->only(['food_category_id', 'name', 'discription', 'price', 'image' => $upload]));

                return $food . "jj";
            }

        }
        return 'no image';
        // $food = $food->update($request->only('food_category_id', 'name', 'discription', 'price', 'image'));

        // $image = $request->file("image");

        // if($image==NULL){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'please select an image'
        //     ], 400);    
        // }
        
        // return $image_extension;
        // $rename_image = uniqid()."_".time().date("Ymd")."_ICO." .$image_extension; //change file name

        // if($request->hasFile("image")){
        //     return ['request has file'];

            
        //     if($upload){

               

        //         return response()->json(['success' => true, 'Updated Food Item' => new FoodResource($food)]);

        //     }

        //     return response(['success' => false, 'message' => 'Unsuccessful. Please try agaian'],404);
        // }
        // return ['requens not'];
        // return response()->json(['success' => true, 'Updated Food Item' => new FoodResource($food)]);

    }

    public function destroy($id){
        $food =Food::destroy($id);

        if(!$food){
            return response()->json([
                'success' => false, 
                'message' => 'Food item already deleted or doesn\'t exist'
            ], Response::HTTP_ACCEPTED);
        }

        return response()->json(['success' => true, 'message' => 'Food deleted successfully'], Response::HTTP_ACCEPTED);


    }

    //Get All Food in a Restaurant
    public function foodOfRestaurant(Request $request, $restaurant_id){
        $food = Food::where('restaurant_id', $request->restaurant_id)->get();
        
        return response([
            'message' => 'successful',
            'Food in Restaurant' => $food], Response::HTTP_ACCEPTED
        );
    }

    public function foodByCategory($id){
        $food = Food::where('food_category_id', $id)->orderBy('name', 'asc')->get();
        $data = FoodResource::collection($food);

        return response([
            'message' => 'successful', 
            'food by category' => $data], Response::HTTP_ACCEPTED
        );
    }
    
    public function getAllFoodCategories(){
        $food_categories = FoodCategory::paginate(5);

        return response()->json(['success' => true, 'data' => FoodCategoryResource($food_categories)]);
    }

    public function foodCategoryofRestaurant(Request $request, $restaurant_id){
        
        $food_categories = FoodCategory::where('restaurant_id', $request->restaurant_id)->get();

        return response()->json(['success' => true, 'Food Menu in Restaurant' => $food_categories]);
    }

    public function getFoodMenu($id){
        $cat = FoodCategory::find($id);

        $data =  new FoodCategoryResource($cat);

        return response(['success' => true, 'Food Menu' => $data]);
    }

    public function createFoodCategory(Request $request, $restaurant_id){

        $validator = \Validator::make($request->all(), [
            'restaurant_id' => 'required',
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false, 
                'message' => $validator->errors()->first()
            ]);
        }

        $foodCategory = FoodCategory::create([
            'restaurant_id' => $request->restaurant_id,
            'name' => $request->name
        ]);
        $data = new FoodCategoryResource($foodCategory);
        return response(['success' => true, 'Food Category' => $data]);
    }

    public function UpdateFoodMenu(Request $request, $restaurant_id, $id){
        $food_category = FoodCategory::find($id);

        $food_category->update($request->only([
            'restaurant_id' => $request['restaurant_id'],
            'name' => $request->name
        ]));

        return response()->json(['success' => true, 'Updated Food Category' => new FoodCategoryResource($food_category)]);
    }

    public function deleteFoodMenu($id){
        $food_category = FoodCategory::destroy($id);

        if($food_category == NULL){
            return response()->json(['success' => false, 'message' => 'Menu doesn\'t exist'], 404);
        }
        return response()->json(['success' => true, 'message' => 'Menu deleted successfully'], Response::HTTP_ACCEPTED);
    }


    public function show(){
        $restaurant = Auth::user()->restaurant;

        
        if($restaurant) {
            $food = Food::where('restaurant_id', $restaurant->id)->paginate(10);
        }

        $restaurant = Restaurant::all();
        $food = Food::orderBy('restaurant_id', 'asc')->paginate(15);
        return response(['message' => 'successful', 'restaurant' =>$food], Response::HTTP_ACCEPTED);
    }

     public function foodImageUpload(Request $request, $id)
    {
        $food = Food::find($id);
        $ven = "";
       $vendor = \Auth::getDefaultDriver();
        if ($vendor){
            $ven = \Auth::guard($vendor)->user();
        }

        $file = $request->file('image');
        // $filename = pathinfo();
        // $name = Str::random(10);
        // $url = 'Dexterprolimited.com/static/media/';
        // $url = Storage::putFileAs('images', $file, $name . '.' . $file->extension());

        $upload = \Cloudinary::upload($file->getRealPath(), ['folder' => 'restaurant'])->getSecurePath();
        
        if ($upload){
            $uploadImageUrl = Food::where('id', $food->id)->update(['image' => $upload['url']]); 

            return response()->json([
                'success' => true,
                'data' => $uploadImageUrl
            ]);
        }
        
    }
}
