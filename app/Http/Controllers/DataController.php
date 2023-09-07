<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use Cache;
use DB;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index () 
    {
        Cache::flush();

        Cache::rememberForever('stalls', function () {
            return DB::table('stalls')->get();
        });

        return view('data.create');
    }

    public function create (Request $request)
    {
        Cache::flush();

        Stall::create($request->all());

        Cache::rememberForever('stalls', function () {
            return DB::table('stalls')->get();
        });

        return redirect()->back()->with('success', 'Success!');
    }
}
