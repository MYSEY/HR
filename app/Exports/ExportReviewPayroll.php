<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Helpers\Helper;
use KhmerDateTime\KhmerDateTime;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportReviewPayroll implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
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
    protected $totalOtherBenefits;
    protected $totalSeniorityPayIncludedTax;
    protected $totalAdjustmentIncludeTaxe;
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
    protected $totalAdjustmentExclude;
    protected $totalSeverancePay;
    protected $totalLoanAmount;
    protected $totalStaffBook;
    protected $totalAmountCar;
    protected $totalSalaryNetPay;
    protected $totalSalaryNetPayKh;
    public function __construct($data)
    {
        $dataExport = [];
        $i = 0;
        foreach ($data as $value) {
            $i++;
            $this->num = $i;
            $this->totalAmountBasicSalary += $value->basic_salary;
            $this->totalBaseSalaryReceived += $value->total_gross_salary;
            $this->totalChildAllowance += $value->total_child_allowance;
            $this->totalPhoneAllowance += $value->phone_allowance;
            $this->totalMonthlyQuarterlyBonuses += $value->monthly_quarterly_bonuses;
            $this->totalKnyPhcumben += $value->total_kny_phcumben;
            $this->totalAnnualIncentiveBonus += $value->annual_incentive_bonus;
            $this->totalOtherBenefits += $value->other_benefits;
            $this->totalSeniorityPayIncludedTax += $value->seniority_pay_included_tax;
            $this->totalAdjustmentIncludeTaxe += $value->adjustment_include_taxe;
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
            $this->totalAdjustmentExclude += $value->adjustment;
            $this->totalSeverancePay += $value->total_severance_pay;
            $this->totalLoanAmount += $value->loan_amount;
            $this->totalStaffBook += $value->total_staff_book;
            $this->totalAmountCar += $value->total_amount_car;
            $this->totalSalaryNetPay += $value->total_salary;
            $totalSalaryTaxRiel = $value->total_salary_tax_riel;
            $total_salary = $value->total_salary;
            $this->totalSalaryNetPayKh += $total_salary * $value->exchange_rate;
            $dataExport[] = [
                "no" => $i,
                "employee_id"       => $value->users->number_employee,
                "name"              => Helper::getLang() == 'en' ? $value->users->employee_name_en : $value->users->employee_name_kh,
                "Gender"             => $value->name_khmer,
                "position"          => $value->post_name_en,
                "department"        => $value->depart_name_en,
                "location"          => $value->branch_name_en,
                "Join Date"         => $value->date_of_commencement,
                "Basic Salary"      => $value->basic_salary,
                "Base Salary Received"          => $value->total_gross_salary,
                "Child Allowance"               => $value->total_child_allowance,
                "Phone Allowance"               => $value->phone_allowance,
                "Monthly Quarterly Bonuses"     => $value->monthly_quarterly_bonuses,
                "KNY_/_pchum_ben"               => $value->total_kny_phcumben,
                "Annual Incentive Bonus"        => $value->annual_incentive_bonus,
                "other benefits"               => $value->other_benefits,
                "Seniority Pay Included Tax"    => $value->seniority_pay_included_tax,
                "Adjustment Included Tax"       => $value->adjustment_include_taxe,
                "Total Gross"                   => $value->total_gross,
                "Pension Fund"                  => $value->total_pension_fund,
                "Base Salary Received USD"      => $value->base_salary_received_usd,
                "Base Salary Received Reil"     => $value->base_salary_received_riel,
                "Spouse"                        => $value->spouse,
                "Dependent Child"               => $value->children,
                "Charges To Be Reduced"         => $value->total_charges_reduced,
                "Total Tax Base Riel"           => $value->total_tax_base_riel,
                "Tax Rate"                      => $value->total_rate == 0.0 ? '0' : $value->total_rate,
                "Personal Tax(USD)"             => $value->total_salary_tax_usd,
                "Personal Tax(Riels)"           => $totalSalaryTaxRiel,
                "Seniority Pay Excluded Tax"    => $value->seniority_pay_excluded_tax,
                "Adjustment Excluded Tax"       => $value->adjustment,
                "Seniority Backford"            => $value->seniority_backford,
                "Severance Pay"                 => $value->total_severance_pay,
                "Loan Amount"                   => $value->loan_amount == 0.0 ? '0' : $value->loan_amount,
                "total_staff_book"              => $value->total_staff_book,
                "Total Amount Car"              => $value->total_amount_car,
                "net_salary"                    => $total_salary,
                "net_salary_kh"                 => $total_salary * $value->exchange_rate,
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
            'D' => 5,
            'E' => 40,
            'F' => 22,
            'G' => 13,
            'H' => 10,
            'I' => 15,
            'J' => 20,
            'K' => 10,
            'L' => 15,
            'M' => 20,
            'N' => 15,
            'O' => 20,
            'P' => 15,
            'Q' => 20,
            'R' => 20,
            'S' => 20,
            'T' => 20,
            'U' => 20,
            'V' => 15,
            'W' => 5,
            'X' => 10,
            'Y' => 20,
            'Z' => 14,
            'AA' => 10,
            'AB' => 20,
            'AC' => 20,
            'AD' => 20,
            'AE' => 22,
            'AF' => 20,
            'AG' => 18,
            'AH' => 10,
            'AI' => 15,
            'AJ' => 15,
            'AK' => 15,
            'AL' => 15,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet */
                $sheet = $event->sheet;
                $rows = count($this->export_datas) + 5 + 1;

                // Set header color
                $sheet->getStyle('A2')->getFont()->getColor()->setARGB('DD4B39');
                $sheet->getStyle('A3')->getFont()->getColor()->setARGB('0000CC');
                $sheet->getStyle('A4')->getFont()->getColor()->setARGB('3923A9');

                $sheet->getStyle('A5:AL5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $n = 5;
                if ($this->num > 0) {
                    foreach ($this->export_datas as $key => $value) {
                        $n++;
                        $sheet->getStyle('A' . $n . ':AL' . $n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }

                $sheet->getStyle('A' . $rows . ':AL' . $rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle('A5:AL5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getStyle('A5:AL5')->getFont()->setSize(9)->setName('Khmer OS Battambang');
                $sheet->getStyle('A5:AL5')->getAlignment()
                    ->setWrapText(true)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // block merge cells
                $sheet->mergeCells('A2:AF2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getStyle('A2:AF2')->getFont()->setSize(18)->setName('Khmer OS Muol Pali')->setUnderline(true);
                $sheet->getStyle('A2:AF2')->getAlignment()
                    ->setWrapText(true)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:AF3');
                $sheet->setCellValue('A3', "តារាងលំអិតអំពីប្រាក់បៀវត្សរបស់បុគ្គលិក");
                $sheet->getStyle('A3:AF3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline(true);
                $sheet->getStyle('A3:AF3')->getAlignment()
                    ->setWrapText(true)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:AF4');
                $sheet->setCellValue('A4', $this->getKhmerMonths());
                $sheet->getStyle('A4:AF4')->getFont()->setSize(9)->setName('Khmer OS Fasthand');
                $sheet->getStyle('A4:AF4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // footer
                $sheet->mergeCells('A' . $rows . ':H' . $rows);
                $sheet->setCellValue('A' . $rows, "សរុប");
                $sheet->getStyle('A' . $rows . ':H' . $rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $sheet->getStyle('A' . $rows . ':H' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue H
                $sheet->getStyle('H' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('H' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue I
                $sheet->setCellValue('I' . $rows, number_format($this->totalAmountBasicSalary, 2));
                $sheet->getStyle('I' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('I' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue J
                $sheet->setCellValue('J' . $rows, number_format($this->totalBaseSalaryReceived, 2));
                $sheet->getStyle('J' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('J' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue K
                $sheet->setCellValue('K' . $rows, number_format($this->totalChildAllowance, 2));
                $sheet->getStyle('K' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('K' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue L
                $sheet->setCellValue('L' . $rows, number_format($this->totalPhoneAllowance, 2));
                $sheet->getStyle('L' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('L' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue M
                $sheet->setCellValue('M' . $rows, number_format($this->totalMonthlyQuarterlyBonuses, 2));
                $sheet->getStyle('M' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('M' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue N
                $sheet->setCellValue('N' . $rows, number_format($this->totalKnyPhcumben, 2));
                $sheet->getStyle('N' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('N' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue O
                $sheet->setCellValue('O' . $rows, number_format($this->totalAnnualIncentiveBonus, 2));
                $sheet->getStyle('O' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('O' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue P
                $sheet->setCellValue('P' . $rows, number_format($this->totalOtherBenefits, 2));
                $sheet->getStyle('P' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('P' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue Q
                $sheet->setCellValue('Q' . $rows, number_format($this->totalSeniorityPayIncludedTax, 2));
                $sheet->getStyle('Q' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('Q' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue R
                $sheet->setCellValue('R' . $rows, number_format($this->totalAdjustmentIncludeTaxe, 2));
                $sheet->getStyle('R' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('R' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue S
                $sheet->setCellValue('S' . $rows, number_format($this->totalGrossIncludeTax, 2));
                $sheet->getStyle('S' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('S' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue T
                $sheet->setCellValue('T' . $rows, number_format($this->totalPensionFund, 2));
                $sheet->getStyle('T' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('T' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue U
                $sheet->setCellValue('U' . $rows, number_format($this->TotalBaseSalaryReceivedUsd, 2));
                $sheet->getStyle('U' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('U' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue V
                $sheet->setCellValue('V' . $rows, number_format($this->totalBaseSalaryReceivedRiel));
                $sheet->getStyle('V' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('V' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue W
                $sheet->setCellValue('W' . $rows, number_format($this->totalSpouse, 2));
                $sheet->getStyle('W' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('W' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue X
                $sheet->setCellValue('X' . $rows, number_format($this->totalChildren, 2));
                $sheet->getStyle('X' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('X' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue Y
                $sheet->setCellValue('Y' . $rows, number_format($this->totalChargesReduced));
                $sheet->getStyle('Y' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('Y' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue Z
                $sheet->setCellValue('Z' . $rows, number_format($this->totalTaxBaseRiel));
                $sheet->getStyle('Z' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('Z' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AA
                $sheet->setCellValue('AA' . $rows, number_format($this->totalRate, 2));
                $sheet->getStyle('AA' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AA' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AB
                $sheet->setCellValue('AB' . $rows, number_format($this->totalSalaryTaxUsd, 2));
                $sheet->getStyle('AB' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AB' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AC
                $sheet->setCellValue('AC' . $rows, number_format($this->totalSalaryTaxRiel));
                $sheet->getStyle('AC' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AC' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AD
                $sheet->setCellValue('AD' . $rows, number_format($this->totalSeniorityPayExcludedTax, 2));
                $sheet->getStyle('AD' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AD' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AE
                $sheet->setCellValue('AE' . $rows, number_format($this->totalAdjustmentExclude, 2));
                $sheet->getStyle('AE' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AE' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AF
                $sheet->setCellValue('AF' . $rows, number_format($this->totalSeniorityBackford, 2));
                $sheet->getStyle('AF' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AF' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AG
                $sheet->setCellValue('AG' . $rows, number_format($this->totalSeverancePay, 2));
                $sheet->getStyle('AG' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AG' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AH
                $sheet->setCellValue('AH' . $rows, number_format($this->totalLoanAmount, 2));
                $sheet->getStyle('AH' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AH' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AI
                $sheet->setCellValue('AI' . $rows, number_format($this->totalStaffBook, 2));
                $sheet->getStyle('AI' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AI' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AJ
                $sheet->setCellValue('AJ' . $rows, number_format($this->totalAmountCar, 2));
                $sheet->getStyle('AJ' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AJ' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AK
                $sheet->setCellValue('AK' . $rows, number_format(abs($this->totalSalaryNetPay), 2));
                $sheet->getStyle('AK' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AK' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                // total setCellValue AL
                $sheet->setCellValue('AL' . $rows, number_format(abs($this->totalSalaryNetPayKh), 2));
                $sheet->getStyle('AL' . $rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold(true);
                $sheet->getStyle('AL' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
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
            "ភេទ",
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
            "អត្ថប្រយោជន៍ផ្សេងៗ",
            "ប្រាក់ជាប់ពន្ធលើប្រាក់បំណាច់អតីតភាពការងារ",
            "ប្រាក់បន្ថែ/បន្ថយមុនកាត់ពន្ធ ខែចាស់/ថ្មី",
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
            "ប្រាក់បន្ថែ/បន្ថយក្រោយកាត់ពន្ធ​ ខែចាស់/ថ្មី",
            "ប្រាក់រំលឹកអតីតភាពការងារ",
            "ប្រាក់បំណាច់កិច្ចសន្យា",
            "ចំនួនប្រាក់កម្ចី",
            "សៀវភៅបុគ្គលិកសរុប",
            "ប្រាកឧបត្ថម្ភថ្លៃផ្ញើរឡាន",
            "បៀវត្ស​ត្រូវទទួល បានបន្ទាប់ពីដកពន្ធ($)",
            "បៀវត្ស​ត្រូវទទួល បានបន្ទាប់ពីដកពន្ធ(រៀល)",
        ];
    }
}
