<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use Cache;
use DB;
use Exception;
use File;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index () 
    {
    
        // $path = public_path() . "/newData.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        // if (!File::exists($path)) {
        //     throw new Exception("Invalid File");
        // }

        // $file = File::get($path); // string
        // $newData = json_decode($file);
        // foreach ($newData as $key => $data) {
        //     $d_data = json_decode($data);
        //     $stall = new Stall;
        //     foreach ($d_data as $k => $d) {
        //         if ($k == 'review') {
        //             $stall->{$k} = json_encode($d);
        //         } else {
        //             $stall->{$k} = $d;
        //         }
        //     }
        //     $stall->save();
        // }

        // $stalls = Cache::get('stalls');
        // $duplicates = $stalls->duplicates('lat');

        // foreach ($duplicates as $key => $d) {
        //     if ($d) {
        //         $stall = Stall::find($stalls[$key]->id);
        //         $stall->delete();
        //     }
        // }

        // Cache::flush();

        // Cache::rememberForever('stalls', function () {
        //     return DB::table('stalls')->get();
        // });
        
        return view('data.create');
    }

    public function create (Request $request)
    {
        Cache::flush();

        Stall::create($request->all());

        Cache::rememberForever('stalls', function () {
            return DB::table('stalls')->get();
        });

        return response()->json([
            'success' => true
        ], 200);
    }
}
