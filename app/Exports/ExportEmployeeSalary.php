<?php

namespace App\Exports;

use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportEmployeeSalary implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    public function __construct($request)
    {
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $payroll = Payroll::with("users")
        ->join('users', 'payrolls.employee_id', '=', 'users.id')
        ->select(
            'payrolls.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh',
            'users.branch_id',
        )
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('users.branch_id', $branch_id);
        })
        ->when($Monthly, function ($query, $Monthly) {
            $query->whereMonth('payment_date', $Monthly);
        })
        ->when($yearLy, function ($query, $yearLy) {
            $query->whereYear('payment_date', $yearLy);
        })->get();
        $dataExport = [];
        $i = 1;
        foreach ($payroll as $value) {
            $phone_allowance = $value->phone_allowance == null ? '0.00' : $value->phone_allowance;
            $dataExport[] = [
                "no" => $i,
                "employee_id" => $value->users->number_employee,
                "name" => $value->users->employee_name_en,
                "position" => $value->users->EmployeePosition,
                "department" => $value->users->EmployeeDepartment,
                "location" => $value->users->EmployeeBranch,
                "join_date" => $value->users->joinOfDate,
                "basic_salary" => "$ ".$value->basic_salary,
                "child_allowance" => "$ ".$value->total_child_allowance,
                "phone_allowance" => "$ ".$phone_allowance,
                "KNY_/_pchum_ben" => "$ ".$value->total_kny_phcumben,
                "seniority_pay_excluded_tax" => "$ ".$value->seniority_payable_tax,
                "pension_fund" => "$ ".$value->total_pension_fund,
                "base_salary_received_usd" => "$ ".$value->base_salary_received_usd,
                "base_salary_received_reil" => "៛ ".$value->total_tax_base_riel,
                "Tax Rate" => $value->total_rate ." %",
                "tax_free_seniority" => "$ ".$value->seniority_pay_excluded_tax,
                "severance_pay" => "$ ".$value->total_severance_pay,
                "net_salary" => "$ ".$value->total_salary,
                "payment_date" => $value->PayrollPaymentDate,
                "created_at" => $value->Created,
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
        ];
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
               $sheet->mergeCells('A2:U2');
                $sheet->setCellValue('A2', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A2:U2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:W2');
                $event->sheet->getDelegate()->getStyle('A2:U2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:U3');
                $sheet->setCellValue('A3', "Employee Salary");
                $sheet->getDelegate()->getStyle('A3:U3')->getFont()->setName('Arial')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:U3')
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
            "Position",
            "Department",
            "Location",
            "Join Date",
            "Basic Salary",
            "Child Allowance",
            "Phone Allowance",
            "KNY / Pchum Ben",
            "Seniority Payable Tax",
            "Pension Fund",
            "Base Salary Received USD",
            "Base Salary Received Riel",
            "Tax Rate",
            "Tax-free Seniority",
            "Severance Pay",
            "Net Salary",
            "Payment Date",
            "Created At",
        ];
    }
}
