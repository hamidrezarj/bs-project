<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // protected $table = 'tickets';

    protected $fillable = [
        'course_name',
        'course_id',
        'description',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket_answers()
    {
        return $this->hasOne(TicketAnswer::class);
    }
}
