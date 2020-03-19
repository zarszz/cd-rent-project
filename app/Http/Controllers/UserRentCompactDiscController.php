<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\CompactDisc;
use App\UserRentCompactDisc;

class UserRentCompactDiscController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Return all user and  the cd that has been rented
     */
    function index(){
        return UserRentCompactDisc::all();
    }

    /**
     * Return all user and  the cd that has been rented with more complete response
     */
    public function show_all_data() {
        $user_rent_raw_data =  UserRentCompactDisc::all();
        $user_rent_datas = array();
        foreach ($user_rent_raw_data as $user_rent_data) {
            $user = User::find($user_rent_data['id']);
            $compact_disc = CompactDisc::find($user_rent_data['compact_disc_id']);
            $data = [
                'user' => $user,
                'cd_data' => $compact_disc,
                'rent_date' => $user_rent_data['rent_date'],
                'return_date' => $user_rent_data['return_date'] == NULL ? 'not returned' : $user_rent_data['return_date'],
                'return_date' => $user_rent_data['return_date'],
            ];
            array_push($user_rent_datas, $data);
        }
        return $user_rent_datas;
    }

    /**
     * Rent the cd with logged user
     * 
     * @param Request $request
     * @return array
     */
    public function rent(Request $request) {
        if(User::find($request->user_id) && CompactDisc::find($request->compact_disc_id)){
            $stock = CompactDisc::select('quantity');
            if($stock > 0){
                $userRentCompactDisc = new UserRentCompactDisc;
                $userRentCompactDisc->user_id = $request->user_id;
                $userRentCompactDisc->compact_disc_id = $request->compact_disc_id;
                $userRentCompactDisc->rent_id = new DateTime('now');

                $userRentCompactDisc->save();

                $content = ['status' => 'Success', 'code' => 201, 'message' => $userRentCompactDisc];
            } else {
                $content = ['status' => 'Failed', 'code' => 400, 'message' => 'Out of stock'];
            }
        } else {
            $content = ['status' => 'Failed', 'code' => 404, 'message' => 'User id or CD id not found'];
        }
        return $content;
    }

    /**
     * Return the cd wih logged user
     * 
     * @param Request $request
     * @return array
     */
    public function return(Request $request) {
        if(User::find($request->user_id) && CompactDisc::find($request->compact_disc_id) && UserRentCompactDisc::find($request->id)){
            $rent_date = UserRentCompactDisc::select('rent_date')->where('id', '=', $request->id);            
            $return_date = new Date('now');
            $rating = CompactDisc::select('rating')->where('id', '=', $request->compact_disc_id);
        } else {
            $content = ['status' => 'Failed', 'code' => 404, 'message' => 'User id or CD id not found'];
        }
    }
}
