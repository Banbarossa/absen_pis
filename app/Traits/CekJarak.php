<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait CekJarak
{
    public function distance($lat1, $lon1, $latuser, $lonuser)
    {
        $theta = $lon1 - $lonuser;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($latuser))) + (cos(deg2rad($lat1)) * cos(deg2rad($latuser)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
