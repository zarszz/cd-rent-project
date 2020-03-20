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
        $data = factory('App\User')->make();
        $validData = [
            'username' => $data->username,
            'email' => $data->email,
            'password' => bin2hex(openssl_random_pseudo_bytes(16)),
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'address' => $data->address
        ];
        $this->post('/api/register', $validData);
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
        $user = App\User::latest()->get();        
        $validData = [
            'email' => 'ucok@email.com',
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
        $this->seeStatusCode(422);
        $this->seeJsonEquals([
            "address" =>[
                "The address field is required."
                ]
            ]);
    }

    /**
     * Invalid /login [POST]
     */
    public function testShouldNotLoginUser()
    {
        $invalidData = [
            'email' => 'invalid@email.com',
            'password' => 'INVALID PASSWORD'
        ];
        $this->post('/api/login', $invalidData);
        $this->seeStatusCode(401);
        $this->seeJsonEquals(['message' => 'email or password wrong']);
    }        
}
