<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{    
    /**
     * Get all users
     * 
     * /user [GET]
     */
    public function testShouldReturnAllUsers()
    {
        $this->get('/api/user', $this->generateHeadersToken());
        $this->seeStatusCode(200);
    }

    /**
     * Get user by id
     * 
     * /user<:id> [GET]
     */
    public function testShouldReturnUser()
    {
        $user = \App\User::find(1);       
        $this->get("/api/user/" . $user->id, $this->generateHeadersToken());
        $this->seeStatusCode(200);
    }

    /**
     * Update user data by id
     * 
     * /user [PUT]
     */
    public function testShouldUpdateUserData()
    {
        $user = \App\User::find(1);
        $valid_data = [
            "email" => $user->email,
            "first_name" => $user->first_name . " updated",
            "last_name" => $user->last_name . " updated",
            "password" => $user->password,
            "username" => $user->username . " updated",
        ];
        $this->put('/api/user/' . $user->id, $valid_data, $this->generateHeadersToken());
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'id',
            'email',
            'username',
            'first_name',
            'last_name',
            'address'
        ]);
        $user_after_update = \App\User::find(1);
        $this->seeJsonEquals($user_after_update->toArray());
    }

    /**
     * Invalid /user [PUT]
     * TODO add try catch to every block
     */
    public function testShoulCannotUpdateUserData()
    {
        $user = \App\User::find(1);
        $invalid_data = [
            "email" => $user->email,
            "first_name" => $user->first_name . " updated",
            "last_name" => $user->last_name . " updated",
            "invalid_column" => "invalid_data",
            "password" => $user->password
        ];
        $this->put('/api/user/' . $user->id, $invalid_data, $this->generateHeadersToken());
        $this->seeStatusCode(500);
    }

    /**
     * Unauthorized /user [PUT]
     */
    public function testShouldCannotUpdateUserDataUnAuth()
    {
        $headers = ['Authorization' => 'INVALID TOKEN'];
        $user = \App\User::find(1);
        $valid_data = [
            "email" => $user->email,
            "first_name" => $user->first_name . " updated",
            "last_name" => $user->last_name . " updated",
            "password" => $user->password,
            "username" => $user->username . " updated",
        ];
        $this->put('/api/user/' . $user->id, $valid_data, $headers);
        $this->seeStatusCode(401);
    }
}
