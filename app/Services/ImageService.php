<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService {
    public function updateImage($model, $request, $path, $methodType) {
        // return 'aweaeaweawe';
        $manager = new ImageManager(new Driver());

        $file = $request->file('image');

        $image = $manager->read($file);
        // return print_r($image);
        // $extension = $image->getClientOriginalExtension();

        $image->crop(
            $request->width,
            $request->height,
            $request->left,
            $request->top
        );

        $extension = $file->getClientOriginalExtension();

        $name = uniqid() . '.' . $extension;
        $image->toJpeg()->save($path . $name);

        // if ($methodType === 'store') {
        //     $model->user_id = $request->get('user_id');
        // }

        $model->image = $name;

        $model->save();
    }
}


?>
