<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CompactDiscControllerTest extends TestCase
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
     * Get all cds
     * 
     * /compact-disc [GET]
     */
    public function testShouldReturnAllDiscs()
    {
        $this->get('/api/compact-disc', $this->generateHeadersToken());
        $this->seeStatusCode(200);
    }

    /**
     * Get cd by id
     * 
     * /compact-disc/<:id> [GET]
     */
    public function testShouldReturnDisc()
    {
        $disc = \App\CompactDisc::find(1);
        $this->get("/api/compact-disc/" . $disc->id, $this->generateHeadersToken());
        $this->seeStatusCode(200);
    }

    /**
     * Create new cd
     * 
     * /compact-disc/ [POST]
     */
    public function testShouldCreateCompactDisc()
    {
        $validData = factory('App\CompactDisc')->make();
        $this->post('/api/compact-disc', $validData->toArray(), $this->generateHeadersToken());
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'id',
            'title',
            'rate',
            'category',
            'quantity',
            'created_at',
            'updated_at'
        ]);
    }

    /**
     * Update cd by id
     */
    public function testShouldUpdateCompactDiscData()
    {
        $disc = \App\CompactDisc::find(20);
        $validData = [
            "title" => $disc->title . " updated",
            "rate" => $disc->rate + 1.0,
            "category" => $disc->category . " updated",
            "quantity" => $disc->quantity + 1
        ];
        $this->put('/api/compact-disc/' . $disc->id, $validData, $this->generateHeadersToken());
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'id',
            'title',
            'rate',
            'category',
            'quantity',
            'created_at',
            'updated_at'
        ]);
        $discAfterUpdate = \App\CompactDisc::find(20);
        $this->seeJsonEquals($discAfterUpdate->toArray());
    }

    /**
     * Update cd stock by id
     */
    public function testShouldUpdateCompactDiscStockData()
    {
        $disc = \App\CompactDisc::find(1);
        $validData = ['quantity' => $disc->quantity + 1];
        $this->patch('/api/compact-disc/' . $disc->id, $validData, $this->generateHeadersToken());
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'id',
            'title',
            'rate',
            'category',
            'quantity',
            'created_at',
            'updated_at'
        ]);
        $discAfterUpdate = \App\CompactDisc::find(1);
        $this->seeJsonEquals($discAfterUpdate->toArray());
    }

    /**
     * Invalid /compact-disc [PUT]
     */
    public function testShouldCannotUpdateCompactDiscData()
    {
        $disc = \App\CompactDisc::find(1);
        $invalidData = [
            'title' => 'Shingeky no Kyoojin',
            'rate' => 4.1,
            'category' => 'anime',
            'invalid_column' => 'invalid_data',
            'invalid_column_2' => 'invalid_data_2',
        ];
        $this->put('/api/compact-disc/' . $disc->id, $invalidData, $this->generateHeadersToken());
        $this->seeStatusCode(500);
    }
    
    /**
     * Unauthorized /compact-disc [POST]
     */
    public function testShouldNotCreateCompactDiscUnAuth()
    {
        $headers = ['Authorization' => 'INVALID TOKEN'];
        $validData = factory('App\CompactDisc')->make();
        $this->post('/api/compact-disc',$validData->toArray(), $headers);
        $this->seeStatusCode(401);
    }

    /**
     * Unauthorized /compact-disc [PATCH]
     */
    public function testShouldCannotUpdateCompactDiscStockUnAuth()
    {
        $headers = ['Authorization' => 'INVALID TOKEN'];
        $compactDisc = App\CompactDisc::latest()->first();
        $validData = [
            'quantity' => 100
        ];
        $this->put('/api/compact-disc'.'/'.$compactDisc->id,$validData, $headers);
        $this->seeStatusCode(401);
    }    

    /**
     * Unauthorized /compact-disc [GET]
     */
    public function testShouldCannotReturnCompactDisc()
    {
        $disc = \App\CompactDisc::find(1);
        $headers = ['Authorization' => 'INVALID TOKEN'];
        $this->get('/api/compact-disc/' . $disc->id, $headers);
        $this->seeStatusCode(401);
    }
}
