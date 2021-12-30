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

class ResponseRateExport implements FromQuery, WithHeadings, WithStyles, WithEvents, ShouldAutoSize, WithCharts, WithColumnFormatting
{
    public function __construct(int $supportId, $from_date, $to_date, $full_name, $responseRate)
    {
        $this->supportId = $supportId;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->full_name = $full_name;
        $this->responseRate = $responseRate;
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

                $event->sheet->setCellValue('D2', $this->supportId);
                $event->sheet->setCellValue('E2', $this->full_name);
                $event->sheet->setCellValue('F2', $this->date);
                $event->sheet->setCellValue('C2', $this->responseRate);
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
            'وضعیت',
            'درصد پاسخگویی',
            'کد پشتیبان',
            'نام و نام خانوادگی',
            'بازه زمانی گزارش',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function charts()
    {
        $dataSeriesLabels = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$2', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$3', null, 1),
        ];
        
        $xAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '', null, 1),
        ];
        
        $dataSeriesValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$2', null, 1),
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$3', null, 1),
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
        
        $title = new Title('نمودار درصد پاسخگویی');
        
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
        $notAnswered = DB::table('ticket_answers')
                        ->selectRaw("count(id) as cnt, 'پاسخ داده نشده'")
                        ->where('technical_id', $this->supportId)
                        ->whereBetween('ticket_answers.created_at', $timeInterval)
                        ->WhereNull('description');

        return DB::table('ticket_answers')
                 ->selectRaw("count(id) as cnt, 'پاسخ داده شده'")
                 ->where('technical_id', $this->supportId)
                 ->whereBetween('ticket_answers.created_at', $timeInterval)
                 ->WhereNotNull('description')
                 ->orderBy('id')
                 ->union($notAnswered);
    }
}
