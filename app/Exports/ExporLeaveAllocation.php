<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExporLeaveAllocation implements FromCollection,WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;
    protected $condiction_tab;
    protected $start_date;
    protected $end_date;

    public function __construct($export_data,$request)
    {
        $this->totalRecord = count($export_data);
        $this->condiction_tab = $request->condiction_tab;
        $this->start_date = $request->start_date;
        $this->end_date = $request->end_date;
        $i = 0;
        $dataExport = [];
        if($request->condiction_tab == 4){
            foreach ($export_data as $leave) {
                $i++;
                $join_date = Carbon::createFromDate($leave->employee->date_of_commencement)->format('d-m-Y');
                $dataExport[] = [
                    "number"                            => $i,
                    "employee_name"                     => ($leave->employee->employee_name_en ?? ""),
                    "department"                        => $leave->employee->department->name_english,
                    "location"                          => $leave->employee->branch->branch_name_en,
                    "join_date"                         => $join_date,
                    "day_taken1"                        => $leave->total_number_al,          
                    "balance1"                          => $leave->LeaveAllocation->total_annual_leave,         
                    "day_taken2"                        => "$leave->total_number_sl",           
                    "balance2"                          => $leave->LeaveAllocation->total_sick_leave,         
                    "day_taken3"                        => "$leave->total_number_sp",          
                    "balance3"                          => $leave->LeaveAllocation->total_special_leave,        
                    "day_taken4"                        => "$leave->total_number_ul",           
                    "balance4"                          => $leave->LeaveAllocation->total_unpaid_leave,         
                    "year_1"                            => $leave->LeaveAllocation->year_1,
                    "year_2"                            => $leave->LeaveAllocation->year_2,        
                    "year_3"                            => $leave->LeaveAllocation->year_2,
                ];
            }
            $this->export_datas = $dataExport;
        }else{
            foreach ($export_data as $leave) {
                        $i++;
                        $join_date = Carbon::createFromDate($leave->employee->date_of_commencement)->format('d-m-Y');
                        $default_annual_leave = ($leave->default_annual_leave - $leave->total_annual_leave);
                        $total_annual_leave = $leave->total_annual_leave;
                        $default_sick_leave = ($leave->default_sick_leave - $leave->total_sick_leave);
                        $total_sick_leave = $leave->total_sick_leave;
                        $default_special_leave = ($leave->default_special_leave -$leave->total_special_leave);
                        $total_special_leave = $leave->total_special_leave;
                        $default_unpaid_leave = $leave->default_unpaid_leave - $leave->total_unpaid_leave;
                        $total_unpaid_leave =  $leave->total_unpaid_leave ;

                        $dataExport[] = [
                            "number"                            => $i,
                            "employee_name"                     => ($leave->employee->employee_name_en ?? ""),
                            "department"                        => $leave->employee->department->name_english,
                            "location"                          => $leave->employee->branch->branch_name_en,
                            "join_date"                         => $join_date,
                            "day_taken1"                        => $default_annual_leave,          
                            "balance1"                          => $total_annual_leave,         
                            "day_taken2"                        => "$default_sick_leave",           
                            "balance2"                          => $total_sick_leave,         
                            "day_taken3"                        => "$default_special_leave",          
                            "balance3"                          => $total_special_leave,        
                            "day_taken4"                        => "$default_unpaid_leave",           
                            "balance4"                          => $total_unpaid_leave,         
                            "year_1"                            => $leave->year_1,
                            "year_2"                            => $leave->year_2,        
                            "year_3"                            => $leave->year_3,
                        ];
                    }
                    $this->export_datas = $dataExport;
        }
        
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return LeaveRequest::all();
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
        ];
    }

    public function headings(): array
    {
        return [
                "#",
                "Employee Name" ,
                "Department",
                "Location",
                "Join Date",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Year 1",
                "Year 2",
                "Year 3",
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:P2');
                $sheet->setCellValue('A2', "LEAVE APPLICATION");
                $sheet->getDelegate()->getStyle('A2:P2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setBold('A2:P2')->setUnderline('A2:P2');
                $event->sheet->getDelegate()->getStyle('A2:P2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('M');
                $date = Carbon::now()->format('d-M-Y');

                $sheet->mergeCells('A3:P3');
                if($this->condiction_tab == 4){
                    $end_date = '';
                    if($this->end_date){
                        $end_date= ' - '.$this->end_date;
                    }
                    $start_date = 'All ';
                    if($this->start_date){
                        $start_date = $this->start_date;
                    }
                    $sheet->setCellValue('A3', "Export as of on: ".$start_date.$end_date);
                }else{
                    $sheet->setCellValue('A3', "Export as of on: ".$date);
                }
                $sheet->getDelegate()->getStyle('A3:P3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10)->setBold('A3:P3');
                $event->sheet->getDelegate()->getStyle('A3:P3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:D4');
                $sheet->setCellValue('A4', Auth::user()->branch->branch_name_kh);
                $sheet->getDelegate()->getStyle('A4:D4')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setUnderline('A4:D4');
                $event->sheet->getDelegate()->getStyle('A4:D4')
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

                $sheet->mergeCells('F5:G5');
                $sheet->setCellValue('F5', "Annual Leave");
                $event->sheet->getDelegate()->getStyle('F5:G5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                $sheet->mergeCells('H5:I5');
                $sheet->setCellValue('H5', "Sick Leave");
                $event->sheet->getDelegate()->getStyle('H5:I5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('J5:K5');
                $sheet->setCellValue('J5', "Special Leave");
                $event->sheet->getDelegate()->getStyle('J5:K5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('L5:M5');
                $sheet->setCellValue('L5', "Unpaid Leave");
                $event->sheet->getDelegate()->getStyle('L5:M5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('N5:P5');
                $sheet->setCellValue('N5', "Carried Forward Leave");
                $event->sheet->getDelegate()->getStyle('N5:P5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A6:Y6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
