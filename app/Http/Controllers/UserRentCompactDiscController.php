<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\CompactDisc;
use App\UserRentCompactDisc;

use DateTime;

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
    function index()
    {
        return response()->json(UserRentCompactDisc::all(), 200);
    }

    /**
     * Return all user and  the cd that has been rented with more complete response
     */
    public function show_all_data()
    {
        $userRentRawData =  UserRentCompactDisc::all();
        $userRentDatas = array();
        foreach ($userRentRawData as $user_rent_data) {
            $user = User::find($user_rent_data['id']);
            $compactDisc = CompactDisc::find($user_rent_data['compact_disc_id']);
            $data = [
                'user' => $user,
                'cd_data' => $compactDisc,
                'rent_date' => $user_rent_data['rent_date'],
                'return_date' => $user_rent_data['return_date'] == NULL ? 'not returned' : $user_rent_data['return_date'],
                'return_date' => $user_rent_data['return_date'],
            ];
            array_push($userRentDatas, $data);
        }
        return response()->json($userRentDatas, 200);
    }

    /**
     * Rental the cd with logged in user
     * 
     * @param Request $request
     * @return array
     */
    public function rent(Request $request)
    {
        if(User::find($request->user_id) && CompactDisc::find($request->compact_disc_id)){
            $quantity = CompactDisc::select('quantity')->where('id', '=', $request->compact_disc_id)->get()[0]['quantity'];
            if($quantity > 0){
                $disc = CompactDisc::find($request->compact_disc_id);
                
                // decrement quantity
                $disc->quantity = $quantity - 1;
                
                $userRentCompactDisc = new UserRentCompactDisc;
                $userRentCompactDisc->user_id = $request->user_id;
                $userRentCompactDisc->compact_disc_id = $request->compact_disc_id;
                $userRentCompactDisc->rent_date = new \Datetime('now');

                $userRentCompactDisc->save();
                $disc->save();

                return response()->json(['status' => 'success', 'message' => $userRentCompactDisc], 201);
            } else {
                return response()->json(['status' => 'sailed', 'message' => 'out of stock'], 400);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'user or cd not found'], 404);
        }
    }

    /**
     * Return the cd wih logged in user
     * 
     * @param Request $request
     * @return array
     */
    public function return(Request $request)
    {
        $compactDisc = CompactDisc::find($request->compact_disc_id);
        $user = User::find($request->user_id);
        $userRentCompactDisc = UserRentCompactDisc::find($request->id);
        if($user &&  $compactDisc && $userRentCompactDisc){
            $rentDdate = UserRentCompactDisc::select('rent_date')->where('id', '=', $request->id)->get()[0]['rent_date'];
            $returnDateRaw = new \Datetime('now');
            $returnDate = $returnDateRaw->format('Y-m-d H:s:i');

            // rent date
            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $rentDdate);

            // return date
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $returnDate);            

            $diffInDays = $to->diffInDays($from);
             
            $rating = CompactDisc::select('rate')
                        ->where('id', '=', $request->compact_disc_id)
                        ->get()[0]['rate'];

            $validatedRating = $this->validateRating($rating);
            
            if($diffInDays == 0){
                $cost = 1 * $validatedRating * 1000;
            } else if ($diffInDays > 0){
                $cost = $diffInDays * $validatedRating * 1000;
            } else {
                $cost = 0;
            }

            if ($cost > 0) {
                // set return_date in record to Date now
                $userRentCompactDisc->return_date = $to;

                // increment cds quantity
                $compactDisc->quantity = $compactDisc->quantity + 1;

                $userRentCompactDisc->save();
                $compactDisc->save();

                return response()->json(['status' => 'success', 
                                         'total rental day' => $diffInDays,
                                         'cost' => $cost,
                                         'dvd data' => CompactDisc::find($request->compact_disc_id)
                                        ], 201);
            } else {
                return response()->json(['status' => 'failed', 400]);
            }
        } else {
            return response()->json(['status' => 'failed','message' => 'user or cd not found'], 404);
        }
    }

    /**
     * Validate rating 
     * 
     * @param Float $rating
     * @return @Float $rating
     */
    private function validateRating($rating)
    {
        if($rating == 0){
            return 1;
        } else if($rating > 0) {
            return $rating;
        } else {
            return 0;
        }
    }
}
