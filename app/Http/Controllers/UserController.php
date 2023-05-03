<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Gate;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Notifications\Notification;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Gate::authorize('view', 'users');
        // $user = User::paginate();

        // return response(UserResource::collection($user), Response::HTTP_ACCEPTED);
        $users = User::paginate(10);
        return response([
            'message' => 'successful', 
            'data' => UserResource::collection($users)], Response::HTTP_ACCEPTED
        );
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Gate::authorize('edit', 'users');
        $user = User::create($request->only('first_name', 'last_name', 'email', 'phone', 'api_token') +
            [
                'password' => Hash::make(1234)
            ]);

        return response([
            'message' => 'User Stored Successfully', 
            'data' => new UserResource($user)], Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Gate::authorize('view', 'users');
        $user = User::find($id);

        return response([
            'message' => 'successful' , 
            'data' => new UserResource($user)], Response::HTTP_ACCEPTED
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        // Gate::authorize('edit', 'users');
        $user = User::find($id);

        $user->update($request->only('first_name', 'last_name', 'email')
            + [Hash::make('password')]);

        return response([
            'message' => 'User Updated Successfully', 
            'data' => new UserResource($user)], Response::HTTP_ACCEPTED
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gate::authorize('view', 'users');
        $user = User::destroy($id);

        return response(['
            message' => 'User deleted Successfully', null], Response::HTTP_NO_CONTENT
        );
    }

    public function getNotifications($id){

        $user = User::find($id);
        // return $datum->notifications->first()->id;
        foreach ($user->notifications as $notification){
            // return $notification->data;
            return response()->json([
                'notification' => $notification->data, 
                'data' => collect($user)
            ], Response::HTTP_ACCEPTED);
        }
    
    }

     
    
}
