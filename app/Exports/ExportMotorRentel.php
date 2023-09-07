<?php

namespace App\Exports;

use Carbon\Carbon;
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
    protected $totalRecord;
    protected $totalGagolineAmount;
    protected $totalAmountMotor;
    protected $totaPriceMotor;
    protected $totaPriceTaplab;
    protected $totalTaxFee;
    protected $totalAmount;

    public function __construct($export_data)
    {
        $this->totalRecord = count($export_data);
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $i++;
            $amount_real = ($value->total_gasoline * $value->total_work_day * $value->gasoline_price_per_liter);
            $this->totalGagolineAmount += $amount_real;
            $this->totalAmountMotor += $value->amount_price_engine_oil;
            $this->totaPriceMotor += $value->amount_price_motor_rentel;
            $this->totaPriceTaplab += $value->amount_price_taplab_rentel;
            // $this->totalTaxFee += (($value->amount_price_motor_rentel * $value->tax_rate) / 100);
            $this->totalAmount += $value->amount_price_engine_oil + ($value->amount_price_motor_rentel - ($value->amount_price_motor_rentel * $value->tax_rate) / 100) + ($value->amount_price_taplab_rentel - ($value->amount_price_taplab_rentel * $value->tax_rate) / 100 );
            $dataExport[] = [
                "number" => $i,
                "number_employee" => $value->MotorEmployee->number_employee,
                "employee_name_en" => $value->MotorEmployee->employee_name_en,
                "employee_gender" => $value->MotorEmployee->EmployeeGender,
                "employee_position" => $value->MotorEmployee->EmployeePosition,
                "employee_branch" => $value->MotorEmployee->EmployeeBranch,
                "start_date" => $value->start_date,
                "end_date" => $value->end_date,
                "product_year" => $value->product_year,
                "expired_year" => $value->expired_year,
                "shelt_life" => $value->shelt_life,
                "number_plate" => $value->number_plate,
                "total_gasoline" => $value->total_gasoline,
                "total_work_day" => $value->total_work_day,
                "total_gasoline_liters" => $value->total_gasoline * $value->total_work_day,
                "price_engine_oil" => number_format($amount_real, 2),
                "total_price_gasoline" => $value->amount_price_engine_oil,
                "price_motor_rentel" => $value->amount_price_motor_rentel,
                // "taplab_rentel" => $value->taplab_rentel,
                "price_taplab_rentel" => $value->amount_price_taplab_rentel,
                "tax_rate" => $value->tax_rate,
                // "taxes_on_fees" =>  ($value->amount_price_motor_rentel * $value->tax_rate) / 100,
                "amount" => $value->amount_price_engine_oil + ($value->amount_price_motor_rentel - ($value->amount_price_motor_rentel * $value->tax_rate) / 100) + ($value->amount_price_taplab_rentel - ($value->amount_price_taplab_rentel * $value->tax_rate) / 100 ),
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
                $sheet->mergeCells('A2:X2');
                $sheet->setCellValue('A2', "បញ្ជីទូទាត់ថ្លៃទិញសាំង និងប្រេងម៉ាស៊ីន");
                $sheet->getDelegate()->getStyle('A2:X2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:X2');
                $event->sheet->getDelegate()->getStyle('A2:X2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');

                $sheet->mergeCells('A3:X3');
                $sheet->setCellValue('A3', "សម្រាប់​".$month.' '."ឆ្នាំ".$year);
                $sheet->getDelegate()->getStyle('A3:X3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:X3')
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

                $sheet->getDelegate()->getStyle('A5:X5')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A5:X5');
                $sheet->getDelegate()->getStyle('A6:X6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:X6');

                

                $sheet->mergeCells('G5:H5');
                $sheet->setCellValue('G5', "កិច្ចសន្យា");
            
                $sheet->mergeCells('O5:P5');
                $sheet->setCellValue('O5', "ថ្លៃទទួលបាន");

                $event->sheet->getDelegate()->getStyle('G5:H5')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('O5:P5')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A6:X6')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $fromMerge = $this->totalRecord+6+1;
                $toMerge = $this->totalRecord+6+1;
                $sheet->mergeCells("N".$fromMerge.':O'.$toMerge);
                $sheet->setCellValue('N'.$fromMerge, "សរុប");
                $sheet->getDelegate()->getStyle("N".$fromMerge.':O'.$toMerge)->getFont()->setName('Khmer OS Muol Light')
                ->setSize(9);
                $event->sheet->getDelegate()->getStyle("N".$fromMerge.':O'.$toMerge)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //set value to body
                $sheet->setCellValue("P".$fromMerge, number_format($this->totalGagolineAmount,2));
                $sheet->getDelegate()->getStyle("P".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("P".$fromMerge);
                $sheet->setCellValue("Q".$fromMerge, number_format($this->totalAmountMotor,2));
                $sheet->getDelegate()->getStyle("Q".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("Q".$fromMerge);
                $sheet->setCellValue("R".$fromMerge, number_format($this->totaPriceMotor,2));
                $sheet->getDelegate()->getStyle("R".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("R".$fromMerge);

                $sheet->setCellValue("S".$fromMerge, number_format( $this->totaPriceTaplab,2));
                $sheet->getDelegate()->getStyle("S".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("S".$fromMerge);

                // $sheet->setCellValue("V".$fromMerge, number_format($this->totalTaxFee,2));
                // $sheet->getDelegate()->getStyle("V".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9)->setBold("V".$fromMerge);
                $sheet->setCellValue("U".$fromMerge, number_format($this->totalAmount,2));
                $sheet->getDelegate()->getStyle("U".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("U".$fromMerge);
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
                // "Taplabs",
                "ថ្លៃឈ្នួល Taplabs ដុល្លារ/USD",
                "អត្រាជាប់ពន្ធ (%)",
                // "ពន្ធលើថ្លៃឈ្នួល",
                "ប្រាក់ទទួលបានបន្ទាប់ពីដកពន្ធ",
                "សម្គាល់នៃកិច្ចសន្យា",
        ];
    }
}
