@extends('app')
@section('content')
    <div>
    {{ $imageToTbl ->image_name }} :  <br>

        <img src="/img/any/{{ $imageToTbl->image_name . '.' .
         $imageToTbl->image_extension . '?'. 'time='. time() }}">

    </div>

    <div>

       {{ $imageToTbl->image_name }} - превью :  <br>

        <img src="/img/any/thumbnails/{{ 'thumb-' . $imageToTbl->image_name . '.' .
    $imageToTbl->image_extension . '?'. 'time='. time() }}">

    </div>

    <div>

       {{ $imageToTbl->mobile_image_name }} - для мобил :  <br>

        <img src="/img/any/mobile/{{ $imageToTbl->mobile_image_name . '.' .
         $imageToTbl->mobile_extension . '?'. 'time='. time() }}">

    </div>
<a href="{{ url('/images') }}">Вернуться ко всем изображениям</a>

@endsection