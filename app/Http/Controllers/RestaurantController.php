<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantCreateRequest;
use App\Models\Restaurant;
use App\Models\FoodCategory;
use App\Models\Food;
use App\Models\Shop;
use App\Models\Business;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\FoodCategoryResource;
use App\Http\Resources\RestaurantResource;
use App\Models\Service;
use Auth;

class RestaurantController extends Controller
{

    // public function searchRestaurant(Request $request) {
    //     $restaurant = (new Restaurant)->newQuery();

    // }

    public function index(){
        $restaurants = Restaurant::all();

        return response()->json([
            'success' => true,
            'restaurants' => RestaurantResource::collection($restaurants)], 
            Response::HTTP_ACCEPTED
        );
    }

    public function store(Request $request, $service_id){ 

        $service = Service::where("id", $request['id'])->get();
        $service_id = $service->first()->id;


        if( $service_id == null ) {
            return abort( 404 );
        } 

        $ven = "";
        $vendor = Auth::getDefaultDriver();

        if($vendor){
            $ven = Auth::guard($vendor)->user()->id;
        }
 
        if(Auth::guard($vendor)->user() && ($request['id'] == 1 ) ){
           
            $request->merge([
            'service_id' => $service_id,
            'vendor_id' => $ven
            ]);

            $res = Restaurant::create($request->all());

            return response(['success' => true , 'data' => new RestaurantResource($res)]);
        }
            
        return response(['success' => false, 'message' => 'Food Delivery Service Not Created']);

    }

    public function show($id) {
        $res = Restaurant::find($id);
        return response($res, Response::HTTP_ACCEPTED);
    }

    public function update(Request $request, $id) {
        $res = Restaurant::find($id);
        $res->update($request->except('email'));
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

     public function restaurantImageUpload(Request $request)
    {
        $ven = "";
       $vendor = \Auth::getDefaultDriver();
        if ($vendor){
            $ven = \Auth::guard($vendor)->user();
        }

        $file = $request->file('cover_image');
        // $filename = pathinfo();
        // $name = Str::random(10);
        // $url = 'Dexterprolimited.com/static/media/';
        // $url = Storage::putFileAs('images', $file, $name . '.' . $file->extension());

        $upload = \Cloudinary::upload($file->getRealPath(), ['folder' => 'restaurant'])->getSecurePath();
        
        if ($upload){
            $uploadImageUrl = Restuarant::where('vendor_id', $ven->id )->update(['cover_image' => $upload['url']]); 

            return response()->json([
                'success' => true,
                'data' => $uploadImageUrl
            ]);
        }
        
    }

    public function findNearestRestaurants($latitude, $longitude, $radius = 400){

        $restaurants = DB::table('restaurants')
            ->selectRAW("id, name, ANY_VALUE(address), latitude, longitude, (637100 * acos(cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance)", [$latitude, $longitude, $latitude])
            ->where('is_active', '=', 1)
            ->having("distance", "<", $radius)
            ->orderBy("distance", 'asc')
            ->offset(0)
            ->limit(20)
            ->first()
        ;

        return response(['message' => $restaurants]);

    }
}
