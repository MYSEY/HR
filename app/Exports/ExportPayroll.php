<?php

namespace App\Exports;

use App\Models\Bonus;
use App\Models\NationalSocialSecurityFund;
use App\Models\Payroll;
use App\Models\Seniority;
use App\Models\SeverancePay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportPayroll implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $register_events_title;
    protected $register_events_title_sub_title;
    protected $monthly_title;
    protected $text_title;
    protected $header_table;
    protected $export_datas;

    public function __construct($request)
    {
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $payroll=[];
        if ($request->tab_status == 1) {
            $this->register_events_title = "AF2";
            $this->register_events_title_sub_title = "AF3";
            $this->monthly_title = 'AF4';
            $this->text_title = "តារាងលំអិតអំពីប្រាក់បៀវត្សរបស់បុគ្គលិក";
            $datas = Payroll::with("users")
            ->join('users', 'payrolls.employee_id', '=', 'users.id')
            ->select(
                'payrolls.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('payment_date', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('payment_date', $yearLy);
            })->get();
            $this->header_table = [
                "Employee ID",
                "Employee Name",
                "Department",
                "Position",
                "Branch",
                "Join Date",
                "Basic Salary",
                "Base Salary Received",
                "Child Allowance",
                "Phone Allowance",
                "Monthly Quarterly Bonuses",
                "KNY / Pchum Ben",
                "Annual incentive Bonus",
                "seniority_pay_included_tax",
                "Total Gross Salary",
                "Pension Fund",
                "base_salary_received_usd",
                "base_salary_received_reil",
                "Spouse",
                "Dependent Child",
                "Charges To Be Reduced",
                "Total Tax Base Riel",
                "Tax Rate",
                "Personal Tax(USD)",
                "Personal Tax(Riels)",
                "seniority_pay_excluded_tax",
                "Seniority Backford",
                "Loan Amount",
                "Total Amount Car",
                "Severance Pay",
                "Net Salary",
            ];
            foreach ($datas as $key => $pay) {
                $payment_date = Carbon::parse($pay->payment_date)->format('d-M-Y');
                $phone_allowance = $pay->phone_allowance == null ? "0.00" : $pay->phone_allowance;
                $payroll[]=[
                    $pay->users == null ? '' : intval($pay->users->number_employee),
                    $pay->users == null ? '' : $pay->users->employee_name_en,
                    $pay->users == null ? '' : $pay->users->EmployeeDepartment,
                    $pay->users == null ? '' : $pay->users->EmployeePosition,
                    $pay->users == null ? '' : $pay->users->EmployeeBranch,
                    $pay->users == null ? '' : $pay->users->joinOfDate,
                    $pay->basic_salary,
                    $pay->total_gross_salary,
                    $pay->total_child_allowance,
                    $phone_allowance,
                    $pay->monthly_quarterly_bonuses,
                    $pay->total_kny_phcumben,
                    $pay->annual_incentive_bonus,
                    $pay->seniority_pay_included_tax,
                    $pay->total_gross,
                    $pay->total_pension_fund,
                    $pay->base_salary_received_usd,
                    $pay->base_salary_received_riel,
                    $pay->spouse,
                    $pay->children,
                    $pay->total_charges_reduced,
                    $pay->total_tax_base_riel,
                    $pay->total_rate,
                    $pay->total_salary_tax_usd,
                    $pay->total_salary_tax_riel,
                    $pay->seniority_payable_tax,
                    $pay->seniority_pay_excluded_tax,
                    $pay->seniority_backford,
                    $pay->total_severance_pay,
                    $pay->loan_amount,
                    $pay->total_amount_car,
                    $pay->total_salary
                ];
            }
        }else if ($request->tab_status == 2) {
            $this->register_events_title = "L2";
            $this->register_events_title_sub_title = "L3";
            $this->monthly_title = "L4";
            $this->text_title = "តារាងបង់ភាគទានលើហានិ.ការងារ ថែទាំសុខភាព និងផែ្នកសោធន";
            $datas = NationalSocialSecurityFund::with("users")
            ->join('users', 'national_social_security_funds.employee_id', '=', 'users.id')
            ->select(
                'national_social_security_funds.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('national_social_security_funds.created_at', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('national_social_security_funds.created_at', $yearLy);
            })->get();
            $this->header_table = [
                "Employee ID",
                "Full Name",
                "Join Date",
                "Total salary before tax dollars",
                "Total salary before tax Riel",
                "Average wage",
                "Occupational risk",
                "Health Care ",
                "Pension contribution Riel",
                "Pension contribution dollar",
                "Enterprise pension contribution",
                "Created At",
            ];
            foreach ($datas as $key => $nssf) {
                $created_at = Carbon::parse($nssf->created_at)->format('d-M-Y');
                $payroll[]=[
                    $nssf->users == null ? '' : intval($nssf->users->number_employee),
                    $nssf->users == null ? '' : $nssf->users->employee_name_en,
                    $nssf->users == null ? '' : $nssf->users->joinOfDate,
                    intval($nssf->total_pre_tax_salary_usd),
                    $nssf->total_pre_tax_salary_riel,
                    $nssf->total_average_wage,
                    $nssf->total_occupational_risk,
                    $nssf->total_health_care,
                    $nssf->pension_contribution_usd,
                    $nssf->pension_contribution_riel,
                    $nssf->corporate_contribution,
                    $created_at,
                ];
            }
        }else if($request->tab_status == 3){
            $this->register_events_title = "H2";
            $this->register_events_title_sub_title = "H3";
            $this->monthly_title = "H4";
            $this->text_title = "ប្រាក់ឧបត្ថម្ភថ្នាក់គ្រប់គ្រង និងបុគ្គលិកសម្រាប់អបអរបុណ្យចូលឆ្នាំខ្មែរ ឆ្នាំ២០២២";
            $datas = Bonus::with("users")->get();
            $this->header_table = [
                "Employee ID",
                "Full Name",
                "Join Date",
                "Number Of Working Days",
                "Basic Salary",
                "Basic Salary Received",
                "Total Allowance",
                "Created At",
            ];
            foreach ($datas as $key => $bonus) {
                $created_at = Carbon::parse($bonus->created_at)->format('d-M-Y');
                $payroll[]=[
                    $bonus->users == null ? '' : intval($bonus->users->number_employee),
                    $bonus->users == null ? '' : $bonus->users->employee_name_en,
                    $bonus->users == null ? '' : $bonus->users->joinOfDate,
                    $bonus->number_of_working_days. "Days",
                    $bonus->base_salary,
                    $bonus->base_salary_received,
                    $bonus->total_allowance,
                    $created_at,
                ];
            }
        }else if ($request->tab_status == 4) {
            $this->register_events_title = "J2";
            $this->register_events_title_sub_title = "J3";
            $this->monthly_title = "J4";
            $this->text_title = "Seniority Pay";
            $datas = Seniority::with("users")
            ->join('users', 'seniorities.employee_id', '=', 'users.id')
            ->select(
                'seniorities.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('seniorities.created_at', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('seniorities.created_at', $yearLy);
            })->get();
            $this->header_table = [
                "Employee ID",
                "Full Name",
                "Position",
                "Join Date",
                "Months",
                "Total Average Salary",
                "Total Salary Receive",
                "Tax Exemption Salary",
                "Taxable Salary",
                "Created At",
            ];
            foreach ($datas as $key => $seniority) {
                $created_at = Carbon::parse($seniority->created_at)->format('d-M-Y');
                $payroll[]=[
                    $seniority->users == null ? '' : intval($seniority->users->number_employee),
                    $seniority->users == null ? '' : $seniority->users->employee_name_en,
                    $seniority->users == null ? '' : $seniority->users->EmployeePosition,
                    $seniority->users == null ? '' : $seniority->users->joinOfDate,
                    $seniority->payment_of_month,
                    $seniority->total_average_salary,
                    $seniority->total_salary_receive,
                    $seniority->tax_exemption_salary,
                    $seniority->taxable_salary,
                    $created_at,
                ];
            }
        }else {
            $this->register_events_title = "G2";
            $this->register_events_title_sub_title = "G3";
            $this->monthly_title = "G4";
            $this->text_title = "Severance Pay";
            $datas = SeverancePay::with("users")
            ->join('users', 'severance_pays.employee_id', '=', 'users.id')
            ->select(
                'severance_pays.*',
                'users.number_employee',
                'users.employee_name_en',
                'users.employee_name_kh',
            )
            ->when($request->employee_id, function ($query, $employee_id) {
                $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
            })
            ->when($request->employee_name, function ($query, $employee_name) {
                $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
            })
            ->when($Monthly, function ($query, $Monthly) {
                $query->whereMonth('severance_pays.created_at', $Monthly);
            })
            ->when($yearLy, function ($query, $yearLy) {
                $query->whereYear('severance_pays.created_at', $yearLy);
            })->get();
            $this->header_table = [
                "Employee ID",
                "Full Name",
                "Position",
                "Join Date",
                "Total Severanec Pay",
                "Total Contract Severance Pay",
                "Created At",
            ];
            foreach ($datas as $key => $severance) {
                $created_at = Carbon::parse($severance->created_at)->format('d-M-Y');
                $payroll[]=[
                    $severance->users == null ? '' : intval($severance->users->number_employee),
                    $severance->users == null ? '' : $severance->users->employee_name_en,
                    $severance->users == null ? '' : $severance->users->EmployeePosition,
                    $severance->users == null ? '' : $severance->users->joinOfDate,
                    $severance->total_severanec_pay,
                    $severance->total_contract_severance_pay,
                    $created_at,
                ];
            }
        }
        $this->export_datas = $payroll;
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
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                
                //SetHeaderColor
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->getColor()->setARGB('DD4B39');
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->getColor()->setARGB('0000CC');
                $event->sheet->getDelegate()->getStyle('A4')->getFont()->getColor()->setARGB('3923A9');
                $event->sheet->getDelegate()->getStyle('A5:AF5')->getFont()->getColor()->setARGB('3923A9');
                
                // block merge cells 
                $sheet->mergeCells('A2:'.$this->register_events_title);
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:'.$this->register_events_title)->getFont()->setName('Khmer OS Muol Pali')
                ->setSize(18)->setUnderline('A2:'.$this->register_events_title);
                $event->sheet->getDelegate()->getStyle('A2:'.$this->register_events_title)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:'.$this->register_events_title_sub_title);
                $sheet->setCellValue('A3',$this->text_title);
                $sheet->getDelegate()->getStyle('A3:'.$this->register_events_title_sub_title)->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12);
                $event->sheet->getDelegate()->getStyle('A3:'.$this->register_events_title_sub_title)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:'.$this->monthly_title);
                $sheet->setCellValue('A4', "ប្រចាំខែមេសា ឆ្នាំ២០២៣");
                $sheet->getDelegate()->getStyle('A4:'.$this->monthly_title)->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:'.$this->monthly_title)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
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
            'O' => 24,
            'P' => 15,
            'Q' => 15,
            'R' => 22,
            'S' => 22,
            'T' => 10,
            'U' => 18,
            'V' => 20,
            'W' => 18,
            'X' => 7,
            'Y' => 17,
            'Z' => 18,
            'AA' => 22,
            'AB' => 17,
            'AC' => 14,
            'AD' => 13,
            'AE' => 15,
            'AF' => 13,
        ];
    }
    public function headings(): array
    {
        return $this->header_table;
    }
}
