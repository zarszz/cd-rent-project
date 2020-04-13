<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompactDisc;
use App\UserRentCompactDisc;
use App\UserPayRent;

class UserPayRentController extends Controller
{
     /**
     * Instantiate a new UserPayRentController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function payRental(Request $request)
    {
        $this->validate($request, [
            'rent_id' => 'required',
            'money_from_user' => 'required'
        ]);
        $rentalData = UserRentCompactDisc::find($request->rent_id);
        if($rentalData){
            try {
                $userPayment = UserPayRent::select('is_already_do_payment', 'total_payment')
                                ->where('rent_id', '=', $request->rent_id)
                                ->get()[0];
                if(!$userPayment->is_already_do_payment && $userPayment) {
                    if($request->money_from_user >= $userPayment->total_payment){
                        UserPayRent::where('rent_id', '=', $request->rent_id)->update(['is_already_do_payment' => 1]);

                        return response()->json([
                            "status" => "success",
                            "total" => $userPayment->total_payment,
                            "change" => $request->money_from_user - $userPayment->total_payment
                        ], 200);
                    } else {
                        return response()->json(['status' => 'failed', 'message' => 'less money'], 400);
                    }
                } else {
                    return response()->json(
                        ['status' => 'failed',
                        'message' => 'user is already do payment rental with id' . $userPayment->rent_id
                        ], 400);
                }
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'an error occured'
                ]);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'rental data not found'], 404);
        }
    }
}
