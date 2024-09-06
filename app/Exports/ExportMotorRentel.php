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
    protected $totalAmountEngineOil;
    protected $totaPriceMotor;
    protected $totaMotorTaplab;
    protected $totaPriceTaplab;
    protected $totalTax;
    protected $totalTaxFee;
    protected $totalAmount;
    protected $totalAmount_usd;
    protected $resignedDate;

    public function __construct($export_data)
    {
        $this->totalRecord = count($export_data);
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $i++;
            if ($value->resigned_date) {
                $this->resignedDate = $i;
            }
            // $amount_real = round(($value->total_gasoline * $value->total_work_day * $value->gasoline_price_per_liter),-2);
            $total_motor_taplab = $value->amount_price_taplab_rentel + $value->amount_price_motor_rentel;
            $amount_tax_usd = (($value->amount_price_motor_rentel * $value->tax_rate) / 100) + (($value->amount_price_taplab_rentel * $value->tax_rate) / 100 );
            $amount_usd = round(($value->amount_price_motor_rentel - ($value->amount_price_motor_rentel * $value->tax_rate) / 100) + ($value->amount_price_taplab_rentel - ($value->amount_price_taplab_rentel * $value->tax_rate) / 100 ),2);

            $total_riels = ($value->total_gasoline * $value->total_work_day * $value->gasoline_price_per_liter);
            $amount_riels = round($total_riels,-2);

            $this->totalGagolineAmount += $amount_riels;
            $this->totalAmountEngineOil += $value->amount_price_engine_oil;
            $this->totaPriceMotor += $value->amount_price_motor_rentel;
            $this->totaPriceTaplab += $value->amount_price_taplab_rentel;
            $this->totaMotorTaplab += $total_motor_taplab;
            $this->totalTax += $value->tax_rate;
            $this->totalTaxFee += $amount_tax_usd;

            $this->totalAmount += 0;
            $this->totalAmount_usd += $amount_usd;
            $dataExport[] = [
                "number" => $i,
                "number_employee" => $value->MotorEmployee->number_employee,
                "employee_name_en" => $value->MotorEmployee->employee_name_en,
                "employee_gender" => $value->MotorEmployee->EmployeeGender,
                "employee_position" => $value->MotorEmployee->EmployeePosition,
                "employee_branch" => $value->MotorEmployee->EmployeeBranch,
                "start_date" => $value->start_date,
                "end_date" => $value->end_date,
                "body_number" => $value->body_number,
                "engine_number" => $value->engine_number,
                "number_plate" => $value->number_plate,
                "motorcycle_brand" => $value->motorcycle_brand,
                "motor_color" => $value->motor_color,
                "product_year" => $value->product_year,
                "expired_year" => $value->expired_year,
                "shelt_life" => $value->shelt_life,
                "taplab_rentel" => $value->taplab_rentel,
                "taplab_imei" => $value->taplab_imei,
                "start_date_taplab" => $value->start_date_taplab,
                "total_gasoline" => $value->total_gasoline,
                "total_work_day" => $value->total_work_day,
                "total_gasoline_liters" => $value->total_gasoline * $value->total_work_day,
                "price_engine_oil" => $amount_riels,
                "total_price_gasoline" => number_format($value->amount_price_engine_oil),
                "price_motor_rentel" => number_format($value->amount_price_motor_rentel),
                "price_taplab" => number_format($value->amount_price_taplab_rentel),
                "total_motor_taplab" => $total_motor_taplab,
                "tax_rate" => $value->tax_rate,
                "amount_riel" => $amount_tax_usd,
                "amount_usd" => $amount_usd,
                "resigned_date" =>$value->resigned_date,
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
            'Y' => 10,
            'Z' => 10,
            'AA' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AE' => 10,
        ];
    }


    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:AA2');
                $sheet->setCellValue('A2', "បញ្ជីទូទាត់ថ្លៃទិញសាំង និងប្រេងម៉ាស៊ីន");
                $sheet->getDelegate()->getStyle('A2:AA2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:AA2');
                $event->sheet->getDelegate()->getStyle('A2:AA2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');

                $sheet->mergeCells('A3:AA3');
                $sheet->setCellValue('A3', "សម្រាប់ ​".$month.' '."ឆ្នាំ".$year);
                $sheet->getDelegate()->getStyle('A3:AA3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:Z3')
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

                $sheet->getDelegate()->getStyle('A5:AAA5')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A5:AA5');
                $sheet->getDelegate()->getStyle('A6:AAA6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:AAA6');

                $sheet->mergeCells('G5:P5');
                $sheet->setCellValue('G5', "ព័ត៌មានលម្អិតឈ្នួលម៉ូតូ");
                $event->sheet->getDelegate()->getStyle('G5:P5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('Q5:S5');
                $sheet->setCellValue('Q5', "ព័ត៌មានលម្អិតឈ្នួលTablet/Ipad");
                $event->sheet->getDelegate()->getStyle('Q5:S5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                $sheet->mergeCells('V5:W5');
                $sheet->setCellValue('V5', "ថ្លៃសាំងទទួលបាន");
                $event->sheet->getDelegate()->getStyle('V5:W5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                $sheet->mergeCells('Y5:AD5');
                $sheet->setCellValue('Y5', "ថ្លៃឈ្នួល(USD)");
                $event->sheet->getDelegate()->getStyle('Y5:AD5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A6:Y6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $fromMerge = $this->totalRecord+6+1;
                $toMerge = $this->totalRecord+6+1;
                $sheet->mergeCells("V".$fromMerge.':V'.$toMerge);
                $sheet->setCellValue('V'.$fromMerge, "សរុប");
                $sheet->getDelegate()->getStyle("V".$fromMerge.':V'.$toMerge)->getFont()->setName('Khmer OS Muol Light')
                            ->setSize(9);
                            
                $sheet->setCellValue("W".$fromMerge, number_format($this->totalGagolineAmount));
                $sheet->getDelegate()->getStyle("W".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("W".$fromMerge);

                $sheet->setCellValue("X".$fromMerge, number_format($this->totalAmountEngineOil));
                $sheet->getDelegate()->getStyle("X".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("X".$fromMerge);

                $sheet->setCellValue("Y".$fromMerge, number_format($this->totaPriceMotor));
                $sheet->getDelegate()->getStyle("Y".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("Y".$fromMerge);

                $sheet->setCellValue("Z".$fromMerge, number_format( $this->totaPriceTaplab));
                $sheet->getDelegate()->getStyle("Z".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("Z".$fromMerge);

                $sheet->setCellValue("AA".$fromMerge, number_format($this->totaMotorTaplab,2));
                $sheet->getDelegate()->getStyle("AA".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("AA".$fromMerge);

                $sheet->setCellValue("AB".$fromMerge, number_format($this->totalTax,2));
                $sheet->getDelegate()->getStyle("AB".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("AB".$fromMerge);

                $sheet->setCellValue("AC".$fromMerge, number_format($this->totalTaxFee,2));
                $sheet->getDelegate()->getStyle("AC".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("AC".$fromMerge);

                $sheet->setCellValue("AD".$fromMerge, $this->totalAmount_usd);
                $sheet->getDelegate()->getStyle("AD".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("AD".$fromMerge);
                
                // if ($this->resignedDate) {
                //     $resigned = $this->resignedDate + 6;
                //     $event->sheet->getDelegate()->getStyle('A'.$resigned.':AA'.$resigned)
                //     ->getFill()
                //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                //     ->getStartColor()
                //     ->setARGB('fcd5b4');
                // }
                
                // $event->sheet->getDelegate()->getStyle("Q".$fromMerge.':R'.$toMerge)
                // ->getAlignment()
                // ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                
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
                "លេខតួ",
                "លេខម៉ាស៊ីន",
                "ស្លាកលេខ",
                "ម៉ាកម៉ូតូ",
                "ពណ៌",
                "ឆ្នាំផលិត",
                "ឆ្នាំផុតកំណត់",
                "អាយុកាលប្រើប្រាស់រួច",
                "ម៉ូដែល",
                "លេខសម្គាល់(IMEI)",
                "ថ្ងៃចាប់ផ្តើមកិច្ចសន្យាជួល",
                "សាំងផ្តល់ ជូន(L)",
                "ចំនួនថ្ងៃបានធ្វើការ",
                "ចំនួនលីត្រ",
                "ចំនួនជារៀល",
                "ថ្លៃទិញប្រេងម៉ាស៊ីន",
                "ប្រាក់ឈ្នួលម៉ូតូមុនកាត់ពន្ធ",
                "ប្រាក់ឈ្នួលTablet/Ipadមុនកាត់ពន្ធ",
                "ប្រាក់ឈ្នួលសរុប (ម៉ូតូ&ថេប្លេត)",
                "អត្រាជាប់ពន្ធ (%)",
                "ពន្ធលើថ្លៃឈ្នួល",
                "ប្រាក់បន្ទាប់ពីដកពន្ធ",
                "ថ្ងៃធ្វើការចុងក្រោយ",
                "សម្គាល់នៃកិច្ចសន្យា",
        ];
    }
}
