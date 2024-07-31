<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
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

            $images = $this->saveImage($request);

            $isLoad = $this->saveData($images);
            
            if(!$isLoad)
            {
                return back()->withErrors('Ошибка: изображение не было загружено!');
            }

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

    private function saveImage(Request $request): array
    {
        $image = $request->file('image');
        $image_gray = $request->file('image-gray');

        $name_image = $this->normalizeImage(
            $image->getClientOriginalName(), 
            $image->getClientOriginalExtension(),
        );

        $image->move(public_path() . '/images/', $name_image);

        if(isset($image_gray))
        {
            $name_image_gray = $this->normalizeImage(
                $image_gray->getClientOriginalName(), 
                $image_gray->getClientOriginalExtension(),
            );

            $image_gray->move(public_path() . '/images/', $name_image_gray);

            return [
                'image' => $name_image,
                'image_gray' => $name_image_gray,
            ];
        }

        return [
            'image' => $name_image,
        ];
    }

    private function saveData(array $images): bool
    {
        $isLoad = [];

        foreach($images as $key => $image)
        {
            $isLoad[] = Parameter::insert([
                'title' => $image,
                'type' => count($images),
            ]);
        }

        return (bool)array_product($isLoad);
    }
}
