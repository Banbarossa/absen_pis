<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jammengajar extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function scopeSearch($query, $term)
    {
        $columns = ['hari', 'jam_ke', 'mulai_kbm', 'akhir_kbm', 'mulai_absen', 'akhir_absen'];

        foreach ($columns as $column) {
            $query->orWhere($column, 'like', "%{$term}%");
        }
    }

    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }
}
