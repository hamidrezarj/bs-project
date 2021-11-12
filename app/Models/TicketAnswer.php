<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function technical_support()
    {
        return $this->belongsTo(User::class);
    }
}
