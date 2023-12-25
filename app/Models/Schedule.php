<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function jammengajar()
    {
        return $this->hasMany(Jammengajar::class);
    }

    public function rombels()
    {

        return $this->belongsToMany(Rombel::class, 'rombel_schedule', 'schedule_id', 'rombel_id')
            ->withPivot('semester_id');
    }
}
