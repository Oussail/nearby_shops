<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ShopsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function nearby_index()
    {
        return view('nearby_shops');
    }

    public function preferred_index()
    {
        return view('preferred_shops');
    }

    //Function that return nearby shops
    public function getShops(Request $request)
    {
        //Get coordinates
        $lat = (string)$request->input('lat');
        $lng = (string)$request->input('lng');

        //Make Query to Calculate distance
        $qry = 'SELECT id,shop_name,shop_description, SQRT(POW(69.1 * (lat - '.$lat.'), 2) +POW(69.1 * ('.$lng.' - lng) * COS(lat / 57.3), 2)) AS distance FROM t_shop HAVING distance < 25 and id not in (select shop_id from t_disliked WHERE TIMESTAMPDIFF(HOUR, unliked, NOW()) > 2 ) ORDER BY distance';

        $shops = DB::select($qry);
        return response()->json($shops);
    } 
    //Function that return preferred shops
    public function preferredShop(Request $request)
    {
        //get user id
        $id = \Auth::user()->id;

        //select favorites shops for current user
        $qry = 'SELECT id,shop_name,shop_description FROM t_shop WHERE id in (select shop_id from t_liked where user_id='.$id.')';

        $shops = DB::select($qry);
    return response()->json($shops);
    }
}
