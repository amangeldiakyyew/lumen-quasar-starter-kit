<?php

namespace App\Library\ImageUploader;

use Intervention\Image\ImageManager as Image;

class ImageUploader
{
    public $imageClass;
    public $path = '/storage/';
    public $background = 'ffffff';
    public $constraintUpsize = true;
    public $extension = '.jpeg';

    public function __construct()
    {
        $this->imageClass = new Image();
    }


    public function upload($imageFile, $name = null, $widths = [], $maxWidth = 1000, $maxHeight = false)
    {
        if ($name == null) {
            $name = uniqid() . rand(1000, 9999) . '_' . 'image';
        }
        try {
            $this->extension = '.' . $imageFile->clientExtension();
        } catch (\Exception $e) {
            $this->extension = '.jpg';
        }

        if ($maxHeight) {
            $canvas = $this->imageClass->canvas($maxWidth, $maxHeight, $this->background);
            $image = $this->imageClass->make($imageFile)->resize($maxWidth, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
            });
            $canvas->insert($image, 'center');
            $img = $canvas;
        } else {
            $img = $this->imageClass->make($imageFile);
            $img->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                if ($this->constraintUpsize == true) {
                    $constraint->upsize();
                }
            });
        }
        $imgPath = $this->path . $name . $this->extension;
        $img->save(public_path($imgPath));

        $imagesArray = [];
        $imagesArray[$img->width()] = [
            's' => url($imgPath),
            'w' => $img->width(),
            'h' => $img->height(),
        ];
        $img->destroy();

        foreach ($widths as $xWidth) {
            $xPath = $this->path . $name . '-' . $xWidth . $this->extension;
            $xImg = $this->imageClass->make(public_path($imgPath));
            $xImg->resize($xWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $xImg->save(public_path($xPath));
            $imagesArray[$xWidth] = [
                's' => url($xPath),
                'w' => $xImg->width(),
                'h' => $xImg->height(),
            ];
            $xImg->destroy();
        }

        return $imagesArray;
    }

}
