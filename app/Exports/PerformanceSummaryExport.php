<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Illuminate\Support\Facades\DB;
use App\Models\TicketAnswer;

class PerformanceSummaryExport implements FromQuery, WithHeadings, WithStyles, WithEvents, ShouldAutoSize, WithCharts, WithColumnFormatting
{
    public function __construct(int $supportId, $from_date, $to_date, $full_name, $performance)
    {
        $this->supportId = $supportId;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->full_name = $full_name;
        $this->performance = $performance;
        $this->date = $from_date ."_". $to_date;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);

                $default_font_style = [
                    'font' => ['name' => 'B Nazanin', 'size' => 11]
                ];
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->applyFromArray($default_font_style);

                $event->sheet->setCellValue('E2', $this->supportId);
                $event->sheet->setCellValue('F2', $this->full_name);
                $event->sheet->setCellValue('G2', $this->date);
                $event->sheet->setCellValue('D2', $this->performance);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['name' => 'B Mitra', 'bold' => true, 'size' => 12]],
        ];
    }

    public function headings(): array
    {
        return [
            'تعداد تیکت',
            'امتیاز کاربران',
            'وضعیت',
            'امتیاز نهائی',
            'کد پشتیبان',
            'نام و نام خانوادگی',
            'بازه زمانی گزارش',
        ];
    }

    // public function map($data): array
    // {
        
    //     return [
    //         // $this->supportId, 
    //         // $this->full_name,
    //         // $this->date,
    //         'E' => $data->cnt,
    //         'F' => $data->point,
    //         'G' => $data->status,
    //         // $this->performance,
    //     ];
    // }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function charts()
    {
        $dataSeriesLabels = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$2', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$3', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$4', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$5', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$6', null, 1),
        ];
        
        $xAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$2', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$3', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$4', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$5', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$6', null, 1),
        ];
        
        $dataSeriesValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$2', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$3', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$4', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$5', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$6', null, 1),
        ];
        
        
        $series = new DataSeries(
            DataSeries::TYPE_BARCHART, // plotType
            DataSeries::GROUPING_CLUSTERED, // plotGrouping
            range(0, count($dataSeriesValues) - 1), // plotOrder
            $dataSeriesLabels, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues        // plotValues
        );

        $series->setPlotDirection(DataSeries::DIRECTION_COL);
    
        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_BOTTOM, null, false);
        
        $title = new Title('نمودار خلاصه کیفیت پاسخگویی');
        
        $chart = new Chart(
            'chart1', // name
            $title, // title
            $legend, // legend
            $plotArea, // plotArea
            true, // plotVisibleOnly
            DataSeries::EMPTY_AS_GAP, // displayBlanksAs
            null, // xAxisLabel
        );
        
        $chart->setTopLeftPosition('H12');
        $chart->setBottomRightPosition('N26');

        return $chart;
    }

    public function query()
    {
        $timeInterval = [$this->from_date, $this->to_date];

        /** get vote options that doesn't exist in user's votes */
        $otherVotes = DB::table('votes')
                        ->selectRaw("0, id, name")
                        ->whereNotIn('id', function ($query) {
                            $query->select('votes.id')
                                  ->from('votes')
                                  ->leftJoin('ticket_answers', 'votes.id', '=', 'ticket_answers.vote_id')
                                  ->where('technical_id', $this->supportId);
                        });

        return Db::table('ticket_answers')->join('votes', 'ticket_answers.vote_id', '=', 'votes.id')
                           ->where('technical_id', $this->supportId)
                           ->WhereNotNull('vote_id')
                           ->whereBetween('ticket_answers.created_at', $timeInterval)
                           ->groupBy('vote_id')
                           ->selectRaw("count(votes.id) as cnt, votes.id as point, votes.name as status")
                           ->orderBy('ticket_answers.id')
                           ->union($otherVotes);
    }
}
