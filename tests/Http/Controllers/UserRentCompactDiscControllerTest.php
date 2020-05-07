<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserRentCompactDiscControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Return all rent data
     *
     * /user-rents [GET]
     */
    public function testShouldReturnAllRentData()
    {
        $this->get('/api/user-rents', $this->generateHeadersToken());
        $this->seeStatusCode(200);
    }

     /**
     * Return all detail rents data
     *
     * /user-rents/detail [GET]
     */
    public function testShouldReturnAllSpecificData()
    {
        $this->get('/api/user-rents/detail', $this->generateHeadersToken());
        $this->seeStatusCode(200);
    }

    /**
     * Create new user rent data
     *
     * /user-rent/rent [POST]
     */
    public function testShouldCreateUserRentCompactDisc()
    {
        $userRentCompactDisc = factory('App\UserRentCompactDisc')->make();
        $this->post('/api/user-rent/rent', $userRentCompactDisc->toArray(), $this->generateHeadersToken());
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            "status",
            "message" => [
                "user_id",
                "rent_date" => [
                    "date",
                    "timezone_type",
                    "timezone"
                ],
                "updated_at",
                "created_at",
                "id"
            ]
        ]);
        $this->seeInDatabase('user_rent_compact_discs',
            [
                'user_id' => $userRentCompactDisc->user_id,
                'compact_disc_id' => $userRentCompactDisc->compact_disc_id
            ]
        );
    }

    /**
     * User return rented cd
     *
     * /user-rent/return POST
     */
    public function testShouldUpdateUserRentCompactDisc()
    {
        $returnCompactDisc = App\UserRentCompactDisc::latest()->first();
        $valid_data = [
            'id' => $returnCompactDisc->id,
            'user_id' => $returnCompactDisc->user_id,
            'compact_disc_id' => $returnCompactDisc->compact_disc_id
        ];
        $this->post('/api/user-rent/return', $valid_data, $this->generateHeadersToken());
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'status',
            'data' => [
                'total rental day',
                'cost',
                'dvd data' => [
                    'id',
                    'title',
                    'rate',
                    'category',
                    'quantity',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /**
     * Invalid /user-rent/rent POST
     */
    public function testShouldNotCreatedUserRentCompactDisc()
    {
        $userRentCompactDisc = factory('App\UserRentCompactDisc')->make();
        $invalid_data = [
            'user_id' => 'INVALID USER ID',
            'compact_disc_id' => $userRentCompactDisc->compact_disc_id
        ];
        $this->post('/api/user-rent/rent', $invalid_data, $this->generateHeadersToken());
        $this->seeStatusCode(404);
        $this->seeJsonEquals([
            'status' => 'failed',
            'message' => 'user or cd not found'
        ]);
    }

    /**
     * Invalid /user-rent/return POST
     */
    public function testShouldNotUpdateUserRentCompactDisc()
    {
        $returnCompactDisc = App\UserRentCompactDisc::latest()->first();
        $invalid_data = [
            'id' => $returnCompactDisc->id,
            'user_id' => $returnCompactDisc->user_id,
            'compact_disc_id' => 'INVALID CD ID'
        ];
        $this->post('/api/user-rent/return', $invalid_data, $this->generateHeadersToken());
        $this->seeStatusCode(404);
        $this->seeJsonEquals([
            'status' => 'failed',
            'message' => 'user or cd not found'
        ]);
    }

    /**
     * Unauthorized /user-rent/rent POST
     */
    public function testShouldNotCreatedUserRentCompactDiscUnAuth()
    {
        $headers = ['Authorization' => 'INVALID TOKEN'];
        $userRentCompactDisc = factory('App\UserRentCompactDisc')->make();
        $this->post('/api/user-rent/rent', $userRentCompactDisc->toArray(), $headers);
        $this->seeStatusCode(401);
    }

    /**
     * Unauthorized /user-rent/return POST
     */
    public function testShouldNotUpdateUserRentCompactDiscUnAuth()
    {
        $headers = ['Authorization' => 'INVALID TOKEN'];
        $returnCompactDisc = App\UserRentCompactDisc::latest()->first();
        $valid_data = [
            'id' => $returnCompactDisc->id,
            'user_id' => $returnCompactDisc->user_id,
            'compact_disc_id' => $returnCompactDisc->compact_disc_id
        ];
        $this->post('/api/user-rent/return', $valid_data, $headers);
        $this->seeStatusCode(401);
    }

}
