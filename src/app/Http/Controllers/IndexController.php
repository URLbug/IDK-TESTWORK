<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    function index(Request $request): View|RedirectResponse
    {
        if($request->method() === 'POST')
        {
            $data = $request->validate([
                'search' => 'required',
            ]);

            $data = $data['search'];

            if(is_numeric($data))
            {
                $params = Parameter::query()
                ->where('id', (int)$data)
                ->first();
            }
            else
            {
                $params = Parameter::query()
                ->where('title->image', 'like', $data . '%', 'or')
                ->where('title->image_gray', 'like', $data . '%')
                ->first();
            }

            return back()->with('images', [$params, ]);
        }

        $params = Parameter::all();

        $session = session()->get('images');

        return view('index', [
            'images' => isset($session) ? $session : $params,
        ]);
    }
}
