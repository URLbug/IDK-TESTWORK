@extends('app')

@section('content')
    <form action="{{ route('home') }}" method="POST">
        @csrf

        <input type="text" name="search" id="search" class="search" placeholder="Поиск" required>
        <input type="submit" value="Поиск">
    </form>
    <br>
    
    @if(isset($images) && $images !== [null])
        @foreach ($images as $image)
            <img src="{{ '/images/' . $image->title }}">

            <p>title: {{ $image->title }} || id: {{ $image->id }} || type: {{ $image->type }}</p>

            <br>
            <br>
        @endforeach
    @endif
@endsection