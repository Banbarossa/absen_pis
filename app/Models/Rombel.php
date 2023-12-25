<?php

namespace App\Models;

use App\Models\Absenalternatif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function jenjang()
    {
        return $this->belongsTo(JenjangPendidikan::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function scopeSearch($query, $term)
    {
        $columns = ['nama_rombel', 'tingkat_kelas'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'like', "%{$term}%");
        }
        return $query;
    }

    public function walas()
    {
        return $this->hasMany(Walas::class);
    }

    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'rombel_schedule', 'rombel_id', 'schedule_id')
            ->withPivot('semester_id');
    }

    public function absensekolahs()
    {
        return $this->hasMany(Absensekolah::class);
    }

    public function absenalternatifs()
    {
        return $this->hasMany(Absenalternatif::class);
    }

}
