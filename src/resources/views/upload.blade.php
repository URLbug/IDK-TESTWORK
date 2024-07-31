@extends('app')

@section('content')
    <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="images">Выберете несколько или только одно изображение</label>
        <br>
        image: <input name="image" id="images" type="file" accept="image/png, image/jpeg" required>
        <br>
        image-gray: <input name="image-gray" id="images" type="file" accept="image/png, image/jpeg">

        <br>

        <input type="submit" value="Выложить изображение">

        <br>
        @if(Session::get('success'))
            <p style="color: green">{{ Session::get('success') }}</p>
        @endif

        @if($errors->first())
            <p style="color: rgb(128, 0, 0)">{{ $errors->first() }}</p>
        @endif
    </form>
@endsection