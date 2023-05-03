<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewStoreRequest;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use Symfony\Component\HttpFoundation\Response;
class ReviewController
{
    public function getReviews(){
        $reviews = Review::all();

        return response([
            'message' => true, 
            'data' => $reviews], Response::HTTP_ACCEPTED
        );
    }
    
    public function create(ReviewStoreRequest $request,$id) {
 
        $review = Review::create($request->only('user_id', 'vendor_id', 'booking_id', 'business_id', 'review', 'rating', 'review_date'));
                   
        return response()->json([
            'success' => true,
            'message' => 'Review added successfully'
        ], Response::HTTP_CREATED);
    }


    public function getReviewsForBusinessId($id){

        $reviews =  Review::where(["business_id" => $id])->get();
        return response()->json([
            'success' => true,
            'data' => ReviewResource::collection($reviews)], Response::HTTP_ACCEPTED
        );
    }

    public function getReviewsForVendorId($id){

        $reviews =  Review::where(["vendor_id" => $id])->get();
        return response()->json([
            'success' => true,
            'data' => $reviews ], Response::HTTP_ACCEPTED
        );
    }

}
