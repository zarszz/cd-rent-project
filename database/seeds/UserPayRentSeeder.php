<?php

use Illuminate\Database\Seeder;
use App\UserPayRent;
use App\UserRentCompactDisc;
use App\CompactDisc;

class UserPayRentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userPayRentData1 = $this->generateUserPaySeederData(1);
        $userPayRentData2 = $this->generateUserPaySeederData(2);
        UserPayRent::create($userPayRentData1);
        UserPayRent::create($userPayRentData2);
    }

    /**
     * Generate data for user pay rent seeder scenario
     *
     * @param Integer $rentalId
     * @return @Array
     */
    private function generateUserPaySeederData($rentalId)
    {
        $rentalCompactDisc = UserRentCompactDisc::find($rentalId);

        $rentDate = $rentalCompactDisc->rent_date;
        $returnDate = $rentalCompactDisc->return_date;

        // rent date
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $rentDate);
        // return date
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $returnDate);

        $rentalDuration = $to->diffInDays($from);

        $rating = CompactDisc::select('rate')
                    ->where('id', '=', $rentalCompactDisc->compact_disc_id)
                    ->get()[0]['rate'];

        $validatedRating = $this->validateRating($rating);

        if($rentalDuration == 0){
            $totalPayment = 1 * $validatedRating * 1000;
        } else if ($rentalDuration > 0){
            $totalPayment = $rentalDuration * $validatedRating * 1000;
        } else {
            $totalPayment = 0;
        }

        return [
            "rent_id" => $rentalId,
            "total_payment" => $totalPayment,
            "rental_duration" => $rentalDuration
        ];
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
