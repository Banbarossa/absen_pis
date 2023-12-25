<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function scopeSearch($query, $term)
    {
        $columns = ['nama_semester', 'tahun', 'status'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'like', "%{$term}%");
        }

        return $query;
    }

    public function walas()
    {
        return $this->hasMany(Walas::class);
    }

    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }

}
