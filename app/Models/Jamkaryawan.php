<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Jamkaryawan extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function scopeSearch($query, $term)
    {

        $query->orWhere('nama_jam_kerja', 'like', "%{$term}%");
        return $query;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'jamkaryawans_roles', 'jamkaryawan_id', 'role_id');
    }

    public function absenkaryawans()
    {
        return $this->hasMany(Absenkaryawan::class);
    }

}
