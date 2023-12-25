<?php

namespace App\Models;

use App\Models\Absensekolah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complainmengajar extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function absensekolah()
    {
        return $this->belongsTo(Absensekolah::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
