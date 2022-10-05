<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

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
        return response()->json([
            'status' => true,
            'response'=> $this->rankingService->getRanking($request->get('movement'))
        ],200);
    }

}
