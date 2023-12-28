<?php
namespace App\Traits;

use App\Models\Sekolah;

trait ListSekolah
{
    public static function getData()
    {
        return Sekolah::all();
    }
}
