@extends('app')
@section('content')
      
 <br>
 @if (Session::has('flash_notification.message'))
    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        {{ Session::get('flash_notification.message') }}
    </div>
@endif

    <div>
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Список изображений </div>
            <div class="panel-body">
            <a href="/images/create"> <button type="button" class="btn btn-lg btn-success">
                     Новая картинка </button> </a>
            </div>

            <!-- Table -->
            <table class="table">
                <tr>
                    <th>№ п/п </th>
                    <th>Имя </th>
                    <th>Превью </th>
                    <th>Редактировать </th>
                    <th>Удалить </th>
                </tr>
    @foreach($images as $image )

                    <tr>
                        <td>{{ $image->image_id }}  </td>
                        <td>{{ $image->image_name }} </td>
                        <td> 
                            <a href="/images/{{ $image->image_id  }}">
                                <img src="/img/any/thumbnails/{{ 'thumb-'. $image->image_name . '.' .
                               $image->image_extension . '?'. 'time='. time() }}"> </a> 
                        </td>
                        <td>  
                            <a href="/images/{{ $image->image_id }}/edit">
                                <span class="glyphicon glyphicon-edit"          
                                 aria-hidden="true"> </span> </a> 
                        </td>
                        <td>
                                {!! Form::model($image, ['route' => ['images.destroy', $image->image_id],
                                    'method' => 'DELETE']) !!}
                            <div class="form-group">
                                {!! Form::submit('Удалить', array('class'=>'btn btn-danger', 'Onclick'=> 'return ConfirmDelete();')) !!}
                            </div>
                                {!! Form::close() !!} 
                        </td>
                    </tr>
        @endforeach
            </table>
        </div>
    </div>
   @endsection

