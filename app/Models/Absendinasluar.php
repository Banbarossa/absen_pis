<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absendinasluar extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function absenkaryawandetail()
    {
        return $this->belongsTo(\App\Models\Absenkaryawandetail::class);
    }
}
