<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function scopeSearch($query, $term)
    {
        $query->whereStatus(1)->where('mata_pelajaran', 'like', "%{$term}%");
        return $query;
    }

    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }

    public function absensekolahs()
    {
        return $this->hasMany(Absensekolah::class);
    }
}
