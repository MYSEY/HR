<?php

namespace App\Exports;

use App\Models\ExpenseRequestHistory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportExpenseHistories implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;

     public function __construct($export_data)
    {
        $i = 0;
        $dataExport = [];
        $status = "";
       
        foreach ($export_data as $value) {
            $i++;
            $type_of_expense = $value->expense_type == "1" ? "Regular Expense": "Irregular Expense";
            if ($value->status == "" || $value->status == "pending"){
                $status = "Pending review ".$value->review_type;
            }elseif($value->status == "pending_approve"){
                $status = "Pending approved";
            }elseif ($value->status == "rejected"){
                $status = "Rejected ".($value->review_type ? "review ".$value->review_type : "by Approved");
            }elseif($value->status == "approved"){
                $status = "Approved";
            };
            $locations = "";
            if ($value->type == "2" ) {
                if (count($value->departments)>0) {
                    $num = 1;
                    foreach ($value->departments as $key => $location) {
                        if ($location->Location) {
                            $locations .=  ($num == 1 ? $num  : ", ".$num ). ". " . $location->department->name_english . "\n";
                            $num++;
                        }
                    }
                }
            }else{
                if (count($value->locationDetails)>0) {
                    $num = 1;
                    foreach ($value->locationDetails as $key => $location) {
                        if ($location->Location) {
                            $locations .=  ($num == 1 ? $num  : ", ".$num ). ". " .$location->Location->branch_name_en."\n";
                            $num++;
                        }
                        
                    }
                }
            }
           $request_date = Carbon::createFromDate($value->date_request)->format('d-M-Y H:i');
            $dataExport[] = [
                "number"                    => $i,
                "Tracking ID"               => $value->tracking_id,
                "ស្ថានភាព"                  => $status,
                "Type of Expense"           => $type_of_expense,
                "ការបរិយាយ"                =>  $value->subject,
                "លេខយោង"                 => $value->reference,
                "ទីតាំង"                    => $locations,
                "កាលបរិច្ឆេទស្នើសុំ"            => $request_date,
                "amount_usd1"                => "\t" . $value->ge_cost_material_usd,
                "amount_kh1"                 => "\t" . $value->ge_cost_material_riel,
                "amount_usd2"                => "\t" . $value->ge_cost_lso_usd,
                "amount_kh2"                 => "\t" . $value->ge_cost_lso_riel,
                "amount_usd3"                => "\t" . $value->ge_total_cost_usd,
                "amount_kh3"                 => "\t" . $value->ge_total_cost_riel,
                "amount_usd4"                => "\t" . $value->ge_tax_usd,
                "amount_kh4"                 => "\t" . $value->tax_riel,
                "amount_usd5"                => "\t" . $value->ge_tax_fringe_benefit_usd,
                "amount_kh5"                 => "\t" . $value->tax_fringe_benefit_riel,
                "amount_usd6"                => "\t" . $value->ge_vat_reverse_charge_usd,
                "amount_kh6"                 => "\t" . $value->vat_reverse_charge_riel,
                "amount_usd7"                => "\t" . $value->ge_total_amount_usd,
                "amount_kh7"                 => "\t" . $value->ge_total_amount_riel,
                "លក្ខខណ្ឌទូទាត់"              => $value->payment_term,
                "មូលហេតុ"                  => $value->reason,
               
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

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:X2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:X2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:X2');
                $event->sheet->getDelegate()->getStyle('A2:X2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');

                $sheet->mergeCells('A3:X3');
                $sheet->setCellValue('A3', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A3:X3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:Z3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:D4');
                $sheet->setCellValue('A4', "ប្រវត្តិចំណាយ");
                $sheet->getDelegate()->getStyle('A4:D4')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setUnderline('A4:D4');
                $event->sheet->getDelegate()->getStyle('A4:D4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $sheet->getDelegate()->getStyle('G6:H6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9);
                $sheet->getDelegate()->getStyle('O6:P6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9);

                $sheet->getDelegate()->getStyle('A5:AAA5')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A5:AA5');
                $sheet->getDelegate()->getStyle('A6:AAA6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:AAA6');

                $sheet->mergeCells('I5:J5');
                $sheet->setCellValue('I5', "ថ្លៃទំនិញឬសម្ភារៈ");
                $event->sheet->getDelegate()->getStyle('I5:J5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('K5:L5');
                $sheet->setCellValue('K5', "ថ្លៃពលកម្ម/សេវា/ផ្សេងៗ");
                $event->sheet->getDelegate()->getStyle('K5:L5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('M5:N5');
                $sheet->setCellValue('M5', "សរុបចំណាយ (១+២)");
                $event->sheet->getDelegate()->getStyle('M5:N5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('O5:P5');
                $sheet->setCellValue('O5', "ពន្ធកាត់ទុក");
                $event->sheet->getDelegate()->getStyle('O5:P5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('Q5:R5');
                $sheet->setCellValue('Q5', "ឬពន្ធលើអត្ថប្រយោជន៍បន្ថែម/ប្រាក់បៀវត្ស");
                $event->sheet->getDelegate()->getStyle('Q5:R5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('S5:T5');
                $sheet->setCellValue('S5', "អាករជំនួស (VAT Reverse Charge) ១០%");
                $event->sheet->getDelegate()->getStyle('S5:T5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('U5:V5');
                $sheet->setCellValue('U5', "បើកជូនអ្នកផ្គត់ផ្គង់ (៣) ឬ (៣-(៤+៥))");
                $event->sheet->getDelegate()->getStyle('U5:V5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getDelegate()->getStyle('A6:X6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
      
    public function headings(): array
    {
        return [
                "ល",
                "Tracking ID" ,
                "ស្ថានភាព",
                "Type of Expense",
                "ការបរិយាយ",
                "លេខយោង",
                "ទីតាំង",
                "កាលបរិច្ឆេទស្នើសុំ",
                "ចំនួនទឹកប្រាក់ ដុល្លារ",
                "ចំនួនទឹកប្រាក់ ខ្មែរ",
                "ចំនួនទឹកប្រាក់ ដុល្លារ",
                "ចំនួនទឹកប្រាក់ ខ្មែរ",
                "ចំនួនទឹកប្រាក់ ដុល្លារ",
                "ចំនួនទឹកប្រាក់ ខ្មែរ",
                "ចំនួនទឹកប្រាក់ ដុល្លារ",
                "ចំនួនទឹកប្រាក់ ខ្មែរ",
                "ចំនួនទឹកប្រាក់ ដុល្លារ",
                "ចំនួនទឹកប្រាក់ ខ្មែរ",
                "ចំនួនទឹកប្រាក់ ដុល្លារ",
                "ចំនួនទឹកប្រាក់ ខ្មែរ",
                "ចំនួនទឹកប្រាក់ ដុល្លារ",
                "ចំនួនទឹកប្រាក់ ខ្មែរ",
                "លក្ខខណ្ឌទូទាត់",
                "មូលហេតុ",
        ];
    }
}
