<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    function index(): View
    {
        $params = Parameter::all();

        return view('index', [
            'images' => $params,
        ]);
    }
}
