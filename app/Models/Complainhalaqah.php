<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complainhalaqah extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function absenhalaqah()
    {
        return $this->belongsTo(Absenhalaqah::class);
    }

}
