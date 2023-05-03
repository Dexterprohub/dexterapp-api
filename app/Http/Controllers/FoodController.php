<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Food;
use App\Http\Resources\FoodResource;
use App\Models\Restaurant;
use App\Models\FoodCategory;
use App\Http\Resources\FoodCategoryResource;
use App\Http\Controllers\SanitizeController;
use Auth;


class FoodController extends Controller
{
    public function getFoods(){
        $foods = Food::all();
        $data = FoodResource::collection($foods);
        return response([
            'message' => 'successful' , 
            'food' => $data], Response::HTTP_ACCEPTED
        );
    }


    public function foodOfRestaurant($id){
        $food = Food::where('restaurant_id', $id)->get();
        return response([
            'message' => 'successful',
            'food' => $food], Response::HTTP_ACCEPTED
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

    
    public function getFoodMenu($id){
        $cat = FoodCategory::find($id);

        $data =  new FoodCategoryResource($cat);

        return response(['success' => true, 'data' => $data]);
    }

    public function show(){

        //user food
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
