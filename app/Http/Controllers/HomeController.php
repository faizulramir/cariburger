<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use Cache;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getStalls($data, $type)
    {
        $stalls = Cache::get('stalls');
        $new  = [];

        if ($data !== 'secret' && $data !== '' && $stalls)  {
            foreach ($stalls->toArray() as $key => $stall) {
                if (false !== stristr(strtolower($stall->{$type}), strtolower($data)))  {
                    array_push($new, $stall);
                }
            }
        }

        return response()->json([
            'data' => $new,
            'location' => count($new) > 0 ? 1 : 0,
            'success' => true
        ], 200);
    }

    public function getStall($id)
    {
        $stalls = Cache::get('stalls');
        $new = [];

        if ($stalls) {
            foreach ($stalls->toArray() as $key => $stall) {
                if ($stall->id == $id) {
                    array_push($new, $stall);
                }
            }
        }

        return response()->json([
            'data' => $new[0],
            'success' => true
        ], 200);
    }

    public function editStall(Request $request)
    {
        Cache::flush();

        $stall = Stall::find($request->id);
        $stall->fill($request->all())->save();

        Cache::rememberForever('stalls', function () {
            return DB::table('stalls')->get();
        });

        return response()->json([
            'success' => true
        ], 200);
    } 
}
