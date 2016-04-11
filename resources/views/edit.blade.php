@extends('app')
@section('content')
   
@if (Session::has('flash_notification.message'))
    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        {{ Session::get('flash_notification.message') }}
    </div>
@endif
<div class="notification">
    Примечание: имя и значения пути не могут быть изменены. Если Вы хотите изменить их, удалите, затем создайте новую фотографию:
</div>
    <br>
    {!! Form::model($imageToEdit, ['route' => ['images.update', $imageToEdit->image_id],
    'method' => 'PATCH',
    'class' => 'form',
    'files' => true]
    ) !!}


    <!-- image name Form Input -->
    <div>


        <ul>
            <li><h4>Имя:   {{ $imageToEdit->image_name. '.' . $imageToEdit->image_extension }}  </h4></li>
            <li><h4>Путь:   {{ $imageToEdit->image_path }} </h4> </li>
            <li><h4>Имя для моб изображения:   {{ $imageToEdit->mobile_image_name. '.' . $imageToEdit->mobile_extension }} </h4> </li>
            <li><h4>Путь для моб. изображения:   {{ $imageToEdit->mobile_image_path }} </h4></li>

        </ul>
    </div>

    <!-- is_something Form Input -->
    <div class="form-group">
        {!! Form::label('is_active', 'Активно:') !!}
        {!! Form::checkbox('is_active') !!}
    </div>

    <!-- is_featured Form Input -->
    <div class="form-group">
        {!! Form::label('is_featured', 'Обработано:') !!}
        {!! Form::checkbox('is_featured') !!}
    </div>
    <!-- form field for file -->
    <div class="form-group">
        {!! Form::label('image', 'Картинка') !!}
        {!! Form::file('image', null, array('class'=>'form-control')) !!}
    </div>

    <!-- form field for file -->
    <div class="form-group">
        {!! Form::label('mobile_image', 'Картинка для мобил') !!}
        {!! Form::file('mobile_image', null, array('class'=>'form-control')) !!}
    </div>

    <div class="form-group">

        {!! Form::submit('Edit', array('class'=>'btn btn-primary')) !!}

    </div>

    {!! Form::close() !!}
    <div>
        {!! Form::model($imageToEdit, ['route' => ['images.destroy', $imageToEdit->image_id],
        'method' => 'DELETE',
        'class' => 'form',
        'files' => true]
        ) !!}

        <div class="form-group">

            {!! Form::submit('Удалить изображение', array('class'=>'btn btn-danger', 'Onclick' => 'return ConfirmDelete();')) !!}

        </div>

        {!! Form::close() !!}



    </div>
@endsection
