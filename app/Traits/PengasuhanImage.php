<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait PengasuhanImage
{

    public function storeImage($img)
    {
        // simpan image
        // $img = $request->image;
        $folderPath = "public/images/karyawan";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        return $fileName;
    }

}
