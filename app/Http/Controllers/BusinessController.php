<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Review;
use App\Models\Business;
use App\Models\Vendor;
use App\Http\BusinessStoreRequest;
use App\Http\Resources\BusinessResource;
use App\Http\Controllers\SanitizeController;

class BusinessController extends Controller
{
    // public function review(){
    //     $review = Review::all();

    //     return response([
    //         'message' => 'successful', 
    //         'data' => $review], Response::HTTP_ACCEPTED
    //     );
    // }

    public function getBusinesses(){

        $business = Business::paginate(10);

        $data = BusinessResource::collection($business);

        return response([
            'success' => true,
            'data' => $data
        ]);
    }

    public function topRatedBusinesses(){
        $topRated = Business::orderBy('rating','desc')->paginate(5);
      //  $topRated = Restaurant::orderBy('rating','desc')->paginate(5);

        // $data = FavouriteResource::collection(collect($topRated));
        // return $this->responser(collect($favourite), $data, 'Favourite Food');

        return response([
            'message' => 'successful',
            'topratedVendors' => collect($topRated)],Response::HTTP_ACCEPTED
        );
    }

    public function store(BusinessStoreRequest $request){

        $business = Business::create($request->only('opened_from', 'opened_to', ));
        $data = BusinessResource::collection($business);

        return response()->json( $business);
        
        // return response()->json([
        //     'success' => true, 
        //     'data' => $data], Response::HTTP_CREATED
        // );
        
    }
    public function show($id)
    {
        //get business
        $business = Business::find($id);

        if ($business == null) {
            return response()->json(['status' => 'Business was deleted'], 404);
        }
        //return single Business
        return new BusinessResource($business);
    }


    public function update(Request $request, $id)
    {
        $business = Business::find($id);
        // check if currently authenticated user is the owner of the buisness
        if ($request->user()->id !== $business->user_id) {
            return response()->json(['error' => 'You can only edit your own business.'], 403);
        }

        $business->update($request->only(['name_of_business', 'category', 'description']));
        return response()->json(["success"=>"update sucessfull", $business]);
    }

    public function destroy(Request $request, $id)
    {
        //get Business
        $business = Business::find($id);
        
        // check if currently authenticated user is the owner of the buisness
        if ($business->id == null) {
            return response()->json(['error' => 'business has been deleted or doesnt exist'], 403);
        }
        // check if currently authenticated user is the owner of the buisness
        if ($request->user()->id !== $business->user_id) {
            return response()->json(['error' => 'You can only edit your own business.'], 403);
        }
        //return single Business
        if ($business->delete()) {
            return response()->json(['status' => 'Business was deleted'], 200);
        }
    }

     //return searched categories
    public function category($category)
    {
        //get business
        $business = Business::where('category', $category)->get();

        if ($business == null) {
            return response()->json(['status' => 'Business category is not found'], 404);
        }
        //return single Business
        return response()->json($business);
    }

    public function uploadFile(Request $request)
    {
       $vendor = \Auth::vendor();

        $file = $request->file('image');
        // $filename = pathinfo();
        // $name = Str::random(10);
        // $url = 'Dexterprolimited.com/static/media/';
        // $url = Storage::putFileAs('images', $file, $name . '.' . $file->extension());

        $upload = \Cloudinary::upload($file->getRealPath(), ['folder' => 'images'])->getSecurePath();
        
        if ($upload){
            $uploadImageUrl = Business::where('vendor_id', $vendor->id )->update(['cover_image' => $upload['url']]); 

            return response()->json([
                'success' => true,
                'data' => $uploadImageUrl
            ]);
        }
        
    }


    public function createBusiness(Request $request){


    }

}


