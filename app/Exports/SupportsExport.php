<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\User;
use App\Models\TicketAnswer;

class SupportsExport implements FromQuery
{
    public function __construct(int $supportId)
    {
        $this->supportId = $supportId;
    }

    public function query()
    {
        return TicketAnswer::query()->where('technical_id', $this->supportId)
                 ->WhereNotNull('user_vote')
                 ->groupBy('user_vote')
                 ->selectRaw("count(*) as total, user_vote,
                              CASE 
                                    WHEN user_vote = 1 THEN 'بسیار ضعیف'
                                    WHEN user_vote = 2 THEN 'ضعیف'
                                    WHEN user_vote = 3 THEN 'متوسط'
                                    WHEN user_vote = 4 THEN 'خوب'
                                    WHEN user_vote = 5 THEN 'عالی'
                              END AS vote");
    }
}
