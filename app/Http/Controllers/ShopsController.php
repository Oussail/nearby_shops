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
        //get user id
        $id = \Auth::user()->id;
        //Get coordinates
        $lat = (string)$request->input('lat');
        $lng = (string)$request->input('lng');

        //Make a Query to Calculate distance
        $qry = 'SELECT id,shop_name,shop_description, SQRT(POW(69.1 * (lat - :lat), 2) +POW(69.1 * (:lng - lng) * COS(lat / 57.3), 2)) AS distance FROM t_shop HAVING distance < 25 and id not in (select shop_id from t_disliked WHERE TIMESTAMPDIFF(HOUR,unliked, NOW()) < 2 and user_id=:user_id1) and  id not in (select shop_id from t_liked where user_id=:user_id2) ORDER BY distance';
        //Another way to do it
        //$shops = DB::table('t_shop')
        //        ->select('id,shop_name,shop_description', DB::raw('SQRT(POW(69.1 * (lat - :lat), 2) +POW(69.1 * (:lng - lng) * COS(lat // 57.3), 2)) AS distance'))
        //        ->orderBy('distance')
        //       ->havingRaw('distance < 25 and id not in (select shop_id from t_disliked WHERE TIMESTAMPDIFF(HOUR,unliked, NOW()) < 2 ) and  id not in (select shop_id from t_liked)')
        //        ->get();
        $shops = DB::select($qry,['lat' => $lat,'lng' => $lng,'user_id1' => $id,'user_id2' => $id]);
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
    public function LikeShop(Request $request)
    {
        //retrieve user id
        $user_id = \Auth::user()->id;
        //get shop id
        $shop_id = (string)$request->input('shop_id');

        DB::delete('delete from t_disliked where shop_id=:id1 and user_id=:id2',['id1' => $shop_id,'id2' => $user_id]);
        DB::insert('insert into t_liked (liked,user_id,shop_id) values (NOW(), ?, ?)', [$user_id, $shop_id]);
    }
    //Function make user opinion by like or dislike a shop 
    public function DislikeShop(Request $request)
    {
        //retrieve user id
        $user_id = \Auth::user()->id;
        //get shop id
        $shop_id = (string)$request->input('shop_id');
        //i add this try-catch clause because after 2 hours the dislike shops will appear again in the main page so i will update the unliked time again
        try
        {
            DB::insert('insert into t_disliked (unliked,user_id,shop_id) values (NOW(), ?, ?)', [$user_id, $shop_id]);
            DB::delete('delete from t_liked where shop_id=:id1 and user_id=:id2',['id1' => $shop_id,'id2' => $user_id]);
        }catch(Exception $e)
        {
            DB::update('update t_disliked set unliked=NOW() where shop_id = ? and user_id = ?', [$user_id, $shop_id]);
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
