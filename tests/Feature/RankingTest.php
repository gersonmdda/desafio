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
    public function test_ranking()
    {
        Artisan::call('db:seed');
        $this->movementOne(1);
        $this->movementTwo(2);
        $this->movementThree(3);
        $this->movementFour(4);
        $this->notInt('test');
        
    }
   

    public function movementOne(int $one = 1)
    {
        
        $response = $this->json('GET','/api/get-ranking',['movement'=>$one]);

    
        $response
            ->assertStatus(200)
            ->assertJson(['status' => true])
            ->assertJsonPath('response.movement', 'Deadlift')
            ->assertJsonPath('response.ranking.0.user_name', 'Jose')
            ->assertJsonPath('response.ranking.0.position', 1)
            ->assertJsonPath('response.ranking.0.date', "2021-01-06 00:00:00")
            ->assertJsonPath('response.ranking.1.user_name', 'Joao')
            ->assertJsonPath('response.ranking.1.position', 2)
            ->assertJsonPath('response.ranking.1.date', "2021-01-02 00:00:00")
            ->assertJsonPath('response.ranking.2.user_name', 'Paulo')
            ->assertJsonPath('response.ranking.2.position', 3)
            ->assertJsonPath('response.ranking.2.date', "2021-01-01 00:00:00");
    }

    public function movementTwo(int $two = 2)
    {
        $response = $this->json('GET','/api/get-ranking',['movement'=>$two]);

       
        
        $response
            ->assertStatus(200)
            ->assertJson(['status' => true])
            ->assertJsonPath('response.movement', 'Back Squat')
            ->assertJsonPath('response.ranking.0.user_name', 'Joao')
            ->assertJsonPath('response.ranking.0.position', 1)
            ->assertJsonPath('response.ranking.0.date', "2021-01-03 00:00:00")
            ->assertJsonPath('response.ranking.1.user_name', 'Jose')
            ->assertJsonPath('response.ranking.1.position', 1)
            ->assertJsonPath('response.ranking.1.date', "2021-01-03 00:00:00")
            ->assertJsonPath('response.ranking.2.user_name', 'Paulo')
            ->assertJsonPath('response.ranking.2.position', 2)
            ->assertJsonPath('response.ranking.2.date', "2021-01-03 00:00:00");

      
    }

    public function movementThree(int $three = 3)
    {
        $response = $this->json('GET','/api/get-ranking',['movement'=>$three]);

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => true
        ])->assertJsonPath('response.movement','Bench Press')
        ->assertJsonPath('response.ranking',[]);

    }

    public function movementFour(int $four = 4)
    {
        $response = $this->json('GET','/api/get-ranking',['movement'=>$four]);
        $response
        ->assertStatus(400)
        ->assertJson([
            'status' => false,
            'error' => "movimento não encontrado"
        ]);

    }

    public function notInt(string $notInt = 'a')
    {
        $response = $this->json('GET','/api/get-ranking',['movement'=>$notInt]);

        $response
        ->assertStatus(500);

    }

}
