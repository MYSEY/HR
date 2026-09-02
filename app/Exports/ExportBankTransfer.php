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
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportBankTransfer implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalAmount;
    protected $totalFee;
    protected $num;

    public function __construct($export_data)
    {
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $this->totalAmount += $value->total_salary;
            $this->totalFee +=  $value->users->bank ? $value->users->bank->fee : 0;
            $i++;
            $this->num = $i;
            $dataExport[] = [
                "number" => $i,
                "employee_name_en" => $value->users->employee_name_kh,
                "employee_gender" => $value->users->employee_name_en,
                "account_number" => $value->users->account_number,
                "fee" => $value->users->bank ? $value->users->bank->fee : 0,
                "total_salary" => $value->total_salary,
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
        return 'A10';
    }
    // Khmer OS Muol Light
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,      
            'C' => 20,      
            'D' => 30,      
            'E' => 10,      
            'F' => 15,      
            'G' => 15,      
            'H' => 15,      
            'I' => 10,      
            'J' => 10,      
            'K' => 10,      
            'L' => 10,      
            'M' => 15,      
            'N' => 10,      
            'O' => 10,      
            'P' => 15,      
            'Q' => 10,      
            'R' => 15,      
            'S' => 10,      
            'T' => 10,      
            'U' => 15,      
            'V' => 10,
            'W' => 10,
            'X' => 10,
        ];
    }


    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:G2');
                $sheet->setCellValue('A2', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A2:G2')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A2:G2');
                $event->sheet->getDelegate()->getStyle('A2:G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $monthly = Carbon::now()->format('M');
                $sheet->mergeCells('A3:G3');
                $sheet->setCellValue('A3', "Payroll Statement (…......".$monthly.".........)");
                $sheet->getDelegate()->getStyle('A3:G3')->getFont()->setName('Arial')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:G3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:G4');
                $sheet->setCellValue('A4', "Please kindly transfer from account number 3100-02-146868-68 to CAMMA Microfinanace Limited. Employees as below:");
                $sheet->getDelegate()->getStyle('A4:G4')->getFont()->setName('Arial')->setSize(10);

                $sheet->setCellValue("B5", "Payroll Amount");
                $sheet->getDelegate()->getStyle("B5")->getFont()->setName('Arial')->setSize(9);

                $sheet->setCellValue("D5", $this->totalAmount);
                $sheet->getDelegate()->getStyle("D5")->getFont()->setName('Arial')->setSize(9)->setBold("D5");

                $sheet->setCellValue("B6", "Payroll Service");
                $sheet->getDelegate()->getStyle("B6")->getFont()->setName('Arial')->setSize(9);

                $sheet->setCellValue("D6", $this->totalFee);
                $sheet->getDelegate()->getStyle("D6")->getFont()->setName('Arial')->setSize(9)->setBold("D6");

                $sheet->setCellValue("B7", "Local Fee ");
                $sheet->getDelegate()->getStyle("B7")->getFont()->setName('Arial')->setSize(9);

                $sheet->setCellValue("B8", "Total pay");
                $sheet->getDelegate()->getStyle("B8")->getFont()->setName('Arial')->setSize(9);
                $sheet->setCellValue("D8", $this->totalAmount+$this->totalFee);
                $sheet->getDelegate()->getStyle("D8")->getFont()->setName('Arial')->setSize(9)->setBold("D8");

                $sheet->setCellValue("B9", "Fee charge deduce from main account");
                $sheet->getDelegate()->getStyle("B9")->getFont()->setName('Arial')->setSize(9);


                $sheet->setCellValue("F8", "Valid Date : ( ......./......../........ )");
                $sheet->getDelegate()->getStyle("F8")->getFont()->setName('Arial')->setSize(9);

                $sheet->setCellValue("F9", "Valid Time : ( ......... )");
                $sheet->getDelegate()->getStyle("F9")->getFont()->setName('Arial')->setSize(9);

                $fromMerge = $this->num+11;
                $sheet->mergeCells('A'.$fromMerge.':D'.$fromMerge);
                $sheet->setCellValue('A'.$fromMerge, "Total Amount");
                $sheet->getDelegate()->getStyle('A'.$fromMerge.':D'.$fromMerge)->getFont()->setName('Arial')->setSize(10)->setBold("A".$fromMerge.":D".$fromMerge);
                $event->sheet->getDelegate()->getStyle('A'.$fromMerge.':D'.$fromMerge)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue("E".$fromMerge, $this->totalFee);
                $sheet->getDelegate()->getStyle("E".$fromMerge)->getFont()->setName('Arial')->setSize(9)->setBold("E".$fromMerge);

                $sheet->setCellValue("F".$fromMerge, $this->totalAmount);
                $sheet->getDelegate()->getStyle("F".$fromMerge)->getFont()->setName('Arial')->setSize(9)->setBold("F".$fromMerge);

                $sheet->getDelegate()->getStyle('A10:G10')->getFont()->setName('Arial')->setSize(10)->setBold("A10:G10");
                $n=10;
                $event->sheet->getStyle('A'.$n.':G'.$n)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                if ($this->num > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':G'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$fromMerge.':G'.$fromMerge)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $dateMerge = $fromMerge+2;
                //Approved By
                $sheet->mergeCells('A'.$dateMerge.':B'.$dateMerge);
                $sheet->setCellValue('A'.$dateMerge, "Date: ….… / ……… / ………");
                $sheet->getDelegate()->getStyle('A'.$dateMerge.':B'.$dateMerge)->getFont()->setName('Arial')->setSize(10);
                $sheet->mergeCells('A'.($dateMerge+1).':B'.($dateMerge+1));
                $sheet->setCellValue('A'.$dateMerge+1, "Approved By");
                $sheet->getDelegate()->getStyle('A'.($dateMerge+1).':B'.($dateMerge+1))->getFont()->setName('Arial')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A'.($dateMerge+1).':B'.($dateMerge+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A'.($dateMerge+4).':B'.($dateMerge+4));
                $sheet->setCellValue('A'.($dateMerge+4), "Mrs Nuth Seila");
                $sheet->getDelegate()->getStyle('A'.($dateMerge+4).':B'.($dateMerge+4))->getFont()->setName('Arial')->setSize(10)->setBold('A'.($dateMerge+4).':B'.($dateMerge+4));
                $event->sheet->getDelegate()->getStyle('A'.($dateMerge+4).':B'.($dateMerge+4))->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->mergeCells('A'.($dateMerge+5).':B'.($dateMerge+5));
                $sheet->setCellValue('A'.$dateMerge+5, "Deputy Head of Accounting and Finance Department.");
                $sheet->getDelegate()->getStyle('A'.($dateMerge+5).':B'.($dateMerge+5))->getFont()->setName('Arial')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A'.($dateMerge+5).':B'.($dateMerge+5))->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //Verified By
                $sheet->mergeCells('C'.$dateMerge.':D'.$dateMerge);
                $sheet->setCellValue('C'.$dateMerge, "Date: ….… / ……… / ………");
                $sheet->getDelegate()->getStyle('C'.$dateMerge.':D'.$dateMerge)->getFont()->setName('Arial')->setSize(10);
                $event->sheet->getDelegate()->getStyle('C'.$dateMerge.':D'.$dateMerge)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->mergeCells('C'.($dateMerge+1).':D'.($dateMerge+1));
                $sheet->setCellValue('C'.$dateMerge+1, "Verified By");
                $sheet->getDelegate()->getStyle('C'.($dateMerge+1).':D'.($dateMerge+1))->getFont()->setName('Arial')->setSize(10);
                $event->sheet->getDelegate()->getStyle('C'.($dateMerge+1).':D'.($dateMerge+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('C'.($dateMerge+4).':D'.($dateMerge+4));
                $sheet->setCellValue('C'.($dateMerge+4), "Mr Pheng Putmetrey");
                $sheet->getDelegate()->getStyle('C'.($dateMerge+4).':D'.($dateMerge+4))->getFont()->setName('Arial')->setSize(10)->setBold('C'.($dateMerge+4).':D'.($dateMerge+4));
                $event->sheet->getDelegate()->getStyle('C'.($dateMerge+4).':D'.($dateMerge+4))->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->mergeCells('C'.($dateMerge+5).':D'.($dateMerge+5));
                $sheet->setCellValue('C'.$dateMerge+5, "Head of HR and Admin Department.");
                $sheet->getDelegate()->getStyle('C'.($dateMerge+5).':D'.($dateMerge+5))->getFont()->setName('Arial')->setSize(10);
                $event->sheet->getDelegate()->getStyle('C'.($dateMerge+5).':D'.($dateMerge+5))->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //Prepare By
                $sheet->mergeCells('F'.$dateMerge.':G'.$dateMerge);
                $sheet->setCellValue('F'.$dateMerge, "Date: ….… / ……… / ………");
                $sheet->getDelegate()->getStyle('F'.$dateMerge.':G'.$dateMerge)->getFont()->setName('Arial')->setSize(10);
                $sheet->mergeCells('F'.($dateMerge+1).':G'.($dateMerge+1));
                $sheet->setCellValue('F'.$dateMerge+1, "Prepare By");
                $sheet->getDelegate()->getStyle('F'.($dateMerge+1).':G'.($dateMerge+1))->getFont()->setName('Arial')->setSize(10);
                $event->sheet->getDelegate()->getStyle('F'.($dateMerge+1).':G'.($dateMerge+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('F'.($dateMerge+4).':G'.($dateMerge+4));
                $sheet->setCellValue('F'.($dateMerge+4), "Mr. Chhor Oudam");
                $sheet->getDelegate()->getStyle('F'.($dateMerge+4).':G'.($dateMerge+4))->getFont()->setName('Arial')->setSize(10)->setBold('F'.($dateMerge+4).':G'.($dateMerge+4));
                $event->sheet->getDelegate()->getStyle('F'.($dateMerge+4).':G'.($dateMerge+4))->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->mergeCells('F'.($dateMerge+5).':G'.($dateMerge+5));
                $sheet->setCellValue('F'.$dateMerge+5, "Senior Personnel & Recruitement Manager.");
                $sheet->getDelegate()->getStyle('F'.($dateMerge+5).':G'.($dateMerge+5))->getFont()->setName('Arial')->setSize(10);
                $event->sheet->getDelegate()->getStyle('F'.($dateMerge+5).':G'.($dateMerge+5))->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            },
        ];
    }
      
    public function headings(): array
    {
        return [
                "No.",
                "Name in Khmer" ,
                "Name in English",
                "Bank Account Number",
                "Fee",
                "Amounts",
                "Other",
        ];
    }
}
