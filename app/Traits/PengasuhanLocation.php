<?php
namespace App\Traits;

trait PengasuhanLocation
{

    public function pengasuhanRadius($latitude, $longitude)
    {

        $allowedLatitude = 5.463151;
        $allowedLongitude = 95.386354;
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

}
