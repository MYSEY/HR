<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportFnLevelDetail implements FromCollection,  WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
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
        $type =  "";
        $requestType = [
            "1"=>__("lang.review"),
            "2"=>__("lang.review"),
            "3"=>__("lang.review"),
            "4"=>__("lang.review"),
            "5"=>__("lang.review"),
            "6"=>__("lang.review"),
            "7"=>__("lang.review"),
            "8"=>__("lang.review"),
            "9"=>__("lang.review"),
            "10"=>__("lang.review"),
        ];
        $type = [
            "0" => __("lang.general_expense"),
            "2" => __("lang.tax_expense"),
            "1" => __("lang.special_expense"),
        ];
        $reference_type = "";
        foreach ($export_data as  $key=>$item) {
            $i++;
            
            $positionViews = "";
            $num = 1;
            foreach ($item->positionReview as $value) {
                $positionViews .= $num . ". " . $value->name_english . "\n";
                $num++;
            }
            
            if ($item->reference_type == 1){
                $reference_type = "Regular Expense";
            }
            if ($item->reference_type == 2){
                $reference_type = "Irregular Expense";
            }

            $dataExport[] = [
                "number" => $i,
                "From Amount"           =>  "\t" .$item->from_amount,
                "To Amount"             =>  "\t" .$item->to_amount,
                "From Location"         =>  $item->from_location =="1" ? "Branch" : "Department",
                "Model Review"          =>  $item->modelReview ? $item->modelReview->name_english : "",
                "Request Type"          =>  $type[$item->request_type],
                "Reference Type"        =>  $reference_type,
                "Review Type"           =>  $requestType[$item->type]." ".$item->type,
                "Review Cross Department"     =>  $item->departmentView ? $item->departmentView->name_english : "",
                "Position Review"       =>  $positionViews,
                
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
            'H' => 40,      
            'I' => 40,
            'J' => 40,
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
                $drawing->setCoordinates('D1'); // Cell position
                $drawing->setWorksheet($sheet->getDelegate()); // Bind to sheet

                $sheet->getDelegate()->getStyle('A6:J6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:J6');
                $event->sheet->getStyle('A6:J6')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                 $n=6;
                if ($this->totalRecord > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':J'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }

                // block merge cells 
                $sheet->mergeCells('A2:J2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:J2')->getFont()
                ->setName('Khmer OS Muol Light')
                ->setSize(12)
                ->getColor()->setARGB('FFFF0000'); 
                $event->sheet->getDelegate()->getStyle('A2:J2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:J3');
                $sheet->setCellValue('A3', "CAMMA-FND-002 Level Review ");
                $sheet->getDelegate()->getStyle('A3:J3')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12);
                $event->sheet->getDelegate()->getStyle('A3:Z3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

               
                $event->sheet->getDelegate()->getStyle('A6:J6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
      
    public function headings(): array
    {
        return [
                "No",
                "From Amount",
                "To Amount",
                "From Location",
                "Model Review",
                "Request Type",
                "Reference Type",
                "Review Type",
                "Review Cross Department",
                "Position Review",
        ];
    }
}
