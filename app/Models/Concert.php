<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Concert extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'name',
        'description',
        'venue',
        'start_date',
        'end_date',
        'price',
        'quota',
        'status',
        'image',
    ];

    public function updateStatus(): void
    {
        $now = now();

        if ($this->quota === 0 && $this->end_date > $now) {
            $this->status = 'sold_out';
        } elseif ($this->quota > 0 && $this->end_date > $now) {
            $this->status = 'active';
        } elseif ($this->end_date <= $now) {
            $this->status = 'ended';
        }

        $this->save();
    }
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
