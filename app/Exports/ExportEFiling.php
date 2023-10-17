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

class ExportEFiling implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;
    protected $totalBasicSalary;
    protected $totalBaseSalaryReceived;

    public function __construct($export_data)
    {
        $this->totalRecord = count($export_data);
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $i++;
            $this->totalBasicSalary += $value->users->basic_salary;
            $this->totalBaseSalaryReceived += $value->base_salary_received_usd;
            $dataExport[] = [
                "number" => $i,
                "id_card_number" => $value->users->id_card_number ? $value->users->id_card_number : "",
                "TID" => "",
                "passport" => $value->users->identity_number,
                // "number_employee" => $value->users->number_employee,
                "last_name_kh" => $value->users->last_name_kh,
                "first_name_kh" => $value->users->first_name_kh,
                "last_name_en" => $value->users->last_name_en,
                "first_name_en" => $value->users->first_name_en,
                "gender" => $value->users->EmployeeGender,
                "nationality" => $value->users->nationality? $value->users->nationality : "",
                "ethnicity"=> $value->users->ethnicity,
                "date_of_birthday" => $value->users->DOB,
                "phone_number" => $value->users->phone_number,
                "email" => $value->users->email ? $value->users->email : "",
                "positiontype" => $value->users->type_of_employees_nssf,
                "position" => $value->users == null ? '' : $value->users->EmployeePosition,
                "spouse" => $value->spouse_nssf == null ? '' : $value->users->spouse_nssf,
                "total_child" => $value->users->TotalChild,
                "basic_salary" => $value->users->basic_salary,
                "additional_benefits"=> "",
                "base_salary_received_usd" => $value->base_salary_received_usd,
                "payment_date" => Carbon::parse($value->payment_date)->format('d-M-Y'),
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
            'D' => 10,      
            'E' => 30,      
            'F' => 30,      
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
                // $sheet->mergeCells('A2:Z2');
                // $sheet->setCellValue('A2', "បញ្ជីទូទាត់ថ្លៃទិញសាំង និងប្រេងម៉ាស៊ីន");
                // $sheet->getDelegate()->getStyle('A2:Z2')->getFont()->setName('Khmer OS Muol Light')
                // ->setSize(12)->setUnderline('A2:Z2');
                // $event->sheet->getDelegate()->getStyle('A2:Z2')
                // ->getAlignment()
                // ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $month = Carbon::now()->format('M');
                // $year = Carbon::now()->format('Y');

                // $sheet->mergeCells('A3:Z3');
                // $sheet->setCellValue('A3', "សម្រាប់ ​".$month.' '."ឆ្នាំ".$year);
                // $sheet->getDelegate()->getStyle('A3:Z3')->getFont()->setName('Khmer OS Freehand')
                // ->setSize(10);
                // $event->sheet->getDelegate()->getStyle('A3:Z3')
                //             ->getAlignment()
                //             ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:B4');
                $sheet->setCellValue('A4', "លេខសម្គាល់អត្តសញ្ញាណ៖");
                $sheet->getDelegate()->getStyle('A4:B4')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10);
                // ->setUnderline('A4:B4');
                $event->sheet->getDelegate()->getStyle('A4:B4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('D4:E4');
                $sheet->setCellValue('D4', "កាលបរិច្ឆេទ៖");
                $sheet->getDelegate()->getStyle('D4:E4')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10);
                // ->setUnderline('D4:E4');
                $event->sheet->getDelegate()->getStyle('D4:E4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('B5:D5');
                $sheet->setCellValue('B5', "អត្តលេខសម្គាល់បុគ្គល*");
                $sheet->getDelegate()->getStyle('B5:D5')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10);
                // ->setUnderline('B5:D5');
                $event->sheet->getDelegate()->getStyle('B5:D5')
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

                $sheet->mergeCells('F5:L5');
                $sheet->setCellValue('F5', "ព័ត៌មានរូបវន្តបុគ្គល (បើបំពេញលេខTIDរួច មិនតម្រូវឱ្យបំពេញព័ត៌មាននេះទៀតទេ)");

                $event->sheet->getDelegate()->getStyle('F5:L5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                $fromMerge = $this->totalRecord+6+1;
                $toMerge = $this->totalRecord+6+1;
                $sheet->mergeCells("Q".$fromMerge.':R'.$toMerge);
                $sheet->setCellValue('Q'.$fromMerge, "សរុប");
                $sheet->getDelegate()->getStyle("Q".$fromMerge.':R'.$toMerge)->getFont()->setName('Khmer OS Muol Light')
                            ->setSize(9);
                
                $event->sheet->getDelegate()->getStyle("Q".$fromMerge.':R'.$toMerge)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //set value to body
                $sheet->setCellValue("S".$fromMerge, number_format($this->totalBasicSalary,2));
                $sheet->getDelegate()->getStyle("S".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("S".$fromMerge);

                $sheet->setCellValue("T".$fromMerge, number_format(0));
                $sheet->getDelegate()->getStyle("T".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("T".$fromMerge);

                $sheet->setCellValue("U".$fromMerge, number_format($this->totalBaseSalaryReceived,2));
                $sheet->getDelegate()->getStyle("U".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("U".$fromMerge);
            },
        ];
    }
      
    public function headings(): array
    {
        return [
                "ល.រ*",
                "លេខអត្តសញ្ញាណប័ណ្ណ" ,
                "TID",
                "លិខិតឆ្លងដែន",
                "នាមត្រកូល(ខ្មែរ)*",
                "នាមខ្លួន(ខ្មែរ)*",
                "នាមត្រកូល(ឡាតាំង)*",
                "នាមខ្លួន(ឡាតាំង)*",
                "ភេទ*",
                "សញ្ជាតិ*",
                "ជនជាតិ*",
                "ថ្ងៃខែឆ្នាំកំណើត*",
                "លេខទូរស័ព្ទ",
                "សារអេឡិកត្រូនិក",
                "ប្រភេទនិយោជិត*",
                "មុខតំណែង*",
                "សហព័ទ្ធ*",
                "កូនក្នុងបន្ទុក*",
                "ប្រាក់បៀវត្ស*",
                "ប្រាក់អត្ថប្រយោជន៍បន្ថែម",
                "ប្រាក់បៀវត្សមិនជាប់ពន្ធ",
                "កាលបរិច្ឆេទទូទាត់",
        ];
    }
}
