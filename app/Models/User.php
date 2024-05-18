<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Absenalternatif;
use App\Models\Absenhalaqah;
use App\Models\jenjangPendidikan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password_absen',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function jenjangPendidikans()
    {
        return $this->hasMany(jenjangPendidikan::class);
    }

    public function scopeSearch($query, $term)
    {
        $columns = ['name', 'email'];
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

    public function absenhalaqahs()
    {
        return $this->hasMany(Absenhalaqah::class);
    }

    public function aksesabsens()
    {
        return $this->belongsToMany(Aksesabsen::class);
    }

    public function sekolahs()
    {
        return $this->hasOne(Sekolah::class);
    }
    public function absensekolahs()
    {
        return $this->hasMany(Absensekolah::class);
    }

    public function absenalternatifs()
    {
        return $this->hasMany(Absenalternatif::class);
    }

    public function chatifies()
    {
        return $this->hasMany(Chatify::class);
    }

    public function approvedBy()
    {
        return $this->hasOne(Complainmengajar::class);
    }

    public function absenkaryawans()
    {
        return $this->hasMany(Absenkaryawan::class);
    }

    public function bagianuser()
    {
        return $this->belongsTo(Bagianuser::class);
    }

}
