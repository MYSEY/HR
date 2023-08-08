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

class ExportMotorRentelReport implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    public function __construct($datas)
    {
        $dataExport = [];
        $i = 1;
        foreach ($datas as $value) {
            $create_at = Carbon::parse($value->created_at)->format('d-M-Y') ?? '';
            $start_date = Carbon::parse($value->start_date)->format('d-M-Y') ?? '';
            $end_date = Carbon::parse($value->end_date)->format('d-M-Y') ?? '';
            $dataExport[] = [
                "no" => $i,
                "employee_id" => $value->MotorEmployee->number_employee,
                "employee_name" => $value->MotorEmployee->employee_name_en,
                "gender" => $value->MotorEmployee->EmployeeGender,
                "branch_bame" => $value->MotorEmployee->EmployeeBranch,
                "position" => $value->MotorEmployee->EmployeePosition,
                "department" => $value->MotorEmployee->EmployeeDepartment,
                "created_at" => $create_at,
                "start_date" => $start_date,
                "end_date" => $end_date,
                "year_of_manufature" => $value->product_year,
                "expiretion_year" => $value->expired_year,
                "shelt_life" => $value->shelt_life,
                "number_plate" => $value->number_plate,
                "total_gasoline" => $value->total_gasoline." (L)",
                "total_working_days" => $value->total_work_day,
                "total_gasoline_liters" => $value->total_gasoline * $value->total_work_day,
                "total_price_gasoline" => number_format($value->total_gasoline * $value->total_work_day * $value->gasoline_price_per_liter, 2)." ៛",
                "price_engine_oil" =>"$ ".$value->price_engine_oil,
                "price_motor_rentel" =>"$ ".$value->price_motor_rentel,
                "tax_rate" =>$value->tax_rate."%",
                "taxes_on_fees" =>"$ ".($value->price_motor_rentel * $value->tax_rate) / 100,
                "amount" =>"$ ".$value->price_motor_rentel - ($value->price_motor_rentel * $value->tax_rate) / 100,
            ];
            $i++;
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
        return 'A4';
    }
    // Khmer OS Muol Light
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 10,      
            'C' => 10,      
            'D' => 10,      
            'E' => 10,      
            'F' => 10,      
            'G' => 10,      
            'H' => 10,      
            'I' => 10,      
            'J' => 10,      
            'K' => 10,      
            'L' => 10,      
            'M' => 10,
            'N' => 10,
            'O' => 10,
            'P' => 10,
            'Q' => 10,
            'R' => 10,
            'S' => 10,
            'T' => 10,
            'U' => 10,
            'V' => 10,
            'W' => 10,
        ];
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
               $sheet->mergeCells('A2:W2');
                $sheet->setCellValue('A2', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A2:W2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:W2');
                $event->sheet->getDelegate()->getStyle('A2:W2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:W3');
                $sheet->setCellValue('A3', "Motor rental Reports");
                $sheet->getDelegate()->getStyle('A3:W3')->getFont()->setName('Arial')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:W3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
    public function headings(): array
    {
        return [
            "NO",
            "Employee ID",
            "Employee Name",
            "Gender",
            "Branch Name",
            "Position",
            "Department",
            "Created At",
            "Start Date",
            "End Date",
            "Year of Manufature",
            "Expiretion Year",
            "Shelt Life",
            "Number Plate",
            "Total Gasoline",
            "Total Working Days",
            "Total gasoline liters",
            "Total Price Gasoline",
            "Price Engine oil",
            "Price Motor Rentel",
            "Tax Rate",
            "Taxes on Fees",
            "Amount",
        ];
    }
}
