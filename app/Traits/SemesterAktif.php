<?php

namespace App\Traits;

use App\Models\Semester;

trait SemesterAktif
{

    public static function getSemesterAktif()
    {
        $semesteraktif = Semester::whereStatus(true)->first();

        return $semesteraktif;
    }
}
