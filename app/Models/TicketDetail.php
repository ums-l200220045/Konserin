<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    protected $fillable = [
        'ticket_id',
        'holder_name',
        'holder_nik',
        'qr_code',
    ];
    
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
