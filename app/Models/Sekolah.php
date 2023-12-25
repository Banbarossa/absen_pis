<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rombels()
    {
        return $this->hasMany(Rombel::class);
    }

    public function scopeSearch($query, $term)
    {
        $columns = ['npsn', 'nama'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'like', "%{$term}%");
        }

        return $query;
    }
}
