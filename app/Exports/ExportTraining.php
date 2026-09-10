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
        foreach ($export_data as $item) {
            $i++;
            $price = 0;
            $discount = 0;
            $total = 0;
            $trainer = null;
            if($item->training){
                $price =  ($item->training->cost_price / $item->training->training_detail_staffs_count);
                $discount = ($item->training->discount / $item->training->training_detail_staffs_count);
                $total = $price - $discount;

                if (count($item->training->trainingDetailTrainer) == 1) {
                    $trainer = $item->training->trainingDetailTrainer[0]->trainer->type == 2 ? $item->training->trainingDetailTrainer[0]->trainer->name_en : $item->training->trainingDetailTrainer[0]->trainer->employee->employee_name_en;
                }else{
                    foreach ($item->training->trainingDetailTrainer as $key => $trai) {
                        $trainer .= $trai->trainer->type == 2 ? $trai->trainer->name_en : $trai->trainer->employee->employee_name_en.', ';
                    }
                }
            }
            $date_ofcommencement = Carbon::parse($item->employee->date_of_commencement)->format('d-M-Y') ?? '';
            $start_date = Carbon::parse($item->training->start_date)->format('d-M-Y') ?? '';
            $end_date = Carbon::parse($item->training->end_date)->format('d-M-Y') ?? '';
            $duration_month = $item->training->duration_month ? Carbon::parse($item->end_date)->addMonth($item->training->duration_month)->format('d-M-Y'): 0;

            $dataExport[] = [
                "number" => $i,
                "id_card" => $item->employee->number_employee,
                "name_Kh" => $item->employee->employee_name_kh,
                "name_en" => $item->employee->employee_name_en,
                "gender" => $item->employee->EmployeeGender,
                "position" => $item->employee->EmployeePosition,
                "date_ofcommencement" => $date_ofcommencement,
                "employee_period" => $item->employee->SeniorityYearsOfEmployee,
                "course_name" => $item->training->course_name,
                "location" => $item->employee->EmployeeBranch,
                "start_date" => $start_date,
                "end_date" => $end_date,
                "duration_month" => $duration_month,
                "price" => '$ '.round($price, 2),
                "discount" => '$ '.round($discount, 2),
                "total" => '$ '.round($total, 2),
                "trainer" => $trainer,
                "status" => $item->training->training_type == 1 ? "Internal" : "External",
                "remark" => $item->training->remark ? $item->training->remark : "",
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
        // return Training::all();
    }
    public function startCell(): string
    {
        return 'A4';
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:S2');
                $sheet->setCellValue('A2', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A2:S2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:S2');
                $event->sheet->getDelegate()->getStyle('A2:S2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $month = Carbon::now()->format('M');
                // $year = Carbon::now()->format('Y');

                // $sheet->mergeCells('A3:S3');
                // $sheet->setCellValue('A3', "ជាតិ សាសនា ព្រះមហាក្សត្រ");
                // $sheet->getDelegate()->getStyle('A3:S3')->getFont()->setName('Khmer OS Freehand')
                // ->setSize(10);
                // $event->sheet->getDelegate()->getStyle('A3:S3')
                //                 ->getAlignment()
                //                 ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:S3');
                $sheet->setCellValue('A3', "Training Reports");
                $sheet->getDelegate()->getStyle('A3:S3')->getFont()->setName('Arial')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:S3')
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
                "Length of Employment",
                "Course Name",
                "Dept/Branch",
                "Start Date",
                "End Date",
                "Duration Term",
                "Price/Unit",
                "Discount Fee",
                "Total Price After Discounted",
                "Trainer",
                "Type of Training",
                "Remarks",
        ];
    }
}
