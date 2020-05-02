<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\UserPayRent;

class UserPayRentControllerTest extends TestCase
{
    /**
     * Successfully pay a returned compact disc
     *
     * /user-rent/pay [POST]
     */
    public function testShouldSuccessfullyDoPayment()
    {
        $transactionData = UserPayRent::latest()->first();
        $transactionData->is_already_do_payment = 0;
        $transactionData->save();
        $validData = [
            'rent_id' => $transactionData->rent_id,
            'money_from_user' => $transactionData->total_payment + 1000
        ];
        $this->post('/api/user-rent/pay', $validData, $this->generateHeadersToken());
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'total',
            'change'
        ]);
        $this->seeJsonEquals([
            'status' => 'success',
            'total' => $transactionData->total_payment,
            'change' => 1000
        ]);
        $transactionData->is_already_do_payment = 0;
        $transactionData->save();
    }

    /**
     * Fail do payment with less money given
     *
     * /user-rent/pay [POST]
     */
    public function testShouldFailedDoPaymentWithLessMoney()
    {
        $transactionData = App\UserPayRent::latest()->first();
        $transactionData->is_already_do_payment = 0;
        $transactionData->save();
        $data = [
            'rent_id' => $transactionData->rent_id,
            'money_from_user' => $transactionData->total_payment - 1000
        ];
        $this->post('/api/user-rent/pay', $data, $this->generateHeadersToken());
        $this->seeStatusCode(400);
        $this->seeJsonStructure([
            'status',
            'message'
        ]);
        $this->seeJsonEquals([
            'status' => 'failed',
            'message' => 'less money'
        ]);
    }

    /**
     * Fail pay with already do payment
     *
     * /user-rent/pay [POST]
     */
    public function testShouldFailedDoPaymentWithAlreadyDoPayment()
    {
        $payedTransactions = UserPayRent::where('is_already_do_payment', '=', 1)->first();
        $data = [
            'rent_id' => $payedTransactions->rent_id,
            'money_from_user' => $payedTransactions->total_payment + 1000
        ];
        $this->post('/api/user-rent/pay', $data, $this->generateHeadersToken());
        $this->seeStatusCode(400);
        $this->seeJsonStructure([
            'status',
            'message'
        ]);
        $this->seeJsonEquals([
            'status' => 'failed',
            'message' => 'user is already do payment rental with id'
        ]);
    }

    /**
     * Fail pay with no money given
     *
     * /user-rent/pay [POST]
     */
    public function testShouldFailedDoPaymentWithNoMoneyGiven()
    {
        $transactionData = App\UserPayRent::latest()->first();
        $data = [
            'rent_id' => $transactionData->rent_id
        ];
        $this->post('/api/user-rent/pay', $data, $this->generateHeadersToken());
        $this->seeStatusCode(422);
        $this->seeJsonEquals([
            'money_from_user' => [
                'The money from user field is required.'
            ]
        ]);
    }

    /**
     * Fail pay with no token provided
     *
     * /user-rent/pay [POST]
     */
    public function testShouldFailedDoPaymentWithNoTokenProvided()
    {
        $data = [
            'rent_id' => 6262615263,
            'money_from_user' => 1000000
        ];
        $this->post('/api/user-rent/pay', $data);
        $this->seeStatusCode(401);
    }
}
