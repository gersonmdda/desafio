<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RankingTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Artisan::call('db:seed');
        $this->movementOne(1);
        $this->movementTwo(2);
        $this->movementThree(3);

    }
   

    public function movementOne(int $one =1)
    {
        
        $response = $this->json('GET','/api/get-ranking',['movement'=>$one]);
    
        
        $response
            ->assertStatus(200)
            ->assertJson(['status' => true])
            ->assertJsonPath('response.0.name', 'Jose')
            ->assertJsonPath('response.0.position', 1)
            ->assertJsonPath('response.1.name', 'Joao')
            ->assertJsonPath('response.1.position', 2)
            ->assertJsonPath('response.2.name', 'Paulo')
            ->assertJsonPath('response.2.position', 3);
    }

    public function movementTwo(int $two = 2)
    {
        $response = $this->json('GET','/api/get-ranking',['movement'=>$two]);
        
        $response
            ->assertStatus(200)
            ->assertJson(['status' => true])
            ->assertJsonPath('response.0.name', 'Joao')
            ->assertJsonPath('response.0.position', 1)
            ->assertJsonPath('response.1.name', 'Jose')
            ->assertJsonPath('response.1.position', 1)
            ->assertJsonPath('response.2.name', 'Paulo')
            ->assertJsonPath('response.2.position', 2);

      
    }

    public function movementThree(int $three = 3)
    {
        $response = $this->json('GET','/api/get-ranking',['movement'=>$three]);

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => true,
            "response"=> []
        ]);

    }
}
