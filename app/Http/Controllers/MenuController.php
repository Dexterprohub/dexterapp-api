<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    public function index(){
        $menu = Menu::all();
        return response($menu, Response::HTTP_ACCEPTED);
    }

    public function store(Request $request){
        $menu = Menu::create($request->only('name', 'image', 'rating', 'min_order', 'delivery_fee', 'email', 'phone', 'address', 'status', 'discount'));
        
        return response($menu, Response::HTTP_CREATED);
    }

    public function show($id){
        $menu = Menu::find($id);
        return response($menu, Response::HTTP_ACCEPTED);
    }

    public function destroy($id){
        $menu = Menu::destroy($id);
    
        return response(NULL, Response::HTTP_NO_CONTENT);
    }
}
