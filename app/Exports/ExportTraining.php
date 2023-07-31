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

class ExportTraining implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    public function __construct($export_data)
    {
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $training) {
            $i++;
            $price = 0;
            $discount = 0;
            $total = 0;
            if (count($training->employee_id) > 0) {
                $price =  $training->cost_price / count($training->employee_id);
                $discount = ($price * $training->discount) / 100;
                $total = $price - $discount;
            }
            $trainer = null;
            if (count($training->trainers) == 1) {
                $trainer = $training->trainers[0]->type == 2 ? $training->trainers[0]->name_en : $training->trainers[0]->employee->employee_name_en;
            }else{
                foreach ($training->trainers as $key => $trai) {
                    $trainer .= $trai->type == 2 ? $trai->name_en : $trai->employee->employee_name_en.', ';
                }
            }
            foreach ($training->employees as $key => $emp) {
                $date_ofcommencement = Carbon::parse($emp->date_of_commencement)->format('d-M-Y') ?? '';
                $start_date = Carbon::parse($training->start_date)->format('d-M-Y') ?? '';
                $end_date = Carbon::parse($training->end_date)->format('d-M-Y') ?? '';
                $duration_month = $training->duration_month ? Carbon::parse($training->end_date)->addMonth($training->duration_month)->format('d-M-Y'): 0;
                $dataExport[] = [
                    "number" => $i,
                    "id_card" => $emp->number_employee,
                    "name_Kh" => $emp->employee_name_kh,
                    "name_en" => $emp->employee_name_en,
                    "gender" => $emp->EmployeeGender,
                    "position" => $emp->EmployeePosition,
                    "date_ofcommencement" => $date_ofcommencement,
                    "employee_period" => $emp->SeniorityYearsOfEmployee,
                    "course_name" => $training->course_name,
                    "location" => $emp->EmployeeBranch,
                    "start_date" => $start_date,
                    "end_date" => $end_date,
                    "duration_month" => $duration_month,
                    "price" => '$ '.round($price, 2),
                    "discount" => '$ '.round($discount, 2),
                    "total" => '$ '.round($total, 2),
                    "trainer" => $trainer,
                    "status" => $training->training_type == 1 ? "Internal" : "External",
                    "remark" => $training->remark ? $training->remark : "",
                ];
            }
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
        // return Training::all();
    }
    public function startCell(): string
    {
        return 'A5';
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:S2');
                $sheet->setCellValue('A2', "ព្រះរាជាណាចក្រកម្ពុជា");
                $sheet->getDelegate()->getStyle('A2:S2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:S2');
                $event->sheet->getDelegate()->getStyle('A2:S2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $month = Carbon::now()->format('M');
                // $year = Carbon::now()->format('Y');

                $sheet->mergeCells('A3:S3');
                $sheet->setCellValue('A3', "ជាតិ សាសនា ព្រះមហាក្សត្រ");
                $sheet->getDelegate()->getStyle('A3:S3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:S3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:S4');
                $sheet->setCellValue('A4', "Training Reports");
                $sheet->getDelegate()->getStyle('A3:S3')->getFont()->setName('Arial')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:S4')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            },
        ];
    }

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
        ];
    }
    public function headings(): array
    {
        return [
                "#",
                "ID Card",
                "Name Kh",
                "Name En",
                "Gender",
                "Position",
                "Date of Employment",
                "Employee Period",
                "Course Name",
                "Location",
                "Start Date",
                "End Date",
                "Duration Term",
                "Price/Unit",
                "Discount Fee",
                "Total",
                "Trainer",
                "Type of Training",
                "Remarks",
        ];
    }
}
