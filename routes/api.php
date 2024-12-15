<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpInsight\PhpInsight;
use Illuminate\Support\Facades\Log;
use App\Models\Resort;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/analyze-query', function (Request $request) {
    try {
        $query = $request->input('query');

        // 使用 PHP Insight 库进行自然语言处理
        $nlp = new PhpInsight();
        $doc = $nlp->load($query);
        $keywords = $doc->entities()->map(function($entity) {
            return $entity->text();
        })->toArray();

        $resorts = \App\Models\Resort::where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('type', 'like', '%' . $keyword . '%')
                    ->orWhere('country', 'like', '%' . $keyword . '%')
                    ->orWhere('state', 'like', '%' . $keyword . '%')
                    ->orWhere('location', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            }
        })->get();

        return response()->json($resorts);
    } catch (\Exception $e) {
        Log::error('Error in analyze-query: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while processing your request.'], 500);
    }
});

