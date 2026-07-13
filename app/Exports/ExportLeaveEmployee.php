<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportLeaveEmployee implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;
    protected $LeaveAllocation;
    protected $total_annual_leave = 0;
    protected $total_sick_leave = 0;
    protected $total_special_leave = 0;
    protected $total_unpaid_leave = 0;
    protected $total_long_sick_leave = 0;

    public function __construct($datas)
    {
        $this->totalRecord = count($datas["dataLeaveRequest"]);
        $i = 0;
        $dataExport = [];
        if (count($datas["dataLeaveType"]) > 0){
            foreach ($datas["dataLeaveType"] as $type){
                if ($type->type == "annual_leave"){
                    $this->total_annual_leave = $datas["LeaveAllocation"] ? $datas["LeaveAllocation"]->total_annual_leave : 0;
                }else if($type->type == "sick_leave"){
                    $this->total_sick_leave = $datas["LeaveAllocation"] ? $datas["LeaveAllocation"]->total_sick_leave : 0;
                }elseif($type->type == "special_leave"){
                    $this->total_special_leave = $datas["LeaveAllocation"] ? $datas["LeaveAllocation"]->total_special_leave : 0;
                }elseif($type->type == "unpaid_leave"){
                    $this->total_unpaid_leave = $datas["LeaveAllocation"] ? $datas["LeaveAllocation"]->total_unpaid_leave : 0;
                }elseif($type->type == "long_sick_leave"){
                    $this->total_long_sick_leave = $datas["LeaveAllocation"] ? $datas["LeaveAllocation"]->total_long_sick_leave : 0;
                }
            }
        };
        
        $totalAnnualLeave= 0;
        $totalSickLeave= 0;
        $totalSpacialLeave= 0;
        $totalUnpaidLeave= 0;
        $totalLongSickLeave= 0;
        $Status=  "";
        foreach ($datas["dataLeaveRequest"] as $request) {
           
            $i++;
            $start_date = Carbon::createFromDate($request->start_date)->format('d-m-Y');
            $end_date = Carbon::createFromDate($request->end_date)->format('d-m-Y');
            $created_at = Carbon::createFromDate($request->created_at)->format('d-m-Y H:i');

            if ($request->status != "rejected" && $request->status != "rejected_lm" && $request->status != "rejected_hod" && $request->status != "cancel_hod" && $request->status != "cancel" ) {
                if ($request->leaveType->type == "annual_leave") {
                    $totalAnnualLeave += $request->number_of_day;
                }else if ($request->leaveType->type == "sick_leave") {
                    $totalSickLeave += $request->number_of_day;
                }else if ($request->leaveType->type == "special_leave") {
                    $totalSpacialLeave += $request->number_of_day;
                }else if ($request->leaveType->type == "unpaid_leave") {
                    $totalUnpaidLeave += $request->number_of_day;
                }else if ($request->leaveType->type == "long_sick_leave") {
                    $totalLongSickLeave += $request->number_of_day;
                }
            }
            if ($request->status == "rejected"){
               $Status = "Rejected";
            }elseif($request->status == "pending_cancel"){
               $Status = "Pending Cancel";
            }elseif($request->status == "cancel_hod" || $request->status == "cancel"){
               $Status = "Cancel";
            }elseif ($request->status == "rejected_lm"){
               $Status = "Rejected by Line Manager";
            }elseif ($request->status == "rejected_hod"){
               $Status = "Rejected by ACEO/Head/BM";
            }elseif ($request->status == "approved_lm" || $request->status == "pending"){
               $Status ="Waiting Approve by CEO/Head/BM";
            }elseif ($request->status == "approved_hod"){
               $Status = "Approved";
            }elseif($request->status == "approved"){
                $Status = "Approved";
            };
            $annual_leave_numberOfDay = ($request->leaveType->type == "annual_leave" ? $request->number_of_day : 0);
            $sick_leave_numberOfDay = ($request->leaveType->type == "sick_leave" ? $request->number_of_day : 0);
            $special_leave_numberOfDay = ($request->leaveType->type == "special_leave" ? $request->number_of_day : 0);
            $unpaid_leave_numberOfDay = ($request->leaveType->type == "unpaid_leave" ? $request->number_of_day : 0);
            $long_sick_leave_numberOfDay = ($request->leaveType->type == "long_sick_leave" ? $request->number_of_day : 0);
            $dataExport[] = [
                "number"                            => $i,
                "employee_name"                     => $request->employee->employee_name_en,
                "department"                        => $request->employee->department->name_english,
                "from"                              => $start_date,
                "to"                                => $end_date,
                "created_at"                        => $created_at,
                "day_taken1"                        => $annual_leave_numberOfDay,          
                "balance1"                          => ($request->status != "rejected" && $request->status != "rejected_lm" && $request->status != "rejected_hod" && $request->status != "cancel_hod" && $request->status != "cancel" ? $request->leaveType->type == "annual_leave" ? $datas["LeaveAllocation"]->default_annual_leave - $totalAnnualLeave : 0 : 0), 
                "day_taken2"                        => $sick_leave_numberOfDay,           
                "balance2"                          => ($request->status != "rejected" && $request->status != "rejected_lm" && $request->status != "rejected_hod" && $request->status != "cancel_hod" && $request->status != "cancel" ? $request->leaveType->type == "sick_leave" ? $datas["LeaveAllocation"]->default_sick_leave - $totalSickLeave : 0 : 0),         
                "day_taken3"                        => $special_leave_numberOfDay,          
                "balance3"                          => ($request->status != "rejected" && $request->status != "rejected_lm" && $request->status != "rejected_hod" && $request->status != "cancel_hod" && $request->status != "cancel"? $request->leaveType->type == "special_leave" ? $datas["LeaveAllocation"]->default_special_leave - $totalSpacialLeave : 0 : 0),        
                "day_taken4"                        => $unpaid_leave_numberOfDay,           
                "balance4"                          => ($request->leaveType->type == "unpaid_leave"? $totalUnpaidLeave : 0),         
                "day_taken5"                        => $long_sick_leave_numberOfDay,           
                "balance5"                          => ($request->leaveType->type == "long_sick_leave"? $totalLongSickLeave : 0),
                "Reason"                            => $request->reason,
                "Remark"                            => $request->remark,        
                "Status"                            => $Status,
            ];
        }
        $this->export_datas = $dataExport;
        $this->LeaveAllocation = $datas["LeaveAllocation"];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([
            $this->export_datas,
        ]);
        // return LeaveRequest::all();
    }
    public function startCell(): string
    {
        return 'A8';
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
                "From",
                "To",
                "Request Date",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
                "Day Taken",
                "Balance",
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:P2');
                $sheet->setCellValue('A2', "Leave employee request");
                $sheet->getDelegate()->getStyle('A2:P2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setBold('A2:P2')->setUnderline('A2:P2');
                $event->sheet->getDelegate()->getStyle('A2:P2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');

                $sheet->mergeCells('A3:P3');
                $sheet->setCellValue('A3', "For the year of ".$year);
                $sheet->getDelegate()->getStyle('A3:P3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10)->setBold('A3:P3');
                $event->sheet->getDelegate()->getStyle('A3:P3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $sheet->mergeCells('A4:D4');
                // $sheet->setCellValue('A4', "ការិយាល័យកណ្ដាល");
                // $sheet->getDelegate()->getStyle('A4:D4')->getFont()->setName('Khmer OS Muol Light')
                // ->setSize(10)->setUnderline('A4:D4');
                // $event->sheet->getDelegate()->getStyle('A4:D4')
                //             ->getAlignment()
                //             ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $year1 = 0;
                $year2 = 0;
                $year3 = 0;
                if($this->LeaveAllocation){
                    $year1 = $this->LeaveAllocation->year_1;
                    $year2 = $this->LeaveAllocation->year_2;
                    $year3 = $this->LeaveAllocation->year_3;
                }
                $sheet->mergeCells('B5:E5');
                $sheet->setCellValue('B5', "Carried Forward Leave: Year 1 = ".$year1." Year 2 = ".$year2." Year 3 = ".$year3);
                $sheet->getDelegate()->getStyle('B5:E5')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setBold('B5:E5');

                $sheet->mergeCells('B6:B6');
                $sheet->setCellValue('B6', "Annual Leave = ".$this->total_annual_leave);
                $sheet->getDelegate()->getStyle('B6:B6')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setBold('B6:B6');
                
            
                $sheet->mergeCells('C6:C6');
                $sheet->setCellValue('C6', "Sick Leave = ".$this->total_sick_leave);
                $sheet->getDelegate()->getStyle('C6:C6')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setBold('C6:C6');

                $sheet->mergeCells('D6:D6');
                $sheet->setCellValue('D6', "Special Leave = ".$this->total_special_leave);
                $sheet->getDelegate()->getStyle('D6:D6')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setBold('D6:D6');

                $sheet->mergeCells('E6:E6');
                $sheet->setCellValue('E6', "Unpaid Leave = ".$this->total_unpaid_leave);
                $sheet->getDelegate()->getStyle('E6:E6')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setBold('E6:E6');

                $sheet->mergeCells('F6:F6');
                $sheet->setCellValue('F6', "Long Sick Leave = ".$this->total_long_sick_leave);
                $sheet->getDelegate()->getStyle('F6:F6')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setBold('F6:F6');


                $sheet->getDelegate()->getStyle('G8:H8')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9);
                $sheet->getDelegate()->getStyle('O8:P8')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9);

                $sheet->getDelegate()->getStyle('A7:Z7')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A7:Z7');
                $sheet->getDelegate()->getStyle('A7:Z7')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A7:Z7');

                $sheet->mergeCells('D7:F7');
                $sheet->setCellValue('D7', "Period of Leave");
                $event->sheet->getDelegate()->getStyle('D7:F7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('G7:H7');
                $sheet->setCellValue('G7', "Annual Leave");
                $event->sheet->getDelegate()->getStyle('G7:H7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                $sheet->mergeCells('I7:J7');
                $sheet->setCellValue('I7', "Sick Leave");
                $event->sheet->getDelegate()->getStyle('I7:J7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('K7:L7');
                $sheet->setCellValue('K7', "Special Leave");
                $event->sheet->getDelegate()->getStyle('K7:L7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('M7:N7');
                $sheet->setCellValue('M7', "Unpaid Leave");
                $event->sheet->getDelegate()->getStyle('M7:N7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('O7:P7');
                $sheet->setCellValue('O7', "Long Sick Leave");
                $event->sheet->getDelegate()->getStyle('O7:P7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('Q7:Q7');
                $sheet->setCellValue('Q7', "Reason");
                $event->sheet->getDelegate()->getStyle('Q7:Q7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('R7:R7');
                $sheet->setCellValue('R7', "Remark");
                $event->sheet->getDelegate()->getStyle('R7:R7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('S7:S7');
                $sheet->setCellValue('S7', "Status");
                $event->sheet->getDelegate()->getStyle('S7:S7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->getDelegate()->getStyle('A8:Y8')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(10)->setBold('A8:Y8');
                $event->sheet->getDelegate()->getStyle('A8:Y8')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
            

                $event->sheet->getStyle('A7'.':S7')->applyFromArray([
                    'font' => [
                        'name' => 'Khmer OS Battambang', // Font name
                        'size' => 9, // Font size
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A8'.':S8')->applyFromArray([
                    'font' => [
                        'name' => 'Khmer OS Battambang', // Font name
                        'size' => 9, // Font size
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                //** block body */ 
                $n=8;
                if ($this->totalRecord > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':S'.$n)->applyFromArray([
                            'font' => [
                                'name' => 'Khmer OS Battambang', // Font name
                                'size' => 9, // Font size
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}
