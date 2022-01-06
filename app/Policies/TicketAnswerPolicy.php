<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\TicketAnswer;
use App\Models\User;

class TicketAnswerPolicy
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

    // public function vote(User $user, TicketAnswer $ticketAnswer)
    // {
    //     return $user->id == $ticketAnswer->ticket->user->id;
    // }

    public function details(User $user, TicketAnswer $ticketAnswer)
    {
        return $user->id == $ticketAnswer->technical_id;
    }

    public function replyTicket(User $user, TicketAnswer $ticketAnswer)
    {
        return $user->id == $ticketAnswer->technical_id && $ticketAnswer->description == null;
    }
}
