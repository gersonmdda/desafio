<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\RankingService;
use App\Repository\PersonalRecordRepository;
use Illuminate\Support\Facades\App;

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
                "name" => "Jose",
                "record" => 190.0,
            ],
            1 => (object) [
                "name" => "Joao",
                "record" => 180.0,
            ],
            2 => (object) [
                "name" => "Paulo",
                "record" => 170.0,
            ]
        ];

        $repository = $this->getMockBuilder(PersonalRecordRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->setMethods(['getRanking'])
            ->getMock();

        $repository->expects($this->once())
            ->method('getRanking')
            ->with(1)
            ->willReturn($array);


        $service = new RankingService($repository);

        $list = $service->getRanking(1);

        $this->assertEquals($list[0]->position,1);
        $this->assertEquals($list[1]->position,2);
        $this->assertEquals($list[2]->position,3);

    }


}
