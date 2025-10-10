<?php

namespace App\Exports;

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

class ExportPA implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;
    protected $filter;


     public function __construct($export_data)
    {
        $this->totalRecord = count($export_data);
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $i++;
            $score = $value->total_score_direct_chairman;
            if ($score === 0.00) {
                $overallResults = '';
            } else if ($score < 2) {
                $overallResults = 'ខ្សោយ_(ក្រោមផែនការ២០%)';
            } else if ($score <= 2.99) {
                $overallResults = 'ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)';
            } else if ($score <= 3.99) {
                $overallResults = 'ធម្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
            } else if ($score <= 4.99) {
                $overallResults = 'ល្អ_(អនុវត្តន៍ការងារលើសផែនការងារ១០%)';
            } else {
                $overallResults = 'ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)';
            }

            $dataExport[] = [
                "number"            =>$i,
                "employee_id"       =>$value->number_employee,
                "employee_name"     =>$value->employee_name_kh,
                "gender"            =>$value->gender_name_khmer,
                "position"          =>$value->positions_name_kh,
                "location"          =>$value->branch_name_kh,
                "department"        =>$value->dep_name_kh,
                "joined_date"       =>$value->date_of_commencement,
                "from_date"         =>$value->from_date,
                "to_date"           =>$value->to_date,
                "type"              =>$value->type,
                "score"             =>$value->total_score,
                "dersonal_staff"    =>$value->total_score_live_staff,
                "dersonal_director" =>$value->total_score_direct_chairman,
                "overall_results"   =>$overallResults,
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
            'O' => 40,
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

                $sheet->getDelegate()->getStyle('A6:O6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:O6');
                $event->sheet->getStyle('A6:O6')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // block merge cells 
                $sheet->mergeCells('A2:O2');
                $sheet->setCellValue('A2', "របាយការណ៍ទម្រង់វាយតម្លៃការងាររបស់បុគ្គលិកប្រចាំឆ្នាំ");
                $sheet->getDelegate()->getStyle('A2:O2')->getFont()
                ->setName('Khmer OS Muol Light')
                ->setSize(12)
                ->getColor()->setARGB('FFFF0000'); 
                $event->sheet->getDelegate()->getStyle('A2:O2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $report_date = Carbon::createFromDate()->format('Y');
                $sheet->mergeCells('A3:O3');
                $sheet->setCellValue('A3', "សម្រាប់ឆ្នាំ". $report_date);
                $sheet->getDelegate()->getStyle('A3:O3')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12);
                $event->sheet->getDelegate()->getStyle('A3:Z3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $event->sheet->getDelegate()->getStyle('A6:O6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //** block body */ 
                $n=6;
                if ($this->totalRecord > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':O'.$n)->applyFromArray([
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
                "ទីតាំងការងារ",
                "នាយកដ្ឋាន",
                "មុខងារ",
                "ថ្ងៃចូលធ្វើការ",
                "From Date",
                "To Date",
                "ប្រភេទ",
                "ពិន្ទុ",
                "បុគ្គលិកផ្ទាល់",
                "ប្រធានផ្ទាល់",
                "លទ្ធផលរួម",
        ];
    }
}
