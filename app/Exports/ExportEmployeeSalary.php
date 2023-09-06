<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Payroll;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

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
                "basic_salary" => $value->basic_salary,
                "child_allowance" => $value->total_child_allowance,
                "phone_allowance" => $phone_allowance,
                "monthly_quarterly_bonuses" => $value->monthly_quarterly_bonuses,
                "KNY_/_pchum_ben" => $value->total_kny_phcumben,
                "annual_incentive_bonus" => $value->annual_incentive_bonus,
                "seniority_pay_included_tax" => $value->seniority_pay_included_tax,
                "pension_fund" => $value->total_pension_fund,
                "base_salary_received_usd" => $value->base_salary_received_usd,
                "base_salary_received_reil" => $value->base_salary_received_riel,
                "Spouse" => $value->spouse,
                "Dependent Child" => $value->children,
                "Charges To Be Reduced" => $value->total_charges_reduced,
                "Total Tax Base Riel" => $value->total_tax_base_riel,
                "Tax Rate" => $value->total_rate,
                "Personal Tax(USD)" => $value->total_salary_tax_usd,
                "Personal Tax(Riels)" => $value->total_salary_tax_riel,
                "seniority_pay_excluded_tax" => $value->seniority_pay_excluded_tax,
                "seniority Backford" => $value->seniority_backford,
                "severance_pay" => $value->total_severance_pay,
                "Loan Amount" => $value->loan_amount,
                "Total Amount Car" => $value->total_amount_car,
                "net_salary" => $value->total_salary,
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
        return 'A5';
    }
    // Khmer OS Muol Light
    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 20,      
            'C' => 30,      
            'D' => 40,      
            'E' => 40,      
            'F' => 15,      
            'G' => 15,      
            'H' => 10,      
            'I' => 13,      
            'J' => 15,      
            'K' => 20,      
            'L' => 20,      
            'M' => 20,      
            'N' => 22,      
            'O' => 22,      
            'P' => 20,      
            'Q' => 10,      
            'R' => 7,      
            'S' => 20,      
            'T' => 20,      
            'U' => 20,      
            'V' => 10,
            'W' => 20,
            'X' => 20,
            'Y' => 20,
            'Z' => 20,
            'AA' => 16,
            'AB' => 17,
            'AC' => 17,
            'AD' => 15,
            'AE' => 13,
            'AF' => 13,
        ];
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                $rows = $this->export_datas;

                // block merge cells 
                $sheet->mergeCells('A2:AF2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:U2')->getFont()->setSize(18)->setName('Khmer OS Muol Pali')->setUnderline('A2:AF2');
                $event->sheet->getDelegate()->getStyle('A2:AF2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:AF3');
                $sheet->setCellValue('A3', "តារាងលំអិតអំពីប្រាក់បៀវត្សរបស់បុគ្គលិក");
                $sheet->getDelegate()->getStyle('A3:U3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:AF3');
                $event->sheet->getDelegate()->getStyle('A3:AF3')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:AF4');
                $sheet->setCellValue('A4', "ប្រចាំខែមេសា ឆ្នាំ២០២៣");
                $sheet->getDelegate()->getStyle('A4:AF4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:AF4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
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
            "Monthly Quarterly Bonuses",
            "KNY / Pchum Ben",
            "Annual Incentive Bonus",
            "Seniority Pay(Included Tax)",
            "Pension Fund",
            "Base Salary Received USD",
            "Base Salary Received Riel",
            "Spouse",
            "Dependent child",
            "Charges To Be Reduced",
            "Total Tax Base Riel",
            "Tax Rate",
            "Personal Tax(USD)",
            "Personal Tax(Riels)",
            "Seniority Pay(Excluded Tax)",
            "seniority Backford",
            "Severance Pay",
            "Loan Amount",
            "Total Amount Car",
            "Net Salary",
            "Payment Date",
            "Created At",
        ];
    }
}
