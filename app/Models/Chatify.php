<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatify extends Model
{
    use HasFactory;

    protected $table = 'ch_messages';

    public function user()
    {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }

}
