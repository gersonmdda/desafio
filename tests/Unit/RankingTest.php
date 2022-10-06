<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\RankingService;
use App\Repository\PersonalRecordRepository;
use App\Repository\MovementRepository;
use Illuminate\Support\Facades\App;
use App\Models\Movement;

class RankingTest extends TestCase
{
   
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_ranking_mock()
    {


        $array = [
            0 => (object) [
                "record" => 190.0,
                "user_name" => "Jose",
                "date" => "2021-01-06 00:00:00"
            ],
            1 => (object) [
                "record" => 180.0,
                "user_name" => "Joao",
                "date" => "2021-01-02 00:00:00"
            ],
            2 => (object) [
                "record" => 170.0,
                "user_name" => "Paulo",
                "date" => "2021-01-01 00:00:00"
            ]
        ];

        $repositoryPersonalRecord = $this->getMockBuilder(PersonalRecordRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->setMethods(['getRanking'])
            ->getMock();

        $repositoryPersonalRecord->expects($this->once())
            ->method('getRanking')
            ->with(1)
            ->willReturn($array);

        $movement_object = new Movement();
        $movement_object->name = "Deadlift";

        $repositoryMovement = $this->getMockBuilder(MovementRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->setMethods(['getMovement'])
            ->getMock();

        $repositoryMovement->expects($this->once())
            ->method('getMovement')
            ->with(1)
            ->willReturn($movement_object);


        $service = new RankingService($repositoryPersonalRecord,$repositoryMovement);

        $list = $service->getRanking(1);

        $this->assertEquals($list['movement'],"Deadlift");

        $this->assertEquals($list['ranking'][0]->position,1);
        $this->assertEquals($list['ranking'][1]->position,2);
        $this->assertEquals($list['ranking'][2]->position,3);

    }


}
