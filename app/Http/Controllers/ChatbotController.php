<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Resort;
use App\Models\Hotel;
use App\Models\Restaurant;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Gemini\Laravel\Facades\Gemini;
use PhpInsight\PhpInsight;

class ChatBotController extends Controller
{

    // public function analyzeQuery(Request $request)
    // {
    //     try {
    //         $query = $request->input('query');

    //         // 使用 PHP Insight 库进行自然语言处理
    //         $nlp = new PhpInsight();
    //         $doc = $nlp->load($query);
    //         $keywords = $doc->entities()->map(function($entity) {
    //             return $entity->text();
    //         })->toArray();

    //         $resorts = Resort::where(function ($query) use ($keywords) {
    //             foreach ($keywords as $keyword) {
    //                 $query->orWhere('name', 'like', '%' . $keyword . '%')
    //                     ->orWhere('type', 'like', '%' . $keyword . '%')
    //                     ->orWhere('country', 'like', '%' . $keyword . '%')
    //                     ->orWhere('state', 'like', '%' . $keyword . '%')
    //                     ->orWhere('location', 'like', '%' . $keyword . '%')
    //                     ->orWhere('description', 'like', '%' . $keyword . '%');
    //             }
    //         })->get();

    //         return response()->json($resorts);
    //     } catch (\Exception $e) {
    //         Log::error('Error in analyze-query: ' . $e->getMessage());
    //         return response()->json(['error' => 'An error occurred while processing your request.'], 500);
    //     }
    // }

    public function AISearch(Request $request)
    {
        $query = $request->input('query');

        // 搜索度假村、酒店和餐厅
        $resorts = Resort::where('name', 'like', "%$query%")
                         ->orWhere('location', 'like', "%$query%")
                         ->get();

        $hotels = Hotel::where('name', 'like', "%$query%")
                       ->orWhere('location', 'like', "%$query%")
                       ->get();

        $restaurants = Restaurant::where('name', 'like', "%$query%")
                                 ->orWhere('location', 'like', "%$query%")
                                 ->get();

        return response()->json([
            'resorts' => $resorts,
            'hotels' => $hotels,
            'restaurants' => $restaurants,
        ]);
    }

    // public function chat(Request $request)
    // {
    //     $message = $request->input('message');
    //     $response = $this->handleMessage($message);
    //     return response()->json(['response' => $response]);
    // }

    // private function handleMessage($message)
    // {
    //     // 简单示例：根据用户输入的关键词查询数据库
    //     if (strpos($message, 'resort') !== false) {
    //         return $this->searchResorts($message);
    //     } elseif (strpos($message, 'hotel') !== false) {
    //         return $this->searchHotels($message);
    //     } elseif (strpos($message, 'restaurant') !== false) {
    //         return $this->searchRestaurants($message);
    //     } else {
    //         return '抱歉,我无法理解您的请求。请尝试询问关于resort, hotel或restaurant的信息。';
    //     }
    // }

    // public function chat(Request $request)
    // {
    //     $message = $request->input('message');

    //     // 使用 Gemini API 获取响应
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . env('GEMINI_API_KEY'),
    //     ])->post('https://api.gemini.com/v1/chat', [
    //         'message' => $message,
    //     ]);

    //     // 检查是否请求成功
    //     if ($response->failed()) {
    //         \Log::error('Gemini API request failed: ' . $response->body());
    //         return response()->json([
    //             'error' => 'Failed to get response from Gemini API',
    //             'response' => $response->body(), // 打印出响应内容进行调试
    //         ], 500);
    //     }

    //     // 返回API的响应
    //     return response()->json([
    //         'response' => $response->json(),
    //     ]);
    // }

    public function chat(Request $request)
    {
        // Get the message from the request
        $message = $request->input('message');

        // API setup
        $API_KEY = env('GEMINI_API_KEY');
        $API_URL = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$API_KEY}";

        // Prepare the request payload for Gemini API
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $message]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 100,
                'topP' => 1,
                'topK' => 1
            ]
        ];

        // Log the request details for debugging
        Log::info('Sending request to Gemini API', [
            'url' => $API_URL,
            'payload' => $payload,
        ]);

        // Use Gemini API to get a response
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($API_URL, $payload);

        // Check if the request was successful
        if ($response->failed()) {
            // Log the error response for debugging
            Log::error('Gemini API request failed:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'error' => 'Failed to get response from Gemini API',
                'details' => $response->json(),
            ], 500);
        }

        // Extract the text response from the Gemini API response
        $responseData = $response->json();
        $textResponse = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'No response text found';

        // Return the API's response
        return response()->json([
            'response' => $textResponse,
        ]);
    }

    // Processing API KEY
    // function getOAuthClient() {
    //     $oauth2 = new OAuth2([
    //         'clientId' => env('GOOGLE_CLIENT_ID'),
    //         'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
    //         'refreshToken' => env('GOOGLE_REFRESH_TOKEN'),
    //         'scope' => ['https://www.googleapis.com/auth/cloud-platform'],
    //     ]);

    //     $stack = HandlerStack::create();
    //     $stack->push(new AuthTokenMiddleware($oauth2));

    //     return new Client(['handler' => $stack]);
    // }

    // public function chat(Request $request)
    // {
    //     $message = $request->input('message');

    //     try {
    //         Log::info("Attempting to send message to Gemini API: " . $message);

    //         $client = new Client();
    //         $response = $client->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent', [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . env('GEMINI_API_KEY'),
    //                 'Content-Type' => 'application/json',
    //             ],
    //             'json' => [
    //                 'contents' => [
    //                     ['parts' => [['text' => $message]]],
    //                 ],
    //             ],
    //             'http_errors' => false,
    //         ]);

    //         $statusCode = $response->getStatusCode();
    //         $responseBody = $response->getBody()->getContents();

    //         Log::info("Gemini API Response - Status: $statusCode, Body: $responseBody");

    //         if ($statusCode !== 200) {
    //             throw new \Exception("Gemini API Error - Status: $statusCode, Response: $responseBody");
    //         }

    //         $responseData = json_decode($responseBody, true);
    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             throw new \Exception('JSON Decode Error: ' . json_last_error_msg());
    //         }

    //         $reply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, no valid response from Gemini API.';
    //         return response()->json(['response' => $reply]);

    //     } catch (\Exception $e) {
    //         Log::error('Chat Exception: ' . $e->getMessage());
    //         Log::error('Stack trace: ' . $e->getTraceAsString());
    //         return response()->json([
    //             'response' => 'Error: Server encountered an issue.',
    //             'details' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // -------------------------------------------------------------Resort-------------------------------------------------------------
    // Original Code
    // private function searchResorts($message)
    // {
    //     // 从message中提取条件并查询数据库
    //     $query = Resort::query();

    //     // 调试输出原始消息
    //     \Log::info('Original message: ' . $message);

    //     // 清理消息中的标点符号和多余空格
    //     $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
    //     $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
    //     $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

    //     // 提取state条件（支持多个state）
    //     if (preg_match_all('/state\s*(在|in)\s*(.+?)(?=\b(?:price|country|type|$))/ui', $cleanMessage, $matches)) {
    //         $states = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个state
    //         $states = array_filter($states); // 移除空值
    //         $query->whereIn('state', $states);
    //     }

    //     // 提取price条件（支持单个价格或价格范围）
    //     if (preg_match('/price\s*(在|in)\s*(\d+)(到|-)(\d+)/u', $cleanMessage, $matches)) {
    //         $query->whereBetween('price', [$matches[2], $matches[4]]);
    //     } elseif (preg_match('/price\s*(在|in)\s*(\d+)/u', $cleanMessage, $matches)) {
    //         $query->where('price', $matches[2]);
    //     }

    //     // 提取type条件（支持多个type）
    //     if (preg_match_all('/(big|small|large)\s*resort/ui', $cleanMessage, $matches)) {
    //         $types = array_map(function($type) {
    //             return ucfirst(trim($type)) . ' Resort';
    //         }, $matches[1]); // 格式化类型
    //         $query->whereIn('type', $types);
    //     }

    //     // 提取country条件（支持多个country）
    //     if (preg_match_all('/country\s*(在|in)\s*(.+?)(?=\b(?:state|price|type|$))/ui', $cleanMessage, $matches)) {
    //         $countries = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个country
    //         $countries = array_filter($countries); // 移除空值
    //         $query->whereIn('country', $countries);
    //     }

    //     $resorts = $query->get();
    //     if ($resorts->isEmpty()) {
    //         return '未找到符合条件的度假村。';
    //     }

    //     // Initialize an empty string to store the formatted output
    //     $formattedOutput = '';

    //     // Iterate through each resort
    //     foreach ($resorts as $resort) {
    //         // Append the resort information to the formatted output
    //         $formattedOutput .= sprintf(
    //             "Resort Name: %s\nResort State: %s\nResort Price: %.2f\nResort Country: %s\nResort Type: %s\n",
    //             $resort->name,
    //             $resort->state,
    //             $resort->price,
    //             $resort->country,
    //             $resort->type
    //         );

    //         // Add a separator line after each resort
    //         $formattedOutput .= str_repeat('-', 100) . "\n\n"; // Add an extra newline
    //     }

    //     // Remove the trailing separator line
    //     $formattedOutput = rtrim($formattedOutput, "\n\n"); // Remove extra newline

    //     return $formattedOutput;

    //     // return $resorts->map(function($resort) {
    //     //     return sprintf(
    //     //         "Resort Name: %s\nResort State: %s\nResort Price: %s\nResort Country: %s\nResort Type: %s",
    //     //         $resort->name,
    //     //         $resort->state,
    //     //         $resort->price,
    //     //         $resort->country,
    //     //         $resort->type
    //     //     );
    //     // })->implode("\n");
    // }

    // Final Correct Resort Code
    // private function searchResorts($message)
    // {
    //     // 从message中提取条件并查询数据库
    //     $query = Resort::query();

    //     // 调试输出原始消息
    //     \Log::info('Original message: ' . $message);

    //     // 清理消息中的标点符号和多余空格
    //     $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
    //     $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
    //     $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

    //     // 提取关键词
    //     $keywords = explode(' ', $cleanMessage);

    //     // 初始化查询条件
    //     $query->where(function ($query) use ($keywords) {
    //         foreach ($keywords as $keyword) {
    //             $query->orWhere('name', 'like', "%{$keyword}%")
    //                 ->orWhere('type', 'like', "%{$keyword}%")
    //                 ->orWhere('state', 'like', "%{$keyword}%")
    //                 ->orWhere('country', 'like', "%{$keyword}%");
    //         }
    //     });

    //     // 提取 state 条件
    //     if (preg_match_all('/state\s*(在|in)\s*(.+?)(?=\b(?:price|country|type|$))/ui', $cleanMessage, $matches)) {
    //         $states = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 state
    //         $states = array_filter($states); // 移除空值
    //         $query->whereIn('state', $states);
    //     }

    //     // 提取 price 条件
    //     if (preg_match('/price\s*(在|in)\s*(\d+)(到|-)(\d+)/u', $cleanMessage, $matches)) {
    //         $query->whereBetween('price', [$matches[2], $matches[4]]);
    //     } elseif (preg_match('/price\s*(在|in)\s*(\d+)/u', $cleanMessage, $matches)) {
    //         $query->where('price', $matches[2]);
    //     }

    //     // 提取 type 条件
    //     if (preg_match_all('/(big|small|large)\s*resort/ui', $cleanMessage, $matches)) {
    //         $types = array_map(function ($type) {
    //             return ucfirst(trim($type)) . ' Resort';
    //         }, $matches[1]); // 格式化类型
    //         $query->whereIn('type', $types);
    //     }

    //     // 提取 country 条件
    //     if (preg_match_all('/country\s*(在|in)\s*(.+?)(?=\b(?:state|price|type|$))/ui', $cleanMessage, $matches)) {
    //         $countries = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 country
    //         $countries = array_filter($countries); // 移除空值
    //         $query->whereIn('country', $countries);
    //     }

    //     // 执行查询
    //     $resorts = $query->get();

    //     if ($resorts->isEmpty()) {
    //         return '未找到符合条件的度假村。';
    //     }

    //     // Initialize an empty string to store the formatted output
    //     $formattedOutput = '';

    //     // Iterate through each resort
    //     foreach ($resorts as $resort) {
    //         // Append the resort information to the formatted output
    //         $formattedOutput .= sprintf(
    //             "Resort Name: %s\nResort State: %s\nResort Price: %.2f\nResort Country: %s\nResort Type: %s\n",
    //             $resort->name,
    //             $resort->state,
    //             $resort->price,
    //             $resort->country,
    //             $resort->type
    //         );

    //         // Add a separator line after each resort
    //         $formattedOutput .= str_repeat('-', 100) . "\n\n"; // Add an extra newline
    //     }

    //     // Remove the trailing separator line
    //     $formattedOutput = rtrim($formattedOutput, "\n\n"); // Remove extra newline

    //     return $formattedOutput;
    // }

    private function searchResorts($message)
    {
        // 从message中提取条件并查询数据库
        $query = Resort::query();

        // 调试输出原始消息
        \Log::info('Original message: ' . $message);

        // 清理消息中的标点符号和多余空格
        $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
        $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
        $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

        // 提取关键词
        $keywords = explode(' ', $cleanMessage);

        // 初始化查询条件
        $query->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('name', 'like', "%{$keyword}%")
                    ->orWhere('type', 'like', "%{$keyword}%")
                    ->orWhere('state', 'like', "%{$keyword}%")
                    ->orWhere('country', 'like', "%{$keyword}%");
            }
        });

        // 提取 state 条件
        if (preg_match_all('/state\s*(在|in)\s*(.+?)(?=\b(?:price|country|type|$))/ui', $cleanMessage, $matches)) {
            $states = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 state
            $states = array_filter($states); // 移除空值
            $query->whereIn('state', $states);
        }

        // 提取 price 条件
        if (preg_match('/price\s*(在|in)\s*(\d+)(到|-)(\d+)/u', $cleanMessage, $matches)) {
            $query->whereBetween('price', [$matches[2], $matches[4]]);
        } elseif (preg_match('/price\s*(在|in)\s*(\d+)/u', $cleanMessage, $matches)) {
            $query->where('price', $matches[2]);
        }

        // 提取 type 条件
        if (preg_match_all('/(big|small|large)\s*resort/ui', $cleanMessage, $matches)) {
            $types = array_map(function ($type) {
                return ucfirst(trim($type)) . ' Resort';
            }, $matches[1]); // 格式化类型
            $query->whereIn('type', $types);
        }

        // 提取 country 条件
        if (preg_match_all('/country\s*(在|in)\s*(.+?)(?=\b(?:state|price|type|$))/ui', $cleanMessage, $matches)) {
            $countries = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 country
            $countries = array_filter($countries); // 移除空值
            $query->whereIn('country', $countries);
        }

        // 执行查询
        $resorts = $query->get();

        if ($resorts->isEmpty()) {
            return '未找到符合条件的度假村。';
        }

        // Initialize an empty string to store the formatted output
        $formattedOutput = '';

        // Iterate through each resort
        foreach ($resorts as $resort) {
            // Append the resort information to the formatted output
            $formattedOutput .= sprintf(
                "Resort Name: %s\n-Resort State: %s\n-Resort Price: %.2f\n-Resort Country: %s\n-Resort Type: %s\n",
                $resort->name,
                $resort->state,
                $resort->price,
                $resort->country,
                $resort->type
            );

            // Add a separator line after each resort
            $formattedOutput .= str_repeat('-',50) . "\n\n"; // Add an extra newline
        }

        // Remove the trailing separator line
        $formattedOutput = rtrim($formattedOutput, "\n\n"); // Remove extra newline

        return $formattedOutput;
    }

    // -------------------------------------------------------------Hotel-------------------------------------------------------------
    // Original Code
    // private function searchHotels($message)
    // {
    //     // 从message中提取条件并查询数据库
    //     $query = Hotel::query();

    //     // 调试输出原始消息
    //     \Log::info('Original message: ' . $message);

    //     // 清理消息中的标点符号和多余空格
    //     $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
    //     $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
    //     $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

    //     // 提取state条件（支持多个state）
    //     if (preg_match_all('/state\s*(在|in)\s*(.+?)(?=\b(?:type|country|$))/ui', $cleanMessage, $matches)) {
    //         $states = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个state
    //         $states = array_filter($states); // 移除空值
    //         $query->whereIn('state', $states);
    //     }

    //     // 提取type条件（支持多个type和范围）
    //     if (preg_match_all('/(\d+(\s*-\s*\d+)?\s*star\s*hotel)/ui', $cleanMessage, $matches)) {
    //         $types = array_map(function($type) {
    //             return trim(str_replace(['star', 'hotel'], '', $type)); // 移除 'star' 和 'hotel' 并修剪空格
    //         }, $matches[1]); // 格式化类型

    //         // 处理类型范围
    //         $exactTypes = [];
    //         foreach ($types as $type) {
    //             if (strpos($type, '-') !== false) {
    //                 // 范围类型，解析范围并生成范围内的类型
    //                 list($start, $end) = explode('-', $type);
    //                 for ($i = (int)$start; $i <= (int)$end; $i++) {
    //                     $exactTypes[] = $i . ' star hotel';
    //                 }
    //             } else {
    //                 $exactTypes[] = $type . ' star hotel';
    //             }
    //         }
    //         $query->whereIn('type', $exactTypes);
    //     }

    //     // 提取country条件（支持多个country）
    //     if (preg_match_all('/country\s*(在|in)\s*(.+?)(?=\b(?:state|type|$))/ui', $cleanMessage, $matches)) {
    //         $countries = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个country
    //         $countries = array_filter($countries); // 移除空值
    //         $query->whereIn('country', $countries);
    //     }

    //     $hotels = $query->get();
    //     if ($hotels->isEmpty()) {
    //         return '未找到符合条件的酒店。';
    //     }

    //     // 结果格式化
    //     return $hotels->map(function($hotel) {
    //         return "{$hotel->name} - {$hotel->state} - {$hotel->type} - {$hotel->country}";
    //     })->implode("\n");
    // }

    // Final Correct Resort Code
    private function searchHotels($message)
    {
        // 从message中提取条件并查询数据库
        $query = Hotel::query();

        // 调试输出原始消息
        \Log::info('Original message: ' . $message);

        // 清理消息中的标点符号和多余空格
        $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
        $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
        $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

        // 提取关键词
        $keywords = explode(' ', $cleanMessage);

        // 初始化查询条件
        $query->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('name', 'like', "%{$keyword}%")
                    ->orWhere('type', 'like', "%{$keyword}%")
                    ->orWhere('state', 'like', "%{$keyword}%")
                    ->orWhere('country', 'like', "%{$keyword}%");
            }
        });

        // 提取 state 条件
        if (preg_match_all('/state\s*(在|in)\s*(.+?)(?=\b(?:type|country|$))/ui', $cleanMessage, $matches)) {
            $states = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 state
            $states = array_filter($states); // 移除空值
            $query->whereIn('state', $states);
        }

        // 提取 type 条件
        if (preg_match_all('/(\d+(\s*-\s*\d+)?\s*star\s*hotel)/ui', $cleanMessage, $matches)) {
            $types = array_map(function ($type) {
                return trim(str_replace(['star', 'hotel'], '', $type)); // 移除 'star' 和 'hotel' 并修剪空格
            }, $matches[1]); // 格式化类型

            // 处理类型范围
            $exactTypes = [];
            foreach ($types as $type) {
                if (strpos($type, '-') !== false) {
                    // 范围类型，解析范围并生成范围内的类型
                    list($start, $end) = explode('-', $type);
                    for ($i = (int) $start; $i <= (int) $end; $i++) {
                        $exactTypes[] = $i . ' star hotel';
                    }
                } else {
                    $exactTypes[] = $type . ' star hotel';
                }
            }
            $query->whereIn('type', $exactTypes);
        }

        // 提取 country 条件
        if (preg_match_all('/country\s*(在|in)\s*(.+?)(?=\b(?:state|type|$))/ui', $cleanMessage, $matches)) {
            $countries = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 country
            $countries = array_filter($countries); // 移除空值
            $query->whereIn('country', $countries);
        }

        // 执行查询
        $hotels = $query->get();

        if ($hotels->isEmpty()) {
            return '未找到符合条件的酒店。';
        }

        // 结果格式化
        $response = "以下是符合条件的酒店：\n";
        foreach ($hotels as $hotel) {
            $response .= sprintf(
                "-Hotel Name: %s\n-Hotel State: %s\n-Hotel Type: %s\n-Hotel Country: %s\n--------------------------------------------------\n",
                $hotel->name,
                $hotel->state,
                $hotel->type,
                $hotel->country
            );
        }

        return $response;


        // // 结果格式化
        // $response = "以下是符合条件的酒店：\n";
        // foreach ($hotels as $hotel) {
        //     $response .= "{$hotel->name} - {$hotel->state} - {$hotel->type} - {$hotel->country}\n";
        // }

        // return $response;
    }

    // -------------------------------------------------------------Restaurant-------------------------------------------------------------
    // Original Code
    // private function searchRestaurants($message)
    // {
    //     // 从message中提取条件并查询数据库
    //     $query = Restaurant::query();

    //     // 调试输出原始消息
    //     \Log::info('Original message: ' . $message);

    //     // 清理消息中的标点符号和多余空格
    //     $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
    //     $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
    //     $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

    //     // 提取关键词
    //     $keywords = explode(' ', $cleanMessage);

    //     // 初始化查询条件
    //     $query->where(function ($query) use ($keywords) {
    //         foreach ($keywords as $keyword) {
    //             $query->orWhere('name', 'like', "%{$keyword}%")
    //                 ->orWhere('type', 'like', "%{$keyword}%")
    //                 ->orWhere('state', 'like', "%{$keyword}%")
    //                 ->orWhere('country', 'like', "%{$keyword}%");
    //         }
    //     });

    //     // 执行查询
    //     $restaurants = $query->get();

    //     if ($restaurants->isEmpty()) {
    //         return '未找到符合条件的餐厅。';
    //     }

    //     // 结果格式化
    //     $response = "以下是符合条件的餐厅：\n";
    //     foreach ($restaurants as $restaurant) {
    //         $response .= "{$restaurant->name} - {$restaurant->state} - {$restaurant->type} - {$restaurant->country}\n";
    //     }

    //     return $response;
    // }

    // Final Correct Resort Code
    // private function searchRestaurants($message)
    // {
    //     // 从message中提取条件并查询数据库
    //     $query = Restaurant::query();

    //     // 调试输出原始消息
    //     \Log::info('Original message: ' . $message);

    //     // 清理消息中的标点符号和多余空格
    //     $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
    //     $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
    //     $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

    //     // 提取关键词
    //     $keywords = explode(' ', $cleanMessage);

    //     // 初始化查询条件
    //     $query->where(function ($query) use ($keywords) {
    //         foreach ($keywords as $keyword) {
    //             $query->orWhere('name', 'like', "%{$keyword}%")
    //                 ->orWhere('type', 'like', "%{$keyword}%")
    //                 ->orWhere('state', 'like', "%{$keyword}%")
    //                 ->orWhere('country', 'like', "%{$keyword}%");
    //         }
    //     });

    //     // 提取 state 条件
    //     if (preg_match_all('/state\s*(在|in)\s*(.+?)(?=\b(?:country|$))/ui', $cleanMessage, $matches)) {
    //         $states = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 state
    //         $states = array_filter($states); // 移除空值
    //         $query->whereIn('state', $states);
    //     }

    //     // 提取 country 条件
    //     if (preg_match_all('/country\s*(在|in)\s*(.+?)(?=\b(?:state|$))/ui', $cleanMessage, $matches)) {
    //         $countries = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 country
    //         $countries = array_filter($countries); // 移除空值
    //         $query->whereIn('country', $countries);
    //     }

    //     // 执行查询
    //     $restaurants = $query->get();

    //     if ($restaurants->isEmpty()) {
    //         return '未找到符合条件的餐厅。';
    //     }

    //     // 结果格式化
    //     $response = "以下是符合条件的餐厅：\n";
    //     foreach ($restaurants as $restaurant) {
    //         $response .= sprintf(
    //             "-Restaurant Name: %s\n-Restaurant State: %s\n-Restaurant Type: %s\n-Restaurant Country: %s\n--------------------------------------------------\n",
    //             $restaurant->name,
    //             $restaurant->state,
    //             $restaurant->type,
    //             $restaurant->country
    //         );
    //     }

    //     return $response;


    //     // // 结果格式化
    //     // $response = "以下是符合条件的餐厅：\n";
    //     // foreach ($restaurants as $restaurant) {
    //     //     $response .= "{$restaurant->name} - {$restaurant->state} - {$restaurant->type} - {$restaurant->country}\n";
    //     // }

    //     // return $response;
    // }

    // private function searchRestaurants($message)
    // {
    //     // 从message中提取条件并查询数据库
    //     $query = Restaurant::query();

    //     // 调试输出原始消息
    //     \Log::info('Original message: ' . $message);

    //     // 清理消息中的标点符号和多余空格
    //     $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
    //     $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
    //     $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

    //     // 如果消息中包含 "Restaurant Type"，但没有指定具体的餐厅类型，则显示所有存在的餐厅类型
    //     if (preg_match('/\btype\b/ui', $cleanMessage) && !preg_match('/\btype\b/ui', $cleanMessage)) {
    //         $existingTypes = Restaurant::distinct()->pluck('type')->toArray();
    //         if (empty($existingTypes)) {
    //             return '未找到符合条件的餐厅类型。';
    //         } else {
    //             $response = "以下是所有存在的餐厅类型：\n";
    //             foreach ($existingTypes as $type) {
    //                 $response .= "- {$type}\n";
    //             }
    //             return $response;
    //         }
    //     }


    //     // 提取关键词
    //     $keywords = explode(' ', $cleanMessage);

    //     // 初始化查询条件
    //     $query->where(function ($query) use ($keywords) {
    //         foreach ($keywords as $keyword) {
    //             $query->orWhere('name', 'like', "%{$keyword}%")
    //                 ->orWhere('state', 'like', "%{$keyword}%")
    //                 ->orWhere('country', 'like', "%{$keyword}%");
    //         }
    //     });

    //     // 提取 state 条件
    //     if (preg_match_all('/state\s*(在|in)\s*(.+?)(?=\b(?:country|$))/ui', $cleanMessage, $matches)) {
    //         $states = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 state
    //         $states = array_filter($states); // 移除空值
    //         $query->whereIn('state', $states);
    //     }

    //     // 提取 country 条件
    //     if (preg_match_all('/country\s*(在|in)\s*(.+?)(?=\b(?:state|$))/ui', $cleanMessage, $matches)) {
    //         $countries = preg_split('/\s*(和|and|,)\s*/u', $matches[2][0]); // 分割多个 country
    //         $countries = array_filter($countries); // 移除空值
    //         $query->whereIn('country', $countries);
    //     }

    //     // 提取 restaurant type 条件
    //     if (preg_match('/type\s*(是|为|为了)?\s*(\w+)/ui', $cleanMessage, $matches)) {
    //         $query->where('type', 'like', "%{$matches[2]}%");
    //     }

    //     // 执行查询
    //     $restaurants = $query->get();

    //     if ($restaurants->isEmpty()) {
    //         return '未找到符合条件的餐厅。';
    //     }

    //     // 结果格式化
    //     $response = "以下是符合条件的餐厅：\n";
    //     foreach ($restaurants as $restaurant) {
    //         $response .= "- Restaurant Name: {$restaurant->name}\n";
    //         $response .= "- Restaurant State: {$restaurant->state}\n";
    //         $response .= "- Restaurant Type: {$restaurant->type}\n";
    //         $response .= "- Restaurant Country: {$restaurant->country}\n";
    //         $response .= "--------------------------------------------------\n";
    //     }

    //     return $response;
    // }

    private function searchRestaurants($message)
    {
        // 从message中提取条件并查询数据库
        $query = Restaurant::query();

        // 调试输出原始消息
        \Log::info('Original message: ' . $message);

        // 清理消息中的标点符号和多余空格
        $cleanMessage = preg_replace('/[,.。、]/u', '', $message); // 移除标点符号
        $cleanMessage = preg_replace('/\s+/u', ' ', $cleanMessage); // 合并多余空格
        $cleanMessage = mb_strtolower($cleanMessage, 'UTF-8'); // 转换为小写

        // 提取关键词
        $keywords = explode(' ', $cleanMessage);

        // 初始化查询条件
        $query->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('name', 'like', "%{$keyword}%")
                    ->orWhere('type', 'like', "%{$keyword}%")
                    ->orWhere('state', 'like', "%{$keyword}%")
                    ->orWhere('country', 'like', "%{$keyword}%");
            }
        });

        // 提取 state 条件
        if (preg_match_all('/\bstate\s*(?:在|in)\s*([^,]+)/ui', $cleanMessage, $matches)) {
            $states = array_map('trim', $matches[1]); // 提取匹配到的 state
            $query->whereIn('state', $states);
        }

        // 提取 country 条件
        if (preg_match_all('/\bcountry\s*(?:在|in)\s*([^,]+)/ui', $cleanMessage, $matches)) {
            $countries = array_map('trim', $matches[1]); // 提取匹配到的 country
            $query->whereIn('country', $countries);
        }

        // 提取 type 条件
        if (preg_match('/\brestaurant\s+type\b/ui', $cleanMessage)) {
            $restaurantTypes = Restaurant::distinct()->pluck('type')->toArray();
            if (empty($restaurantTypes)) {
                return '未找到符合条件的餐厅类型。';
            } else {
                $response = "以下是所有存在的餐厅类型：\n";
                foreach ($restaurantTypes as $type) {
                    $response .= "- {$type}\n";
                }
                return $response;
            }
        }

        // 执行查询
        $restaurants = $query->get();

        if ($restaurants->isEmpty()) {
            return '未找到符合条件的餐厅。';
        }

        // 结果格式化
        $response = "以下是符合条件的餐厅：\n";
        foreach ($restaurants as $restaurant) {
            $response .= sprintf(
                "-Restaurant Name: %s\n-Restaurant State: %s\n-Restaurant Type: %s\n-Restaurant Country: %s\n--------------------------------------------------\n",
                $restaurant->name,
                $restaurant->state,
                $restaurant->type,
                $restaurant->country
            );
        }

        return $response;
    }

}
