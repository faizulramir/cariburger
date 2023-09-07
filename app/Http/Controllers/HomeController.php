<?php

namespace App\Http\Controllers;

use Cache;
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

        if ($data !== 'secret' && $data !== '')  {
            $new = $stalls->filter(function ($item) use ($data, $type) {
                // replace stristr with your choice of matching function
                return false !== stristr(strtolower($item->{$type}), strtolower($data));
            });
            
        }

        return response()->json([
            'data' => $new,
            'location' => count($new) > 0 ? 1 : 0,
            'success' => true
        ], 200);
    }
}
