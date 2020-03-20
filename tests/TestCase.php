<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];
    
        if (!is_null($user)) {
            $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
            $headers['Authorization'] = 'Bearer '.$token;
        }
    
        return $headers;
    }

    /**
     * Generate JWT token
     * 
     * @return String
     */
    protected function generateHeadersToken()
    {
        $headers = ['Accept' => 'application/json'];
        $user = \App\User::find(1);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $headers['Authorization'] = 'Bearer'.$token;
        return $headers;
    }
}
