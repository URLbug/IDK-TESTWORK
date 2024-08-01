<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IndexController extends UploadController
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
                ->where('title->image', 'like', $data . '%')
                ->orWhere('title->image_gray', 'like', $data . '%')
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

    function delete(Request $request): RedirectResponse
    {
        if(!$this->isImage($request))
        {
            return back()
            ->withErrors('Ошибка: Не удалось удалить изображение');
        }

        return back()
        ->with('success', 'Изображение успешно обновлено');   
    }

    function update(Request $request): RedirectResponse
    {
        if(!$this->isImage($request))
        {
            return back()
            ->withErrors('Ошибка: Не удалось обновить изображение');
        }

        if(!$this->deleteImage($request))
        {
            return back()
            ->withErrors('Ошибка: Не удалось обновить изображение');
        }

        $data = $this->updatePicture($request);

        if(!isset($data['image']))
        {
            return back()
            ->withErrors('Ошибка: Не удалось обновить изображение');
        }

        if(!$this->updateData($data['image'], $data['last_name']))
        {
            dd($data);
            return back()
            ->withErrors('Ошибка: Не удалось обновить изображение');
        }

        return back()
        ->with('success', 'Изображение успешно обновлено');
    }

    protected function updatePicture(Request $request): array
    {
        if(!$this->deleteImage($request))
        {
            return ['image' => null,];
        }

        $image = $request->file('image');

        $name = $this->normalizeImage(
            $image->getClientOriginalName(), 
            $image->getClientOriginalExtension(),
        );

        $image->move(public_path() . '/images/', $name);

        return [
            'image' => $name,
            'last_name' => $request->only('image-gray')['image-gray'],
        ];
    }

    protected function deleteImage(Request $request): bool
    {
        $image_gray = public_path($request->only('image-gray')['image-gray']);

        if(File::exists($image_gray))
        {
            return File::delete($image_gray);;
        }

        return false;
    }

    protected function updateData(string $image, string $last_name)
    {
        $params = Parameter::where('title->image', $last_name);

        return $params->update([
            'title->image' => $image,
        ]);
    }
}
