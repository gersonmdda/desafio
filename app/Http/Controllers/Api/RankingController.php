<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use \Throwable;

use App\Service\RankingService;

class RankingController extends BaseController
{
    private RankingService $rankingService;

    function __construct(RankingService $rankingService) 
    {
        $this->rankingService = $rankingService;
    }

    public function index(Request $request): JsonResponse
    {
        try{
            return response()->json([
                'status' => true,
                'response'=> $this->rankingService->getRanking($request->get('movement'))
            ],200);
        } catch(Throwable $e){
            $error_code = $e->getCode() ? $e->getCode() : 500;
            return response()->json([
                'status' => false,
                'error'=> $e->getMessage()
            ],$error_code);
        }
    }

}
