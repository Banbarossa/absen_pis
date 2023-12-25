<?php

namespace App\Models;

use App\Models\JadwalHalaqah;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absenhalaqah extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function jadwalhalaqah()
    {
        return $this->belongsTo(JadwalHalaqah::class, 'jadwal_halaqah_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $term)
    {
        $columns = ['user_id', 'jadwal_halaqah_id', 'tanggal', 'waktu_absen'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'like', "%{$term}%");
        }
        return $query;
    }

    public function complainhalaqah()
    {
        return $this->hasOne(Complainhalaqah::class, 'absenhalaqah_id');
    }
}
