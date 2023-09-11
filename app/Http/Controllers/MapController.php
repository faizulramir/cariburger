<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use Cache;
use DB;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index () 
    {
        return view('map');
    }
    public function create (Request $request) 
    {
        dd($request->all());

        return response()->json([
            'return_to' => $request->from,
            'success' => true
        ], 200);
    }

    public function custom_route (Request $request) 
    {

    }
}
