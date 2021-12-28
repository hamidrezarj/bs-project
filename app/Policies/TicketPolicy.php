<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;    
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function details(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->user->id;
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->user->id;
    }

    public function vote(User $user, Ticket $ticket)
    {
        return $user->id == $ticket->user->id && $ticket->status == 'answered';
    }
}
