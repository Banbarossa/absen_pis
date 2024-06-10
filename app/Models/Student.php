<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function anggotakelas()
    {
        return $this->hasMany(AnggotaKelas::class);
    }

    public function anggotahalaqah()
    {
        return $this->hasone(Anggotahalaqah::class);
    }

    public function absensiswa()
    {
        return $this->hasMany(Absensiswa::class);
    }

}
