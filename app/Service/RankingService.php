<?php

namespace App\Service;

use Illuminate\Support\Facades\Redis;
use App\Repository\PersonalRecordRepository;
use App\Repository\MovementRepository;
use \Exception;


class RankingService
{
    protected PersonalRecordRepository $personalRecordRepository;
    protected MovementRepository $movementRepository;

    function __construct(PersonalRecordRepository $personalRecordRepository,MovementRepository $movementRepository) 
    {
        $this->personalRecordRepository = $personalRecordRepository;
        $this->movementRepository = $movementRepository;
    }

    public function getRanking(int $movementId):? array 
    {
        if(env("APP_ENV") != 'testing' && Redis::exists('ranking_movement:'.$movementId)){
            $list = json_decode(Redis::get('ranking_movement:'.$movementId));
        }else{
            $list = $this->personalRecordRepository->getRanking($movementId);
            if($list){
                $list = $this->definesRanking($list);
            } 
            $movement = $this->movementRepository->getMovement($movementId);
            if($movement){
                $list = [
                    'movement' => $movement->name,
                    'ranking' => $list
                ];
            } else {
                throw new Exception('movimento não encontrado',400);
            }
            if(env('APP_ENV') != 'testing'){
                Redis::set('ranking_movement:'.$movementId, json_encode($list),'EX',60);
            }
        }
       
        return (array) $list;
    }

    private function definesRanking(array $ranking): array 
    {
        $position = 1;
        foreach($ranking as $key => $personalRanking){
            if(isset($ranking[$key-1]) && $personalRanking->record != $ranking[$key-1]->record ){
                $position++;
            } 
            $ranking[$key]->position = $position;
        }
        return $ranking;
    }

}
