<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewStoreRequest;
use App\Models\Review;
use App\Models\Shop;
use App\Http\Resources\ReviewResource;
use Symfony\Component\HttpFoundation\Response;
class ReviewController extends Controller
{
    public function reviews(){
        $review = Review::all();

        return response([
            'message' => 'successful', 
            'data' => $review], Response::HTTP_ACCEPTED
        );
    }

    public function userReviews(){

        $user = Auth::guard('api')->user();
        $reviews = Review::where('user_id', $user->id)->get();

        return response()->json(
            [
                'success' => true,
                'message' => 'user reviews fetched successfully',
                'data' => $reviews,
            ], Response::HTTP_ACCEPTED
        );
    }

    public function store(ReviewStoreRequest $request) {
        
        $shop = Shop::find($request->shop_id);

        // Create a new review
        $review = new Review();
        $review->user_id = \Auth::id(); // Assuming you are using Laravel's built-in authentication
        $review->vendor_id = $request->vendor_id;
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();
                   
        return response()->json([
            'success' => true,
            'message' => 'Review added successfully',
            'data' => $review
        ], Response::HTTP_CREATED);
    }

    public function getReviewsForVendor($id){

        $reviews =  Review::where(["vendor_id" => $id])->get();
        
        return response()->json(
            [
                'success' => true,
                'message' => 'reviews for vendor fetched',
                'data' => ReviewResource::collection($reviews)
            ], Response::HTTP_ACCEPTED
        );
    }
}
