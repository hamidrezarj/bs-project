<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket_answer()
    {
        return $this->hasOne(TicketAnswer::class);
    }

    public function getCreatedAtFaAttribute()
    {
        return Jalalian::fromCarbon(new Carbon($this->created_at));
    }
}
