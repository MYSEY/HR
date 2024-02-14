<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportLeave implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{

    protected $export_datas;
    protected $totalRecord;

    public function __construct($export_data)
    {
        $this->totalRecord = count($export_data);
        $i = 0;
        $dataExport = [];
        
        foreach ($export_data as $value) {
           
            $i++;
            $join_date = Carbon::createFromDate($value->employee->date_of_commencement)->format('d-m-Y');
            $default_annual_leave = $value->default_annual_leave - $value->total_annual_leave;
            $total_annual_leave =  $value->total_annual_leave;
            $default_sick_leave = $value->default_sick_leave - $value->total_sick_leave;
            $total_sick_leave =  $value->total_sick_leave;
            $default_special_leave = $value->default_special_leave -$value->total_special_leave;
            $total_special_leave =  $value->total_special_leave;
            $default_unpaid_leave = $value->default_unpaid_leave - $value->total_unpaid_leave;
            $total_unpaid_leave =  $value->total_unpaid_leave ;
            $year1 = $value->year_1 ? $value->year_1 : "0";
            $year2 = $value->year_2 ? $value->year_2 : "0";
            $year3 = $value->year_3 ? $value->year_3 : "0";
            $dataExport[] = [
                "number"                            => $i,
                "employee_name"                     => $value->employee->employee_name_en,
                "department"                        => $value->employee->department->name_english,
                "location"                          => $value->employee->branch->branch_name_en,
                "join_date"                         => $join_date,
                "day_taken1"                        => "$default_annual_leave",          
                "balance1"                          => $total_annual_leave,         
                "day_taken2"                        => "$default_sick_leave",           
                "balance2"                          => $total_sick_leave,         
                "day_taken3"                        => "$default_special_leave",          
                "balance3"                          => $total_special_leave,        
                "day_taken4"                        => "$default_unpaid_leave",           
                "balance4"                          => $total_unpaid_leave,         
                "year_1"                            => $year1,
                "year_2"                            => $year2,        
                "year_3"                            => $year3,
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
        ];
    }

    public function headings(): array
    {
        return [
                "#",
                "Employee Name" ,
                "Department",
                "Location",
                "Join Date",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Year 1",
                "Year 2",
                "Year 3",
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:P2');
                $sheet->setCellValue('A2', "LEAVE APPLICATION AND RECORD");
                $sheet->getDelegate()->getStyle('A2:P2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setBold('A2:P2')->setUnderline('A2:P2');
                $event->sheet->getDelegate()->getStyle('A2:P2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');

                $sheet->mergeCells('A3:P3');
                $sheet->setCellValue('A3', "For the year of ".$year);
                $sheet->getDelegate()->getStyle('A3:P3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10)->setBold('A3:P3');
                $event->sheet->getDelegate()->getStyle('A3:P3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:D4');
                $sheet->setCellValue('A4', "ការិយាល័យកណ្ដាល");
                $sheet->getDelegate()->getStyle('A4:D4')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setUnderline('A4:D4');
                $event->sheet->getDelegate()->getStyle('A4:D4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $sheet->getDelegate()->getStyle('G6:H6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9);
                $sheet->getDelegate()->getStyle('O6:P6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9);

                $sheet->getDelegate()->getStyle('A5:Z5')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A5:Z5');
                $sheet->getDelegate()->getStyle('A6:Z6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:Z6');

                $sheet->mergeCells('F5:G5');
                $sheet->setCellValue('F5', "Annual Leave");
                $event->sheet->getDelegate()->getStyle('F5:G5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                $sheet->mergeCells('H5:I5');
                $sheet->setCellValue('H5', "Sick Leave");
                $event->sheet->getDelegate()->getStyle('H5:I5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('J5:K5');
                $sheet->setCellValue('J5', "Special Leave");
                $event->sheet->getDelegate()->getStyle('J5:K5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('L5:M5');
                $sheet->setCellValue('L5', "Unpaid Leave");
                $event->sheet->getDelegate()->getStyle('L5:M5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('N5:P5');
                $sheet->setCellValue('N5', "Carried Forward Leave");
                $event->sheet->getDelegate()->getStyle('N5:P5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A6:Y6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
