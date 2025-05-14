<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

    public function details()
    {
        return $this->hasMany(TicketDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
