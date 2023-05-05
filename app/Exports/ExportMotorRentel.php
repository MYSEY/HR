<?php

namespace App\Exports;

use App\Models\MotorRentel;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;

class ExportMotorRentel implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{

    protected $export_datas;

    public function __construct($export_data)
    {
        $this->export_datas = $export_data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->export_datas;
        $i = 0;
        $dataExport = [];
        foreach ($data as $value) {
            $i++;
            $dataExport[] = [
                "number" => $i,
                "number_employee" => $value->MotorEmployee->number_employee,
                "employee_name_en" => $value->MotorEmployee->employee_name_en,
                "employee_gender" => $value->MotorEmployee->EmployeeGender,
                "employee_position" => $value->MotorEmployee->EmployeePosition,
                "employee_branch" => $value->MotorEmployee->EmployeeBrnach,
                "start_date" => $value->start_date,
                "end_date" => $value->end_date,
                "product_year" => $value->product_year,
                "expired_year" => $value->expired_year,
                "shelt_life" => $value->shelt_life,
                "number_plate" => $value->number_plate,
                "total_gasoline" => $value->total_gasoline,
                "total_work_day" => $value->total_work_day,
                "total_gasoline_liters" => $value->total_gasoline * $value->total_work_day,
                "price_engine_oil" => number_format($value->total_gasoline * $value->total_work_day * $value->gasoline_price_per_liter, 2),
                "total_price_gasoline" => $value->price_engine_oil,
                "price_motor_rentel" => $value->price_motor_rentel,
                "tax_rate" => $value->tax_rate,
                "taxes_on_fees" =>  ($value->price_motor_rentel * $value->tax_rate) / 100,
                "amount" => $value->price_motor_rentel - ($value->price_motor_rentel * $value->tax_rate) / 100,
            ];
        }
        return new Collection([
            $dataExport
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
        ];
    }


    public function registerEvents(): array {
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                $sheet->mergeCells('A2:v2');
                $sheet->setCellValue('A2', "បញ្ជីទូទាត់ថ្លៃទិញសាំង និងប្រេងម៉ាស៊ីន");
                $sheet->getDelegate()->getStyle('A2:V2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:V2');

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');

                $sheet->mergeCells('A3:V3');
                $sheet->setCellValue('A3', "សម្រាប់​".$month.' '."ឆ្នាំ".$year);
                $sheet->getDelegate()->getStyle('A3:V3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10);

                $sheet->mergeCells('A4:D4');
                $sheet->setCellValue('A4', "ការិយាល័យកណ្ដាល");
                $sheet->getDelegate()->getStyle('A4:D4')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setUnderline('A4:D4');
                
                // set font name header table
                $sheet->getDelegate()->getStyle('G6:H6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9);
                $sheet->getDelegate()->getStyle('O6:P6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9);

                $sheet->getDelegate()->getStyle('A5:V5')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A5:V5');
                $sheet->getDelegate()->getStyle('A6:V6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:V6');

                

                $sheet->mergeCells('G5:H5');
                $sheet->setCellValue('G5', "កិច្ចសន្យា");
            
                $sheet->mergeCells('O5:P5');
                $sheet->setCellValue('O5', "ថ្លៃទទួលបាន");

                $event->sheet->getDelegate()->getStyle('A2:V2')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A3:V3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A4:D4')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('G5:H5')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('O5:P5')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A6:V6')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
      
    public function headings(): array
    {
        return [
                "ល",
                "ប័ណ្ណ ការងារ" ,
                "នាម និងគោត្តនាម",
                "ភេទ",
                "តួនាទី",
                "ទីតាំងការងារ",
                "ថ្ងៃចាប់ផ្តើម",
                "ថ្ងៃបញ្ចប់",
                "ឆ្នាំផលិត",
                "ឆ្នាំផុតកំណត់",
                "អាយុកាលប្រើប្រាស់រួច",
                "ស្លាកលេខ",
                "សាំងផ្តល់ ជូន(L)",
                "ចំនួនថ្ងៃបានធ្វើការ",
                "ចំនួនលីត្រ",
                "ចំនួនជារៀល",
                "ថ្លៃទិញប្រេងម៉ាស៊ីន",
                "ថ្លៃឈ្នួលម៉ូតូ ដុល្លារ/USD",
                "អត្រាជាប់ពន្ធ",
                "ពន្ធលើថ្លៃឈ្នួល",
                "ប្រាក់ទទួលបានបន្ទាប់ពីដកពន្ធ",
                "សម្គាល់នៃកិច្ចសន្យា",
        ];
    }
}
