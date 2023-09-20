<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Payroll;
use KhmerDateTime\KhmerDateTime;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportEmployeeSalary implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $num;
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
            $i++;
            $this->num = $i;
            $this->totalAmountBasicSalary += $value->basic_salary;
            $this->totalBaseSalaryReceived += $value->total_gross_salary;
            $this->totalChildAllowance += $value->total_child_allowance;
            $this->totalPhoneAllowance += $value->phone_allowance;
            $this->totalMonthlyQuarterlyBonuses += $value->monthly_quarterly_bonuses;
            $this->totalKnyPhcumben += $value->total_kny_phcumben;
            $this->totalAnnualIncentiveBonus += $value->annual_incentive_bonus;
            $this->totalSeniorityPayIncludedTax += $value->seniority_pay_included_tax;
            $this->totalGrossIncludeTax += $value->total_gross;
            $this->totalPensionFund += $value->total_pension_fund;
            $this->TotalBaseSalaryReceivedUsd += $value->base_salary_received_usd;
            $this->totalBaseSalaryReceivedRiel += $value->base_salary_received_riel;
            $this->totalSpouse += $value->spouse;
            $this->totalChildren += $value->children;
            $this->totalChargesReduced += $value->total_charges_reduced;
            $this->totalTaxBaseRiel += $value->total_tax_base_riel;
            $this->totalRate += $value->total_rate;
            $this->totalSalaryTaxUsd += $value->total_salary_tax_usd;
            $this->totalSalaryTaxRiel += $value->total_salary_tax_riel;
            $this->totalSeniorityPayExcludedTax += $value->seniority_pay_excluded_tax;
            $this->totalSeniorityBackford += $value->seniority_backford;
            $this->totalSeverancePay += $value->total_severance_pay;
            $this->totalLoanAmount += $value->loan_amount;
            $this->totalAmountCar += $value->total_amount_car;
            $this->totalSalaryNetPay += $value->total_salary;
            $dataExport[] = [
                "no" => $i,
                "employee_id"       => intval($value->users->number_employee),
                "name"              => Helper::getLang() == 'en' ? $value->users->employee_name_en : $value->users->employee_name_kh,
                "position"          => $value->users->EmployeePosition,
                "department"        => $value->users->EmployeeDepartment,
                "location"          => $value->users->EmployeeBranch,
                "Join Date"         => $value->users->joinOfDate,
                "Basic Salary"      => number_format($value->basic_salary, 2),
                "Base Salary Received"          => number_format($value->total_gross_salary, 2),
                "Child Allowance"               => number_format($value->total_child_allowance),
                "Phone Allowance"               => number_format($value->phone_allowance, 2),
                "Monthly Quarterly Bonuses"     => number_format($value->monthly_quarterly_bonuses, 2),
                "KNY_/_pchum_ben"               => number_format($value->total_kny_phcumben, 2),
                "Annual Incentive Bonus"        => number_format($value->annual_incentive_bonus, 2),
                "Seniority Pay Included Tax"    => number_format($value->seniority_pay_included_tax, 2),
                "Total Gross"                   => number_format($value->total_gross, 2),
                "Pension Fund"                  => number_format($value->total_pension_fund, 2),
                "Base Salary Received USD"      => number_format($value->base_salary_received_usd, 2),
                "Base Salary Received Reil"     => number_format($value->base_salary_received_riel),
                "Spouse"                        => number_format($value->spouse, 2),
                "Dependent Child"               => number_format($value->children, 2),
                "Charges To Be Reduced"         => number_format($value->total_charges_reduced),
                "Total Tax Base Riel"           => number_format($value->total_tax_base_riel),
                "Tax Rate"                      => number_format($value->total_rate, 2),
                "Personal Tax(USD)"             => number_format($value->total_salary_tax_usd, 2),
                "Personal Tax(Riels)"           => number_format($value->total_salary_tax_riel,2),
                "Seniority Pay Excluded Tax"    => number_format($value->seniority_pay_excluded_tax, 2),
                "Seniority Backford"            => number_format($value->seniority_backford, 2),
                "Severance Pay"                 => number_format($value->total_severance_pay, 2),
                "Loan Amount"                   => number_format($value->loan_amount, 2),
                "Total Amount Car"              => number_format($value->total_amount_car, 2),
                "net_salary"                    => abs($value->total_salary)
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
            'B' => 15,
            'C' => 20,
            'D' => 40,
            'E' => 40,
            'F' => 22,
            'G' => 13,
            'H' => 20,
            'I' => 20,
            'J' => 15,
            'K' => 15,
            'L' => 20,
            'M' => 15,
            'N' => 25,
            'O' => 20,
            'P' => 20,
            'Q' => 20,
            'R' => 25,
            'S' => 25,
            'T' => 7,
            'U' => 13,
            'V' => 24,
            'W' => 20,
            'X' => 14,
            'Y' => 20,
            'Z' => 20,
            'AA' => 20,
            'AB' => 20,
            'AC' => 20,
            'AD' => 18,
            'AE' => 20,
            'AF' => 15,
        ];
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
                
                $event->sheet->getStyle('A5:AF5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $n=5;
                if ($this->num > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':AF'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }

                $event->sheet->getStyle('A'.$rows.':AF'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A5:AF5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:AF5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:AF5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                // block merge cells 
                $sheet->mergeCells('A2:AF2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:AF2')->getFont()->setSize(18)->setName('Khmer OS Muol Pali')->setUnderline('A2:AF2');
                $event->sheet->getDelegate()->getStyle('A2:AF2')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:AF3');
                $sheet->setCellValue('A3', "តារាងលំអិតអំពីប្រាក់បៀវត្សរបស់បុគ្គលិក");
                $sheet->getDelegate()->getStyle('A3:AF3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:AF3');
                $event->sheet->getDelegate()->getStyle('A3:AF3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:AF4');
                $sheet->setCellValue('A4',$this->getKhmerMonths());
                $sheet->getDelegate()->getStyle('A4:AF4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:AF4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //footer
                // dd('A'.$rows.':G'.$rows);
                $sheet->mergeCells('A'.$rows.':G'.$rows);
                $sheet->setCellValue('A'.$rows, "សរុប");
                $sheet->getDelegate()->getStyle("A".$rows.':G'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':G'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue H
                $sheet->setCellValue("H".$rows, number_format($this->totalAmountBasicSalary, 2));
                $sheet->getDelegate()->getStyle("H".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("H".$rows);
                $event->sheet->getDelegate()->getStyle("H".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue I
                $sheet->setCellValue("I".$rows, number_format($this->totalBaseSalaryReceived, 2));
                $sheet->getDelegate()->getStyle("I".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("I".$rows);
                $event->sheet->getDelegate()->getStyle("I".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue J
                $sheet->setCellValue("J".$rows, number_format($this->totalChildAllowance, 2));
                $sheet->getDelegate()->getStyle("J".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("J".$rows);
                $event->sheet->getDelegate()->getStyle("J".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue K
                $sheet->setCellValue("K".$rows, number_format($this->totalPhoneAllowance, 2));
                $sheet->getDelegate()->getStyle("K".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("K".$rows);
                $event->sheet->getDelegate()->getStyle("K".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue K
                $sheet->setCellValue("L".$rows, number_format($this->totalMonthlyQuarterlyBonuses, 2));
                $sheet->getDelegate()->getStyle("L".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("L".$rows);
                $event->sheet->getDelegate()->getStyle("L".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue M
                $sheet->setCellValue("M".$rows, number_format($this->totalKnyPhcumben, 2));
                $sheet->getDelegate()->getStyle("M".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("M".$rows);
                $event->sheet->getDelegate()->getStyle("M".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue N
                $sheet->setCellValue("N".$rows, number_format($this->totalAnnualIncentiveBonus, 2));
                $sheet->getDelegate()->getStyle("N".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("N".$rows);
                $event->sheet->getDelegate()->getStyle("N".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue O
                $sheet->setCellValue("O".$rows, number_format($this->totalSeniorityPayIncludedTax, 2));
                $sheet->getDelegate()->getStyle("O".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("O".$rows);
                $event->sheet->getDelegate()->getStyle("O".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue P
                $sheet->setCellValue("P".$rows, number_format($this->totalGrossIncludeTax, 2));
                $sheet->getDelegate()->getStyle("P".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("P".$rows);
                $event->sheet->getDelegate()->getStyle("P".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue Q
                $sheet->setCellValue("Q".$rows, number_format($this->totalPensionFund, 2));
                $sheet->getDelegate()->getStyle("Q".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("Q".$rows);
                $event->sheet->getDelegate()->getStyle("Q".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue R
                $sheet->setCellValue("R".$rows, number_format($this->TotalBaseSalaryReceivedUsd, 2));
                $sheet->getDelegate()->getStyle("R".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("R".$rows);
                $event->sheet->getDelegate()->getStyle("R".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue S
                $sheet->setCellValue("S".$rows, number_format($this->totalBaseSalaryReceivedRiel));
                $sheet->getDelegate()->getStyle("S".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("S".$rows);
                $event->sheet->getDelegate()->getStyle("S".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue T
                $sheet->setCellValue("T".$rows, number_format($this->totalSpouse, 2));
                $sheet->getDelegate()->getStyle("T".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("T".$rows);
                $event->sheet->getDelegate()->getStyle("T".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue U
                $sheet->setCellValue("U".$rows, number_format($this->totalChildren, 2));
                $sheet->getDelegate()->getStyle("U".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("U".$rows);
                $event->sheet->getDelegate()->getStyle("U".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue V
                $sheet->setCellValue("V".$rows, number_format($this->totalChargesReduced, 2));
                $sheet->getDelegate()->getStyle("V".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("V".$rows);
                $event->sheet->getDelegate()->getStyle("V".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue V
                $sheet->setCellValue("W".$rows, number_format($this->totalTaxBaseRiel));
                $sheet->getDelegate()->getStyle("W".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("W".$rows);
                $event->sheet->getDelegate()->getStyle("W".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue X
                $sheet->setCellValue("X".$rows, number_format($this->totalRate, 2));
                $sheet->getDelegate()->getStyle("X".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("X".$rows);
                $event->sheet->getDelegate()->getStyle("X".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue Y
                $sheet->setCellValue("Y".$rows, number_format($this->totalSalaryTaxUsd, 2));
                $sheet->getDelegate()->getStyle("Y".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("Y".$rows);
                $event->sheet->getDelegate()->getStyle("Y".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue Z
                $sheet->setCellValue("Z".$rows, number_format($this->totalSalaryTaxRiel));
                $sheet->getDelegate()->getStyle("Z".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("Z".$rows);
                $event->sheet->getDelegate()->getStyle("Z".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AA
                $sheet->setCellValue("AA".$rows, number_format($this->totalSeniorityPayExcludedTax, 2));
                $sheet->getDelegate()->getStyle("AA".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AA".$rows);
                $event->sheet->getDelegate()->getStyle("AA".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AB
                $sheet->setCellValue("AB".$rows, number_format($this->totalSeniorityBackford, 2));
                $sheet->getDelegate()->getStyle("AB".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AB".$rows);
                $event->sheet->getDelegate()->getStyle("AB".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AC
                $sheet->setCellValue("AC".$rows, number_format($this->totalSeverancePay, 2));
                $sheet->getDelegate()->getStyle("AC".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AB".$rows);
                $event->sheet->getDelegate()->getStyle("AC".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AD
                $sheet->setCellValue("AD".$rows, number_format($this->totalLoanAmount, 2));
                $sheet->getDelegate()->getStyle("AD".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AD".$rows);
                $event->sheet->getDelegate()->getStyle("AD".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AE
                $sheet->setCellValue("AE".$rows, number_format($this->totalAmountCar, 2));
                $sheet->getDelegate()->getStyle("AE".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AE".$rows);
                $event->sheet->getDelegate()->getStyle("AE".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue AF
                $sheet->setCellValue("AF".$rows, number_format(abs($this->totalSalaryNetPay), 2));
                $sheet->getDelegate()->getStyle("AF".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("AF".$rows);
                $event->sheet->getDelegate()->getStyle("AF".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
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
    
    public function headings(): array
    {
        return [
            "ល.រ",
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
    }
}
