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
        
        usort($new, function($a, $b) {
            return $a->name <=> $b->name;
        });

        $stalls = $stalls ? $stalls : [];
        
        return response()->json([
            'data' => count($new) > 0 ? $new : $stalls,
            'location' => count($new) > 0 ? 1 : 0,
            'found' => count($new) > 0 ? 1 : 0,
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
        if (isset($request->r_name)) {
            if ($stall->review) {
                $reviews = json_decode($stall->review);
                array_push($reviews,  (object)[
                    'r_name' => $request->r_name,
                    'id' => $request->id,
                    'r_item' => $request->r_item,
                    'r_review' => $request->r_review,
                    'r_ts' => $request->r_ts
                ]);
                $stall->review = json_encode($reviews);
            } else {
                $stall->review = json_encode([$request->all()]);
            }
            $stall->save();
        } else {
            $stall = Stall::find($request->id);
            $stall->fill($request->all())->save();
        }

        Cache::rememberForever('stalls', function () {
            return DB::table('stalls')->get();
        });

        return response()->json([
            'success' => true
        ], 200);
    } 
}
