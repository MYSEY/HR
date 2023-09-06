<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Payroll;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Border;
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
        })->orderBy('employee_id')->get();
        $dataExport = [];
        $i = 1;
        foreach ($payroll as $value) {
            $dataExport[] = [
                "no" => $i,
                "employee_id"       => intval($value->users->number_employee),
                "name"              => $value->users->employee_name_en,
                "position"          => $value->users->EmployeePosition,
                "department"        => $value->users->EmployeeDepartment,
                "location"          => $value->users->EmployeeBranch,
                "join_date"         => $value->users->joinOfDate,
                "basic_salary"      => $value->basic_salary,
                "Base Salary Received"          => $value->total_gross_salary,
                "child_allowance"               => $value->total_child_allowance ?? "0",
                "phone_allowance"               => $value->phone_allowance ?? "0",
                "monthly_quarterly_bonuses"     => $value->monthly_quarterly_bonuses,
                "KNY_/_pchum_ben"               => $value->total_kny_phcumben,
                "annual_incentive_bonus"        => $value->annual_incentive_bonus,
                "seniority_pay_included_tax"    => $value->seniority_pay_included_tax,
                "Total Gross"                   => $value->total_gross,
                "pension_fund"                  => $value->total_pension_fund,
                "base_salary_received_usd"      => $value->base_salary_received_usd,
                "base_salary_received_reil"     => $value->base_salary_received_riel,
                "Spouse"                        => $value->spouse,
                "Dependent Child"               => $value->children ?? "0",
                "Charges To Be Reduced"         => $value->total_charges_reduced,
                "Total Tax Base Riel"           => $value->total_tax_base_riel,
                "Tax Rate"                      => $value->total_rate ?? "0",
                "Personal Tax(USD)"             => $value->total_salary_tax_usd,
                "Personal Tax(Riels)"           => $value->total_salary_tax_riel,
                "seniority_pay_excluded_tax"    => $value->seniority_pay_excluded_tax,
                "seniority Backford"            => $value->seniority_backford,
                "severance_pay"                 => $value->total_severance_pay,
                "Loan Amount"                   => $value->loan_amount ?? "0",
                "Total Amount Car"              => $value->total_amount_car ?? "0",
                "net_salary"                    => $value->total_salary
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
            'H' => 14,      
            'I' => 18,      
            'J' => 15,      
            'K' => 20,      
            'L' => 18,      
            'M' => 20,      
            'N' => 23,      
            'O' => 20,      
            'P' => 15,      
            'Q' => 10,      
            'R' => 20,      
            'S' => 22,      
            'T' => 5,      
            'U' => 20,      
            'V' => 20,
            'W' => 18,
            'X' => 5,
            'Y' => 15,
            'Z' => 18,
            'AA' => 20,
            'AB' => 17,
            'AC' => 14,
            'AD' => 13,
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
                
                //SetHeaderColor
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->getColor()->setARGB('DD4B39');
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->getColor()->setARGB('0000CC');
                $event->sheet->getDelegate()->getStyle('A4')->getFont()->getColor()->setARGB('3923A9');
                $event->sheet->getDelegate()->getStyle('A5:AF5')->getFont()->getColor()->setARGB('3923A9');

                $event->sheet->getStyle('A5:AF5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                //SetColumn Center
                // $sheet->getDelegate()->getStyle('A5:AF5')->getFont()->setName('Khmer OS Battambang')->setSize(8)->setUnderline('A5:AF3');
                // $event->sheet->getDelegate()->getStyle('B5')->getAlignment()
                // ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // block merge cells 
                $sheet->mergeCells('A2:AF2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:AF2')->getFont()->setSize(18)->setName('Khmer OS Muol Pali')->setUnderline('A2:AF2');
                $event->sheet->getDelegate()->getStyle('A2:AF2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:AF3');
                $sheet->setCellValue('A3', "តារាងលំអិតអំពីប្រាក់បៀវត្សរបស់បុគ្គលិក");
                $sheet->getDelegate()->getStyle('A3:AF3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:AF3');
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
            "Base Salary Received",
            "Child Allowance",
            "Phone Allowance",
            "Monthly Quarterly Bonuses",
            "KNY / Pchum Ben",
            "Annual Incentive Bonus",
            "Seniority Pay(Included Tax)",
            "Total Gross",
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
            "Net Salary"
        ];
    }
}
