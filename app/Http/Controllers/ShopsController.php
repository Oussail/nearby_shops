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

        //Make a Query to Calculate distance
        $qry = 'SELECT id,shop_name,shop_description, SQRT(POW(69.1 * (lat - :lat), 2) +POW(69.1 * (:lng - lng) * COS(lat / 57.3), 2)) AS distance FROM t_shop HAVING distance < 25 and id not in (select shop_id from t_disliked WHERE TIMESTAMPDIFF(HOUR, unliked, NOW()) > 2 ) and  id not in (select shop_id from t_liked) ORDER BY distance';

        $shops = DB::select($qry,['lat' => $lat,'lng' => $lng]);
        return response()->json($shops);
    } 
    //Function that return preferred shops
    public function preferredShop()
    {
        //get user id
        $id = \Auth::user()->id;

        //select favorites shops for current user
        $shops = DB::select('SELECT id,shop_name,shop_description FROM t_shop WHERE id in (select shop_id from t_liked where user_id= :id)', ['id' => $id]);

    return response()->json($shops);
    }

    //Function make user opinion by like or dislike a shop 
    public function user_opinion(Request $request)
    {
        //retrieve user id
        $user_id = \Auth::user()->id;
        //get shop id
        $shop_id = (string)$request->input('shop_id');
        //get opinion*
        $opinion = (string)$request->input('opinion');
        if($opinion == 1)
        {
        DB::delete('delete from t_disliked where shop_id=:id1 and user_id=:id2',['id1' => $shop_id,'id2' => $user_id]);
        DB::insert('insert into t_liked (liked,user_id,shop_id) values (NOW(), ?, ?)', [$user_id, $shop_id]);
        }else if($opinion == 0)
        {
        DB::delete('delete from t_liked where shop_id=:id1 and user_id=:id2',['id1' => $shop_id,'id2' => $user_id]);
        DB::insert('insert into t_disliked (unliked,user_id,shop_id) values (NOW(), ?, ?)', [$user_id, $shop_id]);
        }
    }
    //Function that  remove shop from preferred shop page
    public function remove_shop(Request $request)
    {
        //retrieve user id
        $user_id = \Auth::user()->id;
        //get shop id
        $shop_id = (string)$request->input('shop_id');
        DB::delete('delete from t_liked where shop_id=:id1 and user_id=:id2',['id1' => $shop_id,'id2' => $user_id]);
    }
}
