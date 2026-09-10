<?php

namespace App\Exports;

use App\Models\Performance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportPerformance implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;
    protected $filter;
    

     public function __construct($export_data, $filter)
    {
        $this->totalRecord = count($export_data);
        $this->filter = $filter;
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $i++;
            $dataExport[] = [
                "number"            =>$i,
                "employee_id"       =>$value->number_employee,
                "employee_name"     =>$value->employee_name_kh,
                "gender"            =>$value->gender_name_khmer,
                "position"          =>$value->positions_name_khmer,
                "location"          =>$value->branch_name_kh,
                "department"        =>$value->dep_name_khmer,
                "joined_date"       =>$value->date_of_commencement,
                "from_date"         =>$value->from_date,
                "to_date"           =>$value->to_date,
                "kip"               =>$value->type,
                "total_weight"      =>$value->total_weight,
                "approve_by"        =>$value->approve_employee_name_kh,
                "approve_date"      =>$value->approved_date,
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
        ];
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

                $sheet->getDelegate()->getStyle('A6:N6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:N6');
                $event->sheet->getStyle('A6:N6')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // block merge cells 
                $sheet->mergeCells('A2:N2');
                $sheet->setCellValue('A2', "របាយការណ៍ផែនការងាររបស់បុគលិកប្រចាំឆ្នាំ");
                $sheet->getDelegate()->getStyle('A2:N2')->getFont()
                ->setName('Khmer OS Muol Light')
                ->setSize(12)
                ->getColor()->setARGB('FFFF0000'); 
                $event->sheet->getDelegate()->getStyle('A2:N2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $report_date = Carbon::createFromDate()->format('Y');
                $sheet->mergeCells('A3:N3');
                $sheet->setCellValue('A3', "សម្រាប់ឆ្នាំ". $report_date);
                $sheet->getDelegate()->getStyle('A3:N3')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12);
                $event->sheet->getDelegate()->getStyle('A3:Z3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

               
                $event->sheet->getDelegate()->getStyle('A6:N6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //** block body */ 
                $n=6;
                if ($this->totalRecord > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':N'.$n)->applyFromArray([
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
      
    public function headings(): array
    {
        return [
                "ល.រ",
                "ប័ណ្ណការងារ",
                "នាម និង គោត្តនាម",
                "ភេទ",
                "មុខងារ",
                "ទីតាំងការងារ",
                "នាយកដ្ឋាន",
                "ថ្ងៃចូលធ្វើការ",
                "From Date",
                "To Date",
                "Kip",
                "Total Weight",
                "Approve By",
                "Approve Date",
        ];
    }
}
