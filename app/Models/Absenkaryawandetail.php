<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Absenkaryawandetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jamkaryawan(): BelongsTo
    {
        return $this->belongsTo(Absenkaryawan::class);
    }

    public function absenkaryawan(): BelongsTo
    {
        return $this->belongsTo(Absenkaryawan::class, 'absenkaryawan_id', 'id');
    }

    public function absendinasluar(): HasOne
    {
        return $this->hasOne(Absendinasluar::class);
    }

}
