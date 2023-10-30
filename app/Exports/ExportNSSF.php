<?php

namespace App\Exports;

use Carbon\Carbon;
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

class ExportNSSF implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $num;
    protected $export_datas;

    protected $totalPreTaxSalaryUsd;
    protected $totalPreTaxSalaryRiel;
    protected $totalAverageWage;
    protected $totalOccupationalRisk;
    protected $totalHealthCare;
    protected $pensionContributionUsd;
    protected $pensionContributionRiel;
    protected $corporateContribution;

    public function __construct($request)
    {
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $nssf=[];
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
            $query->whereMonth('national_social_security_funds.payment_date', $Monthly);
        })
        ->when($yearLy, function ($query, $yearLy) {
            $query->whereYear('national_social_security_funds.payment_date', $yearLy);
        })->get();
        $i = 1;
        foreach ($datas as $key => $value) {
            $i++;
            $this->num = $i;
            $this->totalPreTaxSalaryUsd += $value->total_pre_tax_salary_usd;
            $this->totalPreTaxSalaryRiel += $value->total_pre_tax_salary_riel;
            $this->totalAverageWage += $value->total_average_wage;
            $this->totalOccupationalRisk += $value->total_occupational_risk;
            $this->totalHealthCare += $value->total_health_care;
            $this->pensionContributionUsd += $value->pension_contribution_usd;
            $this->pensionContributionRiel += $value->pension_contribution_riel;
            $this->corporateContribution += $value->corporate_contribution;
            $nssf[]=[
                $i,
                $value->users == null ? '' : intval($value->users->number_employee),
                $value->users == null ? '' : $value->users->employee_name_en,
                $value->users == null ? '' : $value->users->EmployeeGender,
                $value->users == null ? '' : $value->users->EmployeePosition,
                $value->users == null ? '' : $value->users->joinOfDate,
                $value->total_pre_tax_salary_usd,
                number_format($value->total_pre_tax_salary_riel),
                number_format($value->total_average_wage),
                number_format($value->total_occupational_risk),
                number_format($value->total_health_care),
                number_format($value->pension_contribution_usd),
                $value->pension_contribution_riel,
                number_format($value->corporate_contribution)
            ];
        }
        $this->export_datas = $nssf;
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
                $event->sheet->getStyle('A5:N5')->applyFromArray([
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
                        $event->sheet->getStyle('A'.$n.':N'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$rows.':N'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A5:N5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:N5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:N5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // block merge cells 
                $sheet->mergeCells('A2:N2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:N2')->getFont()->setSize(18)->setName('Khmer OS Muol Pali')->setUnderline('A2:N2');
                $event->sheet->getDelegate()->getStyle('A2:N2')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:N3');
                $sheet->setCellValue('A3', "តារាងបង់ភាគទានលើហានិ.ការងារ ថែទាំសុខភាព និងផែ្នកសោធន");
                $sheet->getDelegate()->getStyle('A3:N3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:N3');
                $event->sheet->getDelegate()->getStyle('A3:N3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:N4');
                $sheet->setCellValue('A4',$this->getKhmerMonths());
                $sheet->getDelegate()->getStyle('A4:N4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:N4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //footer
                $sheet->mergeCells('A'.$rows.':F'.$rows);
                $sheet->setCellValue('A'.$rows, "សរុប");
                $sheet->getDelegate()->getStyle("A".$rows.':F'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':F'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue G
                $sheet->setCellValue("G".$rows, number_format($this->totalPreTaxSalaryUsd, 2));
                $sheet->getDelegate()->getStyle("G".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("G".$rows);
                $event->sheet->getDelegate()->getStyle("G".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue H
                $sheet->setCellValue("H".$rows, number_format($this->totalPreTaxSalaryRiel));
                $sheet->getDelegate()->getStyle("H".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("H".$rows);
                $event->sheet->getDelegate()->getStyle("H".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue I
                $sheet->setCellValue("I".$rows, number_format($this->totalAverageWage,2));
                $sheet->getDelegate()->getStyle("I".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("I".$rows);
                $event->sheet->getDelegate()->getStyle("I".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue J
                $sheet->setCellValue("J".$rows, number_format($this->totalOccupationalRisk,2));
                $sheet->getDelegate()->getStyle("J".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("J".$rows);
                $event->sheet->getDelegate()->getStyle("J".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue K
                $sheet->setCellValue("K".$rows, number_format($this->totalHealthCare,2));
                $sheet->getDelegate()->getStyle("K".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("K".$rows);
                $event->sheet->getDelegate()->getStyle("K".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue L
                $sheet->setCellValue("L".$rows, number_format($this->pensionContributionUsd));
                $sheet->getDelegate()->getStyle("L".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("L".$rows);
                $event->sheet->getDelegate()->getStyle("L".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue M
                $sheet->setCellValue("M".$rows, number_format($this->pensionContributionRiel,2));
                $sheet->getDelegate()->getStyle("M".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("M".$rows);
                $event->sheet->getDelegate()->getStyle("M".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue N
                $sheet->setCellValue("N".$rows, number_format($this->corporateContribution,2));
                $sheet->getDelegate()->getStyle("N".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("N".$rows);
                $event->sheet->getDelegate()->getStyle("N".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
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
            'A' => 5,
            'B' => 10,
            'C' => 30,
            'D' => 10,
            'E' => 20,
            'F' => 15,
            'G' => 15,
            'H' => 14,
            'I' => 18,
            'J' => 15,
            'K' => 20,
            'L' => 15,
            'M' => 20,
            'N' => 10
        ];
    }
    public function headings(): array
    {
        return [
            "ល.រ",
            "ប័ណ្ណ ការងារ",
            "គោត្តនាម និងនាម",
            "ភេទ",
            "មុខងារ",
            "ថ្ងៃចូលធ្វើការ",
            "បៀវត្សសរុបមុនបង់ពន្ធដុល្លារ",
            "បៀវត្សសរុបមុនបង់ពន្ធរៀល",
            "ប្រាក់ឈ្នួលមធ្យម",
            "ហានិ.ការងារ",
            "ថែទាំសុខភាព",
            "ភាគទានស.ធ កម្មករនិយោជិតដុល្លារ",
            "ភាគទានស.ធ កម្មករនិយោជិតរៀល",
            "ភាគទានស.ធ សហគ្រាស"
        ];
    }
}
