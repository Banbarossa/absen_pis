<?php

namespace App\Models;

use App\Models\Absenhalaqah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalHalaqah extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function scopeSearch($query, $term)
    {
        $columns = ['nama_sesi', 'insentif', 'mulai_absen', 'akhir_absen'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'like', "%{$term}%");
        }
        return $query;
    }

    public function absenhalaqahs()
    {
        return $this->hasMany(Absenhalaqah::class);
    }

}
