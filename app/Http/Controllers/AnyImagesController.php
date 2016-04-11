<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\Http\Requests\CreateImageRequest;

use App\Http\Requests\EditImageRequest;

use App\Anyimage;

use Image;

use Flash;

use Illuminate\Support\Facades\File;

class AnyImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return 'Hello from index' ;
        $images = Anyimage::all();
        return view('index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('create', compact($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateImageRequest $request)
    {
        $image = new Anyimage([
           'image_name'        => $request->get('image_name'),
           'image_extension'   => $request->file('image')->getClientOriginalExtension(),
           'mobile_image_name' => $request->get('mobile_image_name'),
           'mobile_extension'  => $request->file('mobile_image')->getClientOriginalExtension(),
           'is_active'         => $request->get('is_active'),
           'is_featured'       => $request->get('is_featured'),
        ]);
        
        //папки хранения изображений
           $destinationFolder = '/img/any/';
           $destinationThumbnail = '/img/any/thumbnails/';
           $destinationMobile = '/img/any/mobile/';
        
        //присваиваем пути для дальнейшего сохранения в БД
            $image->image_path = $destinationFolder;
            $image->mobile_image_path = $destinationMobile;
            
        // форматируем value чекбоксов и сохраняем модель
           $this->formatCheckboxValue($image);
           $image->save();
           
        //необходимые части нашего изображения

           $file = Input::file('image');

           $imageName = $image->image_name;
           $extension = $request->file('image')->getClientOriginalExtension();

        //создаем инстанс изображения из temp upload

           $img = Image::make($file->getRealPath());

        //сохраняем изображение с thumbnail

           $img->save(public_path() . $destinationFolder . $imageName . '.' . $extension)
               ->resize(null, 60, function($constraint){$constraint->aspectRatio();})
               ->save(public_path() . $destinationThumbnail . 'thumb-' . $imageName . '.' . $extension);

        // и теперь для мобильных приложений

           $mobileFile = Input::file('mobile_image');

           $mobileImageName = $image->mobile_image_name;
           $mobileExtension = $request->file('mobile_image')->getClientOriginalExtension();

        //создаем инстанс изображения из temp upload
           $mobileImage = Image::make($mobileFile->getRealPath());
           $mobileImage->save(public_path() . $destinationMobile . $mobileImageName . '.' . $mobileExtension);


        // Process the uploaded image, add $model->attribute and folder name

           flash()->success('Изображение добавлено!');

           //return redirect()->route('show', compact('image') /*[$img]*/);   
           return redirect()->route('images.index');   
   
    }
    
    public function formatCheckboxValue($image){
        $image->is_active = ($image->is_active == null) ? 0 : 1;
        $image->is_featured = ($image->is_featured == null) ? 0 : 1;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $imageToTbl = Anyimage::findOrFail($id);
        return view('show', compact('imageToTbl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $imageToEdit = Anyimage::findOrFail($id);
        return view('edit', compact('imageToEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditImageRequest $request, $id)
    {
        $imageToEdit = Anyimage::findOrFail($id);
        $imageToEdit->is_active = $request->get('is_active');
        $imageToEdit->is_featured = $request->get('is_featured');
        $this->formatCheckboxValue($imageToEdit);
        $imageToEdit->save();
        if ( ! empty(Input::file('image'))){

           $destinationFolder = '/img/any/';
           $destinationThumbnail = '/img/any/thumbnails/';

           $file = Input::file('image');

           $imageName = $imageToEdit->image_name;
           $extension = $request->file('image')->getClientOriginalExtension();

           //create instance of image from temp upload
           $image = Image::make($file->getRealPath());

           //save image with thumbnail
           $image->save(public_path() . $destinationFolder . $imageName . '.' . $extension)
               ->resize(null, 60, function($constraint){$constraint->aspectRatio();})
               ->save(public_path() . $destinationThumbnail . 'thumb-' . $imageName . '.' . $extension);
        }
        else{
            flash()->error('Это поле должно быть заполнено');
        }

        if ( ! empty(Input::file('mobile_image'))) {

           $destinationMobile = '/img/any/mobile/';
           $mobileFile = Input::file('mobile_image');

           $mobileImageName = $imageToEdit->mobile_image_name;
           $mobileExtension = $request->file('mobile_image')->getClientOriginalExtension();

           //create instance of image from temp upload
           $mobileImage = Image::make($mobileFile->getRealPath());
           $mobileImage->save(public_path() . $destinationMobile . $mobileImageName . '.' . $mobileExtension);
        }
        else{
            flash()->error('Это поле должно быть заполнено');
        }

        flash()->success('Изображение '.$imageToEdit->image_id.' отредактировано!');
        return redirect()->route('images.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imageToDel = Anyimage::findOrFail($id);
        $thumbPath = $imageToDel->image_path.'thumbnails/';

        File::delete(public_path($imageToDel->image_path).
                                 $imageToDel->image_name . '.' .
                                 $imageToDel->image_extension);

        File::delete(public_path($imageToDel->mobile_image_path).
                                 $imageToDel->mobile_image_name . '.' .
                                 $imageToDel->mobile_extension);
        File::delete(public_path($thumbPath). 'thumb-' .
                                 $imageToDel->image_name . '.' .
                                 $imageToDel->image_extension);

        Anyimage::destroy($id);

        flash()->success('Изображение '.$imageToDel->image_id.' удалено!');

        return redirect()->route('images.index');
    }
}
