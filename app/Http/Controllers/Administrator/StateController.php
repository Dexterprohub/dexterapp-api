<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
class StateController extends Controller
{

    public function getStates(){
        $getStates = State::all();

        return reponse()->json([
            'success' => true,
            'data' => $getStates
        ]);
    }
    // public function index(Request $request,$id) {
    // //the id is the country id
    //     $get_states = State::where(["country_id"=>$id])->get();
    //     return response()->json([
    //         'success' => true,
    //         'data'=>$get_states
    //     ], 200);

    // }
}
