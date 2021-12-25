<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Library\ImageUploader\ImageUploader;
use Illuminate\Http\Request;

class UploadController extends Controller
{

    public $allowedTypes = ['setting'];
    public $paths = [
        'settingImage' => '/storage/images/settings/',
        'categoryImage' => '/storage/images/categories/',
        'settingFile' => '/storage/files/settings/',
    ];

    public function upload(Request $request)
    {
        $this->createDirectories();
        $files = $request->allFiles();
        $imageUploader = new ImageUploader();
        $resArr = [];

        if (in_array($request->type, $this->allowedTypes)) {
            foreach ($files as $name => $file) {
                $requestFile = $request->file($name);
                if (substr($requestFile->getMimeType(), 0, 5) == 'image') {

                    $path = '/storage/images/';
                    if ($request->type == 'setting') {
                        $path = $this->paths['settingImage'];
                        $fileName = $name;
                    }
                    try {
                        $imageUploader->path = $path;
                        return $imageUploader->upload($requestFile, $fileName, [100, 200]);
                    } catch (\Exception $e) {
                    }
                }
            }
        }
        return abort(500);
    }

    public function createDirectories()
    {
        foreach ($this->paths as $path) {
            $path = public_path($path);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            } else {
                //@chmod($path, 0777);
            }
        }
    }


}
