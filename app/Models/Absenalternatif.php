<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absenalternatif extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function absensekolah()
    {
        return $this->hasOne(Absensekolah::class);
    }
}
