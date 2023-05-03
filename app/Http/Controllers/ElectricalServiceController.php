<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectricalService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\BusinessStoreRequest;

class ElectricalServiceController extends Controller
{
    public function index(){
        $electrical = ElectricalService::all();

        return response($electrical, Response::HTTP_ACCEPTED);
    }

    public function store(ElectricalStoreRequest $request){

        $request->validate([

        ]);
        $electrical = ElectricalService::create($request->only('name', 'icon'));

        return response([
            'message' => 'Service Created Successfully',
            'data' => $electrical], Response::HTTP_CREATED
        );
    }


}
