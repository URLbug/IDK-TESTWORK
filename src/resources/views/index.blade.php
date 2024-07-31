@extends('app')

@section('content')
    @if(isset($images))
        @foreach ($images as $image)
            <img src="{{ $image->src }}">
        @endforeach
    @endif
@endsection