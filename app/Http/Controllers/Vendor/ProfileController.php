<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AvatarStoreRequest;

class ProfileController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(AvatarStoreRequest $request){
        $avatarName = time(). '.'.$request->icon->getClientOriginalExtension();
        $request->icon->move(public_path('avatars'), $avatarName);
  
        // //Store in Storage Folder
        // $request->image->storeAs('images', $imageName);

        Auth()->user()->update(['avatar'=>$avatarName]);

        return response('success', 'Avatar updated successfully.');
    }
}
