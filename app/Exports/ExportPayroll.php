<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bonus;
use App\Helpers\Helper;
use App\Models\Payroll;
use App\Models\Seniority;
use App\Models\SeverancePay;
use KhmerDateTime\KhmerDateTime;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\NationalSocialSecurityFund;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportPayroll implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $register_events_title;
    protected $register_events_title_sub_title;
    protected $monthly_title;
    protected $text_title;
    protected $header_table;
    protected $export_datas;


    protected $totalAmountBasicSalary;
    protected $totalBaseSalaryReceived;
    protected $totalChildAllowance;
    protected $totalPhoneAllowance;
    protected $totalMonthlyQuarterlyBonuses;
    protected $totalKnyPhcumben;
    protected $totalAnnualIncentiveBonus;
    protected $totalSeniorityPayIncludedTax;
    protected $totalGrossIncludeTax;
    protected $totalPensionFund;
    protected $TotalBaseSalaryReceivedUsd;
    protected $totalBaseSalaryReceivedRiel;
    protected $totalSpouse;
    protected $totalChildren;
    protected $totalChargesReduced;
    protected $totalTaxBaseRiel;
    protected $totalRate;
    protected $totalSalaryTaxUsd;
    protected $totalSalaryTaxRiel;
    protected $totalSeniorityPayExcludedTax;
    protected $totalSeniorityBackford;
    protected $totalSeverancePay;
    protected $totalLoanAmount;
    protected $totalAmountCar;
    protected $totalSalaryNetPay;
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
            $this->register_events_title = "AE2";
            $this->register_events_title_sub_title = "AE3";
            $this->monthly_title = 'AE4';
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
                "ប័ណ្ណ ការងារ",
                "នាម និង គោត្តនាម",
                "មុខងារ",
                "នាយកដ្ឋាន",
                "ទីតាំងការងារ",
                "ថ្ងៃចូលធ្វើការ",
                "បៀវត្សគោលចុងគ្រា($)",
                "បៀវត្សគោល ទទួលបាន($)",
                "ឧបត្ថម្ភ កូនប្រាក់($)",
                "ប្រាក់ឧបត្ថម្ភថ្លែកាតទូរស័ព្ទ",
                "ប្រាក់រង្វាន់លើកទឹកចិត្តប្រចាំខែនិងប្រចាំត្រីមាស",
                "ប្រាកឧបត្ថម្ភចូលឆ្នាំ &ភ្ជុំបិណ្ឌ",
                "ប្រាក់រង្វាន់លើកទឹកចិត្តប្រចាំឆ្នាំ",
                "ប្រាក់ជាប់ពន្ធលើប្រាក់បំណាច់អតីតភាពការងារ",
                "បៀវត្ស​គោលទទួលបាន($)",
                "ភាគទានសោធនពីបុគ្គលិក2%",
                "បៀវត្ស​គោលទទួលបានដុល្លារ",
                "បៀវត្ស​គោលទទួលបានរៀល",
                "ប្តី/ប្រពន្ធ",
                "កូនក្នុងបន្ទុក",
                "ទឹកប្រាក់បន្ទុកត្រូវកាត់បន្ថយ",
                "មូលដ្ឋានគិតពន្ធរៀល",
                "អត្រា ពន្ធ(%)",
                "ពន្ធលើប្រាក់បៀវត្សដុល្លារ",
                "ពន្ធលើប្រាក់បៀវត្សរៀល",
                "ប្រាក់បំណាច់អតីតភាពការងារអត់ជាប់ពន្ធ",
                "ប្រាក់រំលឹកអតីតភាពការងារ",
                "ប្រាក់បំណាច់កិច្ចសន្យា",
                "ចំនួនប្រាក់កម្ចី",
                "ប្រាកឧបត្ថម្ភថ្លៃផ្ញើរឡាន",
                "បៀវត្ស​ត្រូវទទួល បានបន្ទាប់ពីដកពន្ធ($)"
            ];
            foreach ($datas as $pay) {
                $this->totalAmountBasicSalary += $pay->basic_salary;
                $this->totalBaseSalaryReceived += $pay->total_gross_salary;
                $this->totalChildAllowance += $pay->total_child_allowance;
                $this->totalPhoneAllowance += $pay->phone_allowance;
                $this->totalMonthlyQuarterlyBonuses += $pay->monthly_quarterly_bonuses;
                $this->totalKnyPhcumben += $pay->total_kny_phcumben;
                $this->totalAnnualIncentiveBonus += $pay->annual_incentive_bonus;
                $this->totalSeniorityPayIncludedTax += $pay->seniority_pay_included_tax;
                $this->totalGrossIncludeTax += $pay->total_gross;
                $this->totalPensionFund += $pay->total_pension_fund;
                $this->TotalBaseSalaryReceivedUsd += $pay->base_salary_received_usd;
                $this->totalBaseSalaryReceivedRiel += $pay->base_salary_received_riel;
                $this->totalSpouse += $pay->spouse;
                $this->totalChildren += $pay->children;
                $this->totalChargesReduced += $pay->total_charges_reduced;
                $this->totalTaxBaseRiel += $pay->total_tax_base_riel;
                $this->totalRate += $pay->total_rate;
                $this->totalSalaryTaxUsd += $pay->total_salary_tax_usd;
                $this->totalSalaryTaxRiel += $pay->total_salary_tax_riel;
                $this->totalSeniorityPayExcludedTax += $pay->seniority_pay_excluded_tax;
                $this->totalSeniorityBackford += $pay->seniority_backford;
                $this->totalSeverancePay += $pay->total_severance_pay;
                $this->totalLoanAmount += $pay->loan_amount;
                $this->totalAmountCar += $pay->total_amount_car;
                $this->totalSalaryNetPay += $pay->total_salary;

                $payroll[]=[
                    $pay->users == null ? '' : intval($pay->users->number_employee),
                    Helper::getLang() == 'en' ? $pay->users->employee_name_en : $pay->users->employee_name_kh,
                    $pay->users == null ? '' : $pay->users->EmployeeDepartment,
                    $pay->users == null ? '' : $pay->users->EmployeePosition,
                    $pay->users == null ? '' : $pay->users->EmployeeBranch,
                    $pay->users == null ? '' : $pay->users->joinOfDate,
                    $pay->basic_salary,
                    $pay->total_gross_salary,
                    $pay->total_child_allowance ?? '0',
                    $pay->phone_allowance ?? '0',
                    $pay->monthly_quarterly_bonuses,
                    $pay->total_kny_phcumben,
                    $pay->annual_incentive_bonus,
                    $pay->seniority_pay_included_tax,
                    $pay->total_gross,
                    $pay->total_pension_fund,
                    $pay->base_salary_received_usd,
                    $pay->base_salary_received_riel,
                    $pay->spouse ?? '0',
                    $pay->children ?? '0',
                    $pay->total_charges_reduced,
                    $pay->total_tax_base_riel,
                    $pay->total_rate ?? '0',
                    $pay->total_salary_tax_usd,
                    $pay->total_salary_tax_riel,
                    $pay->seniority_pay_excluded_tax,
                    $pay->seniority_backford ?? '0',
                    $pay->total_severance_pay ?? '0',
                    $pay->loan_amount ?? '0',
                    $pay->total_amount_car ?? '0',
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
                $rows = count($this->export_datas) + 5 + 1;
                
                //SetHeaderColor
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->getColor()->setARGB('DD4B39');
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->getColor()->setARGB('0000CC');
                $event->sheet->getDelegate()->getStyle('A4')->getFont()->getColor()->setARGB('3923A9');
                $event->sheet->getStyle('A5:AE5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A'.$rows.':AE'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A5:AE5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:AE5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:AE5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

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
                $sheet->setCellValue('A4', $this->getKhmerMonths());
                $sheet->getDelegate()->getStyle('A4:'.$this->monthly_title)->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:'.$this->monthly_title)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // dd('A'.$rows.':G'.$rows);
                $sheet->mergeCells('A'.$rows.':F'.$rows);
                $sheet->setCellValue('A'.$rows, "សរុប");
                $sheet->getDelegate()->getStyle("A".$rows.':F'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':F'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue G
                $sheet->setCellValue("G".$rows, $this->totalAmountBasicSalary);
                $sheet->getDelegate()->getStyle("G".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("G".$rows);
                $event->sheet->getDelegate()->getStyle("G".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue H
                $sheet->setCellValue("H".$rows, number_format($this->totalBaseSalaryReceived, 2));
                $sheet->getDelegate()->getStyle("H".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("H".$rows);
                $event->sheet->getDelegate()->getStyle("H".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue I
                $sheet->setCellValue("I".$rows, number_format($this->totalChildAllowance, 2));
                $sheet->getDelegate()->getStyle("I".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("I".$rows);
                $event->sheet->getDelegate()->getStyle("J".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue J
                $sheet->setCellValue("J".$rows, number_format($this->totalPhoneAllowance, 2));
                $sheet->getDelegate()->getStyle("J".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("J".$rows);
                $event->sheet->getDelegate()->getStyle("J".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue K
                $sheet->setCellValue("K".$rows, number_format($this->totalMonthlyQuarterlyBonuses, 2));
                $sheet->getDelegate()->getStyle("K".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("K".$rows);
                $event->sheet->getDelegate()->getStyle("K".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue L
                $sheet->setCellValue("L".$rows, number_format($this->totalKnyPhcumben, 2));
                $sheet->getDelegate()->getStyle("L".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("L".$rows);
                $event->sheet->getDelegate()->getStyle("L".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue M
                $sheet->setCellValue("M".$rows, number_format($this->totalAnnualIncentiveBonus, 2));
                $sheet->getDelegate()->getStyle("M".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("M".$rows);
                $event->sheet->getDelegate()->getStyle("M".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue N
                $sheet->setCellValue("N".$rows, number_format($this->totalSeniorityPayIncludedTax, 2));
                $sheet->getDelegate()->getStyle("N".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("N".$rows);
                $event->sheet->getDelegate()->getStyle("N".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue O
                $sheet->setCellValue("O".$rows, number_format($this->totalGrossIncludeTax, 2));
                $sheet->getDelegate()->getStyle("O".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("O".$rows);
                $event->sheet->getDelegate()->getStyle("O".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue P
                $sheet->setCellValue("P".$rows, number_format($this->totalPensionFund, 2));
                $sheet->getDelegate()->getStyle("P".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("P".$rows);
                $event->sheet->getDelegate()->getStyle("P".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue Q
                $sheet->setCellValue("Q".$rows, number_format($this->TotalBaseSalaryReceivedUsd, 2));
                $sheet->getDelegate()->getStyle("Q".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("Q".$rows);
                $event->sheet->getDelegate()->getStyle("Q".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue R
                $sheet->setCellValue("R".$rows, number_format($this->totalBaseSalaryReceivedRiel, 2));
                $sheet->getDelegate()->getStyle("R".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("R".$rows);
                $event->sheet->getDelegate()->getStyle("R".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue S
                $sheet->setCellValue("S".$rows, number_format($this->totalSpouse, 2));
                $sheet->getDelegate()->getStyle("S".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("S".$rows);
                $event->sheet->getDelegate()->getStyle("S".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue T
                $sheet->setCellValue("T".$rows, number_format($this->totalChildren, 2));
                $sheet->getDelegate()->getStyle("T".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("T".$rows);
                $event->sheet->getDelegate()->getStyle("T".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue U
                $sheet->setCellValue("U".$rows, number_format($this->totalChargesReduced, 2));
                $sheet->getDelegate()->getStyle("U".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("U".$rows);
                $event->sheet->getDelegate()->getStyle("U".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue V
                $sheet->setCellValue("V".$rows, number_format($this->totalTaxBaseRiel, 2));
                $sheet->getDelegate()->getStyle("V".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("V".$rows);
                $event->sheet->getDelegate()->getStyle("V".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue W
                $sheet->setCellValue("W".$rows, number_format($this->totalRate, 2));
                $sheet->getDelegate()->getStyle("W".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("W".$rows);
                $event->sheet->getDelegate()->getStyle("W".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue X
                $sheet->setCellValue("X".$rows, number_format($this->totalSalaryTaxUsd, 2));
                $sheet->getDelegate()->getStyle("X".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("X".$rows);
                $event->sheet->getDelegate()->getStyle("X".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue Y
                $sheet->setCellValue("Y".$rows, number_format($this->totalSalaryTaxRiel, 2));
                $sheet->getDelegate()->getStyle("Y".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("Y".$rows);
                $event->sheet->getDelegate()->getStyle("Y".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue Z
                $sheet->setCellValue("Z".$rows, number_format($this->totalSeniorityPayExcludedTax, 2));
                $sheet->getDelegate()->getStyle("Z".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("Z".$rows);
                $event->sheet->getDelegate()->getStyle("Z".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AA
                $sheet->setCellValue("AA".$rows, number_format($this->totalSeniorityBackford, 2));
                $sheet->getDelegate()->getStyle("AA".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AA".$rows);
                $event->sheet->getDelegate()->getStyle("AA".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AB
                $sheet->setCellValue("AB".$rows, number_format($this->totalSeverancePay, 2));
                $sheet->getDelegate()->getStyle("AB".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AB".$rows);
                $event->sheet->getDelegate()->getStyle("AB".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AC
                $sheet->setCellValue("AC".$rows, number_format($this->totalLoanAmount, 2));
                $sheet->getDelegate()->getStyle("AC".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AC".$rows);
                $event->sheet->getDelegate()->getStyle("AC".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AD
                $sheet->setCellValue("AD".$rows, number_format($this->totalAmountCar, 2));
                $sheet->getDelegate()->getStyle("AD".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AD".$rows);
                $event->sheet->getDelegate()->getStyle("AD".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AE
                $sheet->setCellValue("AE".$rows, number_format($this->totalSalaryNetPay, 2));
                $sheet->getDelegate()->getStyle("AE".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AE".$rows);
                $event->sheet->getDelegate()->getStyle("AE".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }

    public function getKhmerMonths(){
        $month = Carbon::now()->format('Y-m-d');
        $dateTime = KhmerDateTime::parse($month);
        $monthKH = $dateTime->fullMonth();
        $yearKH = $dateTime->year();
        $result = "ប្រចាំខែ".$monthKH.' '.'ឆ្នាំ'.$yearKH;
        return $result;
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
            'L' => 15,
            'M' => 20,
            'N' => 23,
            'O' => 24,
            'P' => 15,
            'Q' => 15,
            'R' => 22,
            'S' => 10,
            'T' => 10,
            'U' => 18,
            'V' => 20,
            'W' => 10,
            'X' => 20,
            'Y' => 20,
            'Z' => 18,
            'AA' => 22,
            'AB' => 17,
            'AC' => 14,
            'AD' => 13,
            'AE' => 15
        ];
    }
    public function headings(): array
    {
        return $this->header_table;
    }
}
