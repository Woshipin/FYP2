<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    protected $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function getRecommendations(Request $request)
    {
        $userId = $request->user()->id;

        $recommendations = $this->recommendationService->getRecommendations($userId);

        // 返回推荐数据而不是视图响应
        return $recommendations;
    }
}
