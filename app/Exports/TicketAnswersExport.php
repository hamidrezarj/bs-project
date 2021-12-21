<?php

namespace App\Exports;

use App\Models\TicketAnswers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;


class TicketAnswersExport implements FromQuery
{
    public function __construct(int $supportId)
    {
        $this->supportId = $supportId;
    }

    public function query()
    {
        return TicketAnswers::query()->where('technical_id', $this->supportId)
                 ->WhereNotNull('user_vote')
                 ->groupBy('user_vote')
                 ->selectRaw('count(*) as total, user_vote');
    }
}
