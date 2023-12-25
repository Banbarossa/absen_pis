<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensecurityceklokasi extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function securelocation()
    {
        return $this->belongsTo(SecureLocation::class);
    }
}
