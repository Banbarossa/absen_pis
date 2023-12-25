<?php

namespace App\Models;

use App\Models\Absenalternatif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensekolah extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function mapel()
    {
        return $this->belongsTo(mapel::class);
    }

    public function absenalternatif()
    {
        return $this->belongsTo(Absenalternatif::class);
    }

    public function complainmengajar()
    {
        return $this->hasOne(Complainmengajar::class);
    }

}
