<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
