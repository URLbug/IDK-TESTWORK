@extends('app')

@section('content')
    @if(isset($images))
        @foreach ($images as $image)
            <img src="{{ '/images/' . $image->title }}">

            <p>title: {{ $image->title }} || id: {{ $image->id }} || type: {{ $image->type }}</p>

            <br>
            <br>
        @endforeach
    @endif
@endsection