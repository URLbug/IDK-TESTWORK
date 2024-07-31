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
            @endif

            <img src="{{ '/images/' . $image->title['image'] }}">

            <p>title: {{ $image->title['image'] }} || id: {{ $image->id }} || type: {{ $image->type }}</p>

            <br>
            <br>
        @endforeach
    @endif
@endsection