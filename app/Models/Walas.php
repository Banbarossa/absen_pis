<?php

namespace App\Models;

use App\Models\Rombel;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walas extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

}
