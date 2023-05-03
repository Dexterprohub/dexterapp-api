<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;
use Storage;
use Str;
// use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageController extends Controller
{
    public function upload(ImageUploadRequest $request){
        // Upload a Video File to Cloudinary with One line of Code
        // $uploadedFileUrl = Cloudinary::uploadVideo($request->file('file')->getRealPath())->getSecurePath();

        // // Upload any File to Cloudinary with One line of Code
        // $uploadedFileUrl = Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();
        // $name = Str::random(10);
        // $url = Storage::putFileAs('images', $file, $name . '.' . $file->extension());

        $file = $request->file('image');

        $upload = \Cloudinary::upload($file->getRealPath(), ['folder' => 'serviceItems/electricalRepair'])->getSecurePath();        

        return response([ 'url' => $upload]);
        // return ['url' => env('APP_URL') . '/' . $url];
    }
}
