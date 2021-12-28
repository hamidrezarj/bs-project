<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\Title;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\TicketAnswer;

class SupportsExport implements FromQuery, WithHeadings, WithStyles, WithEvents, ShouldAutoSize, WithCharts
{
    public function __construct(int $supportId, $from_date, $to_date, $performance)
    {
        $this->supportId = $supportId;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->performance = $performance;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                // $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setName('B Mitra');
            },
            AfterSheet::class => function (AfterSheet $event) {
                $default_font_style = [
                    'font' => ['name' => 'B Nazanin', 'size' => 10]
                ];
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->applyFromArray($default_font_style);
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
            'مقدار',
            'امتیاز نهائی'
        ];
    }

    public function charts()
    {
        $dataSeriesLabels = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$2', null, 1), // 2010
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$3', null, 1), // 2011
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$4', null, 1), // 2012
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$5', null, 1), // 2012
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$6', null, 1), // 2012
        ];
        
        $xAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$2:$C$6', null, 5), // Q1 to Q4
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
        // $yAxisLabel = new Title('Value ($k)');
        
        $chart = new Chart(
            'chart1', // name
            $title, // title
            $legend, // legend
            $plotArea, // plotArea
            true, // plotVisibleOnly
            DataSeries::EMPTY_AS_GAP, // displayBlanksAs
            null, // xAxisLabel
            // $yAxisLabel  // yAxisLabel
        );
        
        $chart->setTopLeftPosition('G12');
        $chart->setBottomRightPosition('M26');

        return $chart;
    }

    public function query()
    {
        $timeInterval = [$this->from_date, $this->to_date];
        return TicketAnswer::join('votes', 'ticket_answers.vote_id', '=', 'votes.id')
                           ->where('technical_id', $this->supportId)
                           ->WhereNotNull('vote_id')
                           ->whereBetween('ticket_answers.reply_date', $timeInterval)
                           ->groupBy('vote_id')
                           ->selectRaw("count(votes.id), votes.id, votes.name");

    }
}
