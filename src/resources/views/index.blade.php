@extends('app')

@section('content')
    <form action="{{ route('home') }}" method="POST">
        @csrf

        <input type="text" name="search" id="search" class="search" placeholder="Поиск">
        <input type="submit" value="Поиск">
    </form>
    <br>
    
    @if(isset($images) && $images !== [null])
        @foreach ($images as $image)
            @if($image->type == 2)
                <img src="{{ '/images/' . $image->title['image_gray'] }}">
                <p>title: {{ $image->title['image_gray'] }} || id: {{ $image->id }} || type: {{ $image->type }}</p>

                <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="image-gray" value="{{ '/images/' . $image->title['image'] }}">
                    <input name="image" id="images" type="file" accept="image/png, image/jpeg">
                    <input type="submit" value="Обновить">
                </form>
            @endif

            <img src="{{ '/images/' . $image->title['image'] }}">

            <p>title: {{ $image->title['image'] }} || id: {{ $image->id }} || type: {{ $image->type }}</p>

            <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="image-gray" value="{{ '/images/' . $image->title['image'] }}">
                <input name="image" id="images" type="file" accept="image/png, image/jpeg">
                <input type="submit" value="Обновить">
            </form>

            <br>
            <br>
        @endforeach
    @endif
@endsection