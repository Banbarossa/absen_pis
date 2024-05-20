<?php

namespace App\Models;

use App\Models\Bagianuser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absenkaryawan extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jamkaryawan()
    {
        return $this->belongsTo(Jamkaryawan::class);
    }

    public function bagianuser()
    {
        return $this->belongsTo(Bagianuser::class);
    }

    public function absenkaryawandetails(): HasMany
    {
        return $this->hasMany(Absenkaryawandetail::class);
    }

}
