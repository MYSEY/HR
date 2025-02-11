<?php

namespace App\Exports;

use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportTrainingDetailStaff implements FromCollection,  WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{

    protected $export_datas;
    public function __construct($export_data)
    {
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $training) {
            $i++;
            foreach ($training->employees as $key => $emp) {
                $dataExport[] = [
                    "training_id" => $training->id,
                    "employee_id" => $emp->number_employee,
                    "name_Kh" => $emp->employee_name_kh,
                    "name_en" => $emp->employee_name_en,
                    "gender" => $emp->EmployeeGender,
                ];
            }
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
        // return Training::all();
    }

    public function startCell(): string
    {
        return 'A4';
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:S2');
                $sheet->setCellValue('A2', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A2:S2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:S2');
                $event->sheet->getDelegate()->getStyle('A2:S2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $sheet->mergeCells('A3:S3');
                $sheet->setCellValue('A3', "Staff Training");
                $sheet->getDelegate()->getStyle('A3:S3')->getFont()->setName('Arial')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:S3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,      
            'C' => 20,      
            'D' => 10,      
            'E' => 30,      
        ];
    }
    public function headings(): array
    {
        return [
                "training_id",
                "employee_id",
                "Name Kh",
                "Name En",
                "Gender",
        ];
    }
}
