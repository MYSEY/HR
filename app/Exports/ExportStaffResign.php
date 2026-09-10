<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportStaffResign implements FromCollection,WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;
    public function __construct($export_data)
    {
        $dataExport = [];
        $this->totalRecord = count($export_data);
        
        foreach ($export_data as $users) {
            $dataExport[] = [
                "number_employee" => $users->number_employee,
                "employee_name_kh" => $users->employee_name_kh,
                "employee_name_en" => $users->employee_name_en,
                "gender" => $users->EmployeeGender,
                "position_kh" => $users->position->name_khmer,
                "position_en" => $users->position->name_english,
                "branch" => $users->EmployeeBranch,
                "date_of_commencement" => $users->date_of_commencement ? Carbon::createFromDate($users->date_of_commencement)->format('d-m-Y') : "",
                'resign_date'=> $users->resign_date ? Carbon::createFromDate($users->resign_date)->format('d-m-Y'): "",
                'resign_reason'=> $users->EmployeeResignReason == null ? $users->resign_reason : $users->EmployeeResignReason,
                'performance_note'=>$users->performanceNote ? $users->performanceNote->name_english : "",
                'remark'=> $users->remark ? $users->remark : "",
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
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // Add the logo to the sheet
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Camma Logo');
                $drawing->setPath(public_path('admin/img/logo/commalogo1.png')); // Correct path
                $drawing->setHeight(100); // Adjust size as needed
                $drawing->setCoordinates('B1'); // Cell position
                $drawing->setWorksheet($sheet->getDelegate()); // Bind to sheet

                $sheet->getDelegate()->getStyle('A4:L4')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A4:L4');
                $event->sheet->getStyle('A4:L4')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // block merge cells 
                $sheet->mergeCells('A2:L2');
                $sheet->setCellValue('A2', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A2:L2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:L2');
                $event->sheet->getDelegate()->getStyle('A2:L2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:L3');
                $sheet->setCellValue('A3', "Staff resign report");
                $sheet->getDelegate()->getStyle('A3:L3')->getFont()->setName('Arial')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:L3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                                //** block body */ 
                $n=4;
                if ($this->totalRecord > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':L'.$n)->applyFromArray([
                            'font' => [
                                'name' => 'Khmer OS Battambang', // Font name
                                'size' => 9, // Font size
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
            },
        ];
    }
    public function startCell(): string
    {
        return 'A4';
    }
    // Khmer OS Muol Light
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 30,
            'F' => 20,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 50,
            'K' => 50,
            'L' => 50,
        ];
    }
    public function headings(): array
    {
        return [
            "Employee ID",
            "Name Khmer",
            "Name English",
            "Gender",
            "Position Khmer",
            "Position English",
            "Location",
            "Join Date",
            "Resigned Date",
            "Reason of Resign",
            'Performance Note',
            "Remark",
        ];
    }
}
