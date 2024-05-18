<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagianuser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function jamkaryawans()
    {
        return $this->hasMany(Jamkaryawan::class);
    }

    public function absenkaryawans()
    {
        return $this->hasMany(Absenkaryawan::class);
    }
}
