@extends('app')
@section('content')
    @if (Session::has('flash_notification.message'))
        <div class="alert alert-{{ Session::get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

            {{ Session::get('flash_notification.message') }}
        </div>
    @endif

     <h1>Загрузить фото </h1>

     <hr/>

    @if (count($errors) > 0)
	 <div class="alert alert-danger">
	 <strong>Упс! </strong> Что-то случилось с вашей загрузкой. <br> <br>
	 <ul>
	     @foreach ($errors->all() as $error)
		 <li>{{ $error }} </li>
	     @endforeach

         </ul>
         </div>

    @endif


    {!! Form::open(array('action' => 'AnyImagesController@store', 'class' => 'form', 'files' => true)) !!}

     <!-- image name Form Input -->
     <div class="form-group">
        {!! Form::label('image name', 'Имя:') !!}
        {!! Form::text('image_name', null, ['class' => 'form-control']) !!}
     </div>


      <!--mobile_image_name Form Input -->
     <div class="form-group">
        {!! Form::label('mobile_image_name', 'Имя для мобил:') !!}
        {!! Form::text('mobile_image_name', null, ['class' => 'form-control']) !!}
     </div>


<!--      is_something Form Input -->
     <div class="form-group">
        {!! Form::label('is_active', 'Активно?:') !!}
        {!! Form::checkbox('is_active') !!}
     </div>

<!--      is_featured Form Input -->
     <div class="form-group">
        {!! Form::label('is_featured', 'Обработано?:') !!}
        {!! Form::checkbox('is_featured') !!}
     </div>

<!--     form field for file -->
    <div class="form-group">
       {!! Form::label('image', 'Картинка') !!}
       {!! Form::file('image', null, array('required', 'class'=>'form-control')) !!}
    </div>

<!--      form field for file -->
     <div class="form-group">
        {!! Form::label('mobile_image', 'Картинка для мобил') !!}
        {!! Form::file('mobile_image', null, array('required', 'class'=>'form-control')) !!}
     </div>

     <div class="form-group">

        {!! Form::submit('Загрузить изображение', array('class'=>'btn btn-primary')) !!}

     </div>

    {!! Form::close() !!}


@endsection



