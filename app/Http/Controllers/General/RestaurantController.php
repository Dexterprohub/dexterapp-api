<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantCreateRequest;
use App\Models\Restaurant;
use App\Models\FoodCategory;
use App\Models\Food;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\FoodCategoryResource;
use App\Http\Resources\RestaurantResource;



class RestaurantController
{

    // public function searchRestaurant(Request $request) {
    //     $restaurant = (new Restaurant)->newQuery();

    // }

    public function getRestaurants(){
        $res = Restaurant::all();
        $data = RestaurantResource::collection($res);
        return response()->json([
            'Success' => true,
            'restaurants' => $data, 
            
        ]);
    }

    public function store(RestaurantCreateRequest $request){
        $res = Restaurant::create($request->only('name','address', 'email', 'phone'));

        return response($res, Response::HTTP_CREATED);

    }

    public function show($id) {
        $res = Restaurant::find($id);
        return response($res, Response::HTTP_ACCEPTED);
    }

    public function update(Request $request, $id) {
        $res = Restaurant::find($id);
        $res->update($request->only('name', 'address', 'email', 'phone'));
        return response($res, Response::HTTP_ACCEPTED);
    }

    public function destroy($id) {
        $res = Restaurant::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function categoryInRestaurant($id) {
        $foods = Food::where('restaurant_id', $id )->orderBy('food_category_id', 'asc' )->paginate(10);

        $food_category_id = [];
        $food_categories = [];

        foreach($foods as $food) {

            if( !in_array( $food->food_category_id, $food_category_id ) ) {
                $food_category = FoodCategory::where('id', $food->food_category_id)->first();
                array_push( $food_category_id, $food->food_category_id);
                $food_categories[] = $food_category;
            }
        }

        $data = FoodCategoryResource::collection($food_categories );
        return response([
            'message' => 'successful',
            'data' => $data], Response::HTTP_ACCEPTED);
        // return $this->responser(collect($categories), $data, 'Categories');
        // return response();
    }



    // public function findNearestRestaurants($latitude, $longitude, $radius = 400){

    //     $restaurants = DB::table('restaurants')
    //                     ->selectRAW("id, name, address, latitude, longitude, rating, zone, (637100 * acos(cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance)", [$latitude, $longitude, $latitude])
    //                     ->where('active', '=', 1)
    //                     ->having("distance", "<", $radius)
    //                     ->orderBy("distance", 'asc')
    //                     ->offset(0)
    //                     ->limit(20)
    //                     ->get();

    //     return $restaurants;

    // }
}
