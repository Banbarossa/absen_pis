<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensiswa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function absensekolah()
    {
        return $this->belongsTo(Absensekolah::class);
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
}
