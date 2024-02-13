<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportLeave implements FromCollection
{

    protected $export_datas;
    protected $totalRecord;

    protected $totalAmount_usd;
    protected $totalAmount_riel;
    protected $totalTaxdeduction_usd;
    protected $totalTaxdeduction_riel;
    protected $totalwithholding_tax_rate_usd;
    protected $totalwithholding_tax_rate_riel;
    protected $totalEarnings_after_tax_usd;
    protected $totalEarnings_after_tax_riel;

    public function __construct($export_data)
    {
        $this->totalRecord = count($export_data);
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $i++;
            $start_date = Carbon::createFromDate($value->start_date)->format('d-m-Y');
            $end_date = Carbon::createFromDate($value->end_date)->format('d-m-Y');
            $dataExport[] = [
                "number"                        => $i,
                "employee_name"                 => $value->employee->employee_name_en ,
                "leave_type"                    => $value->leaveType->name,
                "department"                    => $value->employee->department->name_english,
                "location"                      => $value->employee->branch->branch_name_en,
                "start_date"                    => $start_date,
                "end_date"                      => $end_date,
                "status"                        => $value->status,
                "reason"                        => $value->reason,
                "remark"                        => $value->remark,
            ];
        }
        $this->export_datas = $dataExport;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([
            $this->export_datas,
        ]);
    }
    public function startCell(): string
    {
        return 'A6';
    }
    // Khmer OS Muol Light
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,      
            'C' => 20,      
            'D' => 20,      
            'E' => 20,      
            'F' => 20,      
            'G' => 20,      
            'H' => 20,      
            'I' => 20,      
            'J' => 20,      
            'K' => 20,      
            'L' => 20,      
            'M' => 20,      
            'N' => 20,      
            'O' => 20,      
            'P' => 20,      
            'Q' => 20,      
            'R' => 20,      
            'S' => 20,      
            'T' => 20,      
            'U' => 20,      
            'V' => 20,
            'W' => 20,
            'X' => 20,
        ];
    }

    public function headings(): array
    {
        return [
                "#",
                "Employee Name" ,
                "Leave Type",
                "Department",
                "Location",
                "Start Date",
                "End Date",
                "Number of Days",
                "Status",
                "Reason",
                "Remark",
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:Q2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:Q2')->getFont()->setName('Khmer OS Muol Pali')
                ->setSize(14)->setUnderline('A2:Q2');
                $event->sheet->getDelegate()->getStyle('A2:Q2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:Q3');
                $sheet->setCellValue('A3', "CAMMA Microfinance Limited.");
                $sheet->getDelegate()->getStyle('A3:Q3')->getFont()->setName('Copperplate Gothic Light')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:Q3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');
                $sheet->mergeCells('A4:Q4');
                $sheet->setCellValue('A4', "ចំណាយលើប្រាក់អត្ថប្រយោជន៍បន្ថែមខែ ".$month.' '.$year);
                $sheet->getDelegate()->getStyle('A4:Q4')->getFont()->setName('Khmer OS Bokor')
                ->setSize(12);
                $event->sheet->getDelegate()->getStyle('A4:Q4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('C5:D5');
                $sheet->setCellValue('C5', "នាម និង គោត្តនាម");
                $sheet->getDelegate()->getStyle('C5:D5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('C5:D5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('I5:J5');
                $sheet->setCellValue('I5', "ចំណាយសរុប");
                $sheet->getDelegate()->getStyle('I5:J5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('I5:J5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('K5:L5');
                $sheet->setCellValue('K5', "ប្រាក់ទទួលបានមុខកាត់ពន្ធ (៥០%)");
                $sheet->getDelegate()->getStyle('K5:L5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('K5:L5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('M5:N5');
                $sheet->setCellValue('M5', "អត្រាពន្ធកាត់ទុក 20%");
                $sheet->getDelegate()->getStyle('M5:N5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('M5:N5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('O5:P5');
                $sheet->setCellValue('O5', "ប្រាក់ដែលទទួលបានបន្ទាប់់ពីកាត់ពន្ធ");
                $sheet->getDelegate()->getStyle('O5:P5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('O5:P5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->getDelegate()->getStyle('A6:Q6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:Q6');

            },
        ];
    }
}
