<?php

namespace App\Exports;

use App\Models\User;
use App\Repositories\Admin\EmployeeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportEmployeeReport implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    public function __construct($request)
    {
        $users = User::whereNot("emp_status", null)
        ->when(Auth::user()->RolePermission, function ($query, $RolePermission) {
            if ($RolePermission == 'Employee') {
                $query->where('id',Auth::user()->id);
            }
            if ($RolePermission == 'HOD') {
                $query->whereIn("department_id", EmployeeRepository::getRoleHOD());
            }
            if ($RolePermission == 'BM') {
                $query->where("branch_id", Auth::user()->branch_id);
            }
        })
        ->when($request->emp_status, function ($query, $emp_status) {
            $query->where('emp_status', $emp_status);
        })
        ->when($request->number_employee, function ($query, $employee_id) {
            $query->where('number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })->get();
        $dataExport = [];
        $i = 1;
        foreach ($users as $value) {
            $emp_status = "";
            if ($value->emp_status== "Upcoming"){
                $emp_status = "Upcoming";
            }else if ($value->emp_status == "Probation"){
                $emp_status = "Probation";
            }else if ($value->emp_status == "1"){
                $emp_status = "FDC-1";
            }else if ($value->emp_status == "10"){
                $emp_status = "FDC-2";
            }else if ($value->emp_status == "2"){
                $emp_status = "UDC";
            }else if ($value->emp_status=='3'){
                $emp_status = "Resignation";
            }else if ($value->emp_status=='4'){
                $emp_status = "Termination";
            }else if ($value->emp_status=='5'){
                $emp_status = "Death";
            }else if ($value->emp_status=='6'){
                $emp_status = "Retired";
            }else if ($value->emp_status=='7'){
                $emp_status = "Lay off";
            }else if ($value->emp_status=='8'){
                $emp_status = "Suspension";
            }else if ($value->emp_status=='9'){
                $emp_status = "Fall Probation";
            }else if ($value->emp_status=='Cancel'){
                $emp_status = "Cancel";
            };
            $dataExport[] = [
                "no" => $i,
                "employee_id" => $value->number_employee,
                "name" => $value->employee_name_en,
                "gender" => $value->EmployeeGender,
                "role" => $value->RolePermission,
                "department" => $value->EmployeeDepartment,
                "position" => $value->EmployeePosition,
                "branch" => $value->EmployeeBranch,
                "join_date" => $value->joinOfDate,
                "DOB" => $value->DOB,
                "martial_status" => $value->marital_status,
                "basic_salary" => $value->basic_salary,
                "status" => $emp_status,
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
        ];
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
               $sheet->mergeCells('A2:M2');
                $sheet->setCellValue('A2', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A2:M2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:M2');
                $event->sheet->getDelegate()->getStyle('A2:M2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:M3');
                $sheet->setCellValue('A3', "Employee Report");
                $sheet->getDelegate()->getStyle('A3:M3')->getFont()->setName('Arial')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:M3')
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
            "Name",
            "Gender",
            "Role",
            "Department",
            "Position",
            "Branch",
            "Join Date",
            "DOB",
            "Martial Status",
            "Basic Salary",
            "Status",
        ];
    }
}
