<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    /**
     * Register new user
     * 
     * /register [POST]
     */
    public function testShouldCreateUser()
    {
        $validData = factory('App\User')->make();
        $this->post('/api/register', $validData->toArray());
        $this->seeStatusCode(201);
        $createdUser = \App\User::latest()->first();
        $this->seeJsonEquals(
            [
                'message' => 'created', 
                'user' => $createdUser->toArray()
            ]
        );
    }

    /**
     * Login to existed user
     *      
     * /login [POST]
     */
    public function testShouldLoginUser()
    {
        $validData = [
            'email' => 'udin@email.com',
            'password' => 'password'
        ];
        $this->post('/api/login', $validData);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['message',
             'data' => 
                [
                    'token',
                    'token_type',
                    'expires_in'
                ]
            ]);
    }

     /**
     * Invalid register new user
     * 
     * /register [POST]
     */
    public function testNotShouldCreateUser()
    {
        $invalidData = [
            'username' => 'udin',
            'email' => 'udin@email.com',
            'first_name' => 'udin',
            'last_name' => 'stephen',
            'invalid_column' => 'babakan',
            'password' => 'password'
        ];
        $this->post('/api/register', $invalidData);
        $this->seeStatusCode(400);
        $this->seeJsonEquals(['message' => 'registration failed']);
    }

    /**
     * Invalid /login [POST]
     */
    public function testShouldNotLogindUser()
    {
        $invalidData = [
            'email' => 'INVALID EMAIL',
            'password' => 'INVALID PASSWORD'
        ];
        $this->post('/api/login', $invalidData);
        $this->seeStatusCode(401);
        $this->seeJsonEquals(['message' => 'email or password wrong']);
    }        
}
