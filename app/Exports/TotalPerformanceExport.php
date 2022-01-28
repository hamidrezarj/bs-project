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

use Maatwebsite\Excel\Concerns\FromCollection;

class TotalPerformanceExport implements FromQuery, WithHeadings, WithStyles, WithEvents, ShouldAutoSize, WithCharts
{
    public function __construct($from_date, $to_date, $votes)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->votes = $votes;
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
                
                $fromDate = verta($this->from_date)->format('H:i Y/m/d');
                $toDate = verta($this->to_date)->format('H:i Y/m/d');
                $date = 'از تاریخ '. $fromDate. ' تا '. $toDate;
                $event->sheet->setCellValue('E2', $date);

                $now = verta()->format('Y/m/d');
                $event->sheet->setCellValue('F2', $now);
                
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
            'کد پشتیبان',
            'نام و نام خانوادگی',
            'تعداد تیکت',
            'امتیاز نهائی',
            'بازه زمانی گزارش',
            'تاریخ'
        ];
    }

    public function charts()
    {
        $dataSeriesLabels = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, ['نظرسنجی نشده']),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, ['بسیار ضعیف']),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, ['ضعیف']),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, ['متوسط']),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, ['خوب']),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, ['عالی']),
        ];
        
        $xAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, [1]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, [2]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, [3]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, [4]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, [5]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, null, null, 1, [6]),
        ];
        
        $dataSeriesValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, null, null, 1, [$this->votes[0]]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, null, null, 1, [$this->votes[1]]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, null, null, 1, [$this->votes[2]]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, null, null, 1, [$this->votes[3]]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, null, null, 1, [$this->votes[4]]),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, null, null, 1, [$this->votes[5]]),
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
        
        $title = new Title('نمودار خلاصه عملکرد مرکز');
        
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

        return DB::table('ticket_answers')
                 ->join('users', 'ticket_answers.technical_id', '=', 'users.id')
                 ->where('technical_id', '!=', 0)
                 ->whereBetween('ticket_answers.created_at', $timeInterval)
                 ->groupBy('technical_id')
                 ->selectRaw("technical_id, concat(first_name, ' ', last_name) as full_name, count(*) as cnt, sum(vote_id)/count(vote_id) as performance")
                 ->orderBy('users.id');
    }
}
