<?php


namespace App\Libraries;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ImageConversion
{
    public static function imageResize($imageUrl)
    {

        if (!Storage::disk('s3')->exists($imageUrl)) {
            return null;
        }

        $min = 200;
        $resize = 200;

        $orignalImage = Storage::disk('s3')->url($imageUrl);

        $imageResize = Image::make($orignalImage);

        if ($imageResize->width() > $min || $imageResize->height() > $min) {

            $imageResize->resize($resize, $resize, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $filePath =  'images/thumbnail/'.$imageUrl;

            Storage::disk('s3')->put($filePath, $imageResize->encode());
            return [
                'path' => $filePath,
                'width' => $imageResize->width(),
                'height' => $imageResize->height(),
            ];
        }
        else{
            return [
                'path' => $imageUrl,
                'width' => $imageResize->width(),
                'height' => $imageResize->height(),
            ];
        }

        return null;
    }
}
