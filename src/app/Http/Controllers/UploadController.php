<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    function index(Request $request): View|RedirectResponse
    {
        if($request->method() === 'POST')
        {
            if($this->isImage($request))
            {
                return back()->withErrors('Ошибка: изображение не было загружено!');
            }

            $this->saveImage($request);

            return back()
            ->with('success', 'Изображение успешно загружена');
        }

        return view('upload');
    }

    private function isImage(Request $request): bool
    {
        $validator = Validator::make(
        $request->only(['image', 'image-gray',]),
        [
            'image' => 'image|mimes:jpeg,jpg,png|required|max:10000',
            'image-gray' => 'image|mimes:jpeg,jpg,png|max:10000',
        ]);

        return $validator->fails();
    }

    private function normalizeImage(string $name, string $extension): string
    {
        $name = pathinfo($name, PATHINFO_FILENAME) . '-' . now() . '-' . random_int(10000, 99999);

        return str_slug($name) . '.' . $extension;
    }

    private function saveImage(Request $request)
    {
        $image = $request->file('image');
        $image_gray = $request->file('image-gray');

        $name = $this->normalizeImage(
            $image->getClientOriginalName(), 
            $image->getClientOriginalExtension(),
        );

        $image->move(public_path() . '/images/', $name);

        if(isset($image_gray))
        {
            $name = $this->normalizeImage(
                $image_gray->getClientOriginalName(), 
                $image_gray->getClientOriginalExtension(),
            );

            $image_gray->move(public_path() . '/images/', $name);
        }
    }
}
