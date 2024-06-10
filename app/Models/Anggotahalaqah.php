<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggotahalaqah extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function groupinghalaqah()
    {
        return $this->belongsTo(Groupinghalaqah::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
