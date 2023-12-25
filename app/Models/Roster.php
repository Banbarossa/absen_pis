<?php

namespace App\Models;

use App\Models\Jammengajar;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function jammengajar()
    {
        return $this->belongsTo(Jammengajar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
}
