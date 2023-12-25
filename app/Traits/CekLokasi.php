<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait CekLokasi
{
    public function isInRadius($lokasi, $latitude, $longitude)
    {
        $allowedLatitude = $lokasi->latitude;
        $allowedLongitude = $lokasi->longitude;
        $maxDistance = 1000;

        $earthRadius = 6371; // Radius Bumi dalam kilometer
        $dLat = deg2rad($allowedLatitude - $latitude);
        $dLon = deg2rad($allowedLongitude - $longitude);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude)) * cos(deg2rad($allowedLatitude)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c * $maxDistance; // Jarak dalam meter

        if ($distance <= $maxDistance) {
            $isInRadius = true;
        } else {
            $isInRadius = false;
        }

        return $isInRadius;
    }

    public function storeImage($img)
    {
        $folderPath = "public/images/security";

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
