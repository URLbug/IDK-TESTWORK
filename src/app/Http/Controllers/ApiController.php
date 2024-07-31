<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function index(): JsonResponse
    {
        $params = Parameter::all([
            'id', 
            'title', 
            'type',
        ]);

    
        $params = $params->map(function($image){
            $getDomain = substr(
                url()->current(), 
                0, 
                strpos(url()->current(), '/api')
            );

            return [
                'id' => $image->id,
                'title' => [
                    'image' => $getDomain . '/images/' . $image->title['image'],
                    'images_gray' => isset($image->title['image_gray']) ? $getDomain . '/images/' . $image->title['image_gray'] : null,
                ],
                'type' => $image->type,
            ];
        });

        return response()->json($params);
    }
}
