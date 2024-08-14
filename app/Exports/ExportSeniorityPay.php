<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Seniority;
use App\Repositories\Admin\EmployeeRepository;
use KhmerDateTime\KhmerDateTime;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportSeniorityPay implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $num;
    protected $export_datas;

    protected $totalAverageSalary;
    protected $totalSalaryReceive;
    protected $totalTaxExemptionSalary;
    protected $totalTaxableSalary;

    public function __construct($datas)
    {
        $num_ = 0;
        foreach ($datas as $key => $value) {
            $num_++;
            $this->num = $num_;
            $this->totalAverageSalary += $value->total_average_salary;
            $this->totalSalaryReceive += $value->total_salary_receive;
            $this->totalTaxExemptionSalary += $value->tax_exemption_salary;
            $this->totalTaxableSalary += $value->taxable_salary;



            $seniority_pay=[
                $num_,
                $value->users == null ? '' : $value->users->number_employee,
                $value->users == null ? '' : $value->users->employee_name_en,
                $value->users == null ? '' : $value->users->EmployeeGender,
                $value->users == null ? '' : $value->users->EmployeePosition,
                $value->users == null ? '' : $value->users->EmployeeBranchAbbreviations,
                $value->users == null ? '' : $value->users->joinOfDate,
                $value->payment_of_month,

                // $value->total_average_salary,
                // $value->total_salary_receive,
                // $value->tax_exemption_salary,
                // $value->taxable_salary,
            ];

            $totalGross =[
                $value->total_average_salary,
                $value->total_salary_receive,
                $value->tax_exemption_salary,
                $value->taxable_salary,
            ];
            // Show data for  gross seniority 1
            if ($value->gross_seniority_1 && count($value->gross_seniority_1) > 0) {
                $gross1 = [];
                if (count($value->gross_seniority_1) == 6) {
                    foreach ($value->gross_seniority_1 as $key => $gruse_salary) {
                        $gross1[] = $gruse_salary->total_seniority;
                    }
                }else{
                    for ( $i = 1; $i <= 6; $i ++) {
                        $currentYear =  Carbon::now()->format('Y');
                        $date = '01-'.'0'.$i.'-'.$currentYear;
                        $month_1 = Carbon::createFromDate($date)->format('m');
                        $filtered = $value->gross_seniority_1->filter(function ($item) use ($month_1) {
                            $month = Carbon::createFromDate($item->payment_date)->format('m');
                            return $month == $month_1;
                        });
                        if (count($filtered) > 0) {
                            $seniority_1 = $filtered->values()->all();
                            $gross1[] = $seniority_1[0]->total_seniority;
                        }else{
                            $gross1[] = "0.00";
                        }
                    }
                }
                $result []= array_merge($seniority_pay, $gross1, $totalGross);
            }
            // Show data for  gross seniority 2
            if ($value->gruse_salary_2 && count($value->gruse_salary_2) > 0) {
                $gross2 = [];
                if (count($value->gruse_salary_2) == 6) {
                    foreach ($value->gruse_salary_2 as $key => $gruse_salary) {
                        $gross2[] = $gruse_salary->total_seniority;
                    }
                }else{
                    for ( $i = 1; $i <= 6; $i ++) {
                        $date_seniority_2 = 6+$i;
                        if ($date_seniority_2 < 10) {
                            $date_seniority_2 = '0'.$date_seniority_2;
                        }
                        $currentYear =  Carbon::now()->format('Y');
                        $date = '01-'.$date_seniority_2.'-'.$currentYear;
                        $month_1 = Carbon::createFromDate($date)->format('m');
                        $filtered = $value->gruse_salary_2->filter(function ($item) use ($month_1) {
                            $month = Carbon::createFromDate($item->payment_date)->format('m');
                            return $month == $month_1;
                        });
                        if (count($filtered) > 0) {
                            $seniority_2 = $filtered->values()->all();
                            $gross2[] = $seniority_2[0]->total_seniority;
                        }else{
                            $gross2[] = "0.00";
                           
                        }
                    }
                }
                $result []= array_merge($seniority_pay, $gross2, $totalGross);
            }
        }
        $this->export_datas = $result;
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
                $event->sheet->getStyle('A5:R5')->applyFromArray([
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
                        $event->sheet->getStyle('A'.$n.':R'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$rows.':R'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A5:R5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:R5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:R5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // block merge cells 
                $sheet->mergeCells('A2:R2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:R2')->getFont()->setSize(18)->setName('Khmer OS Muol Pali')->setUnderline('A2:R2');
                $event->sheet->getDelegate()->getStyle('A2:R2')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:R3');
                $sheet->setCellValue('A3', "តារាងលំអិតអំពីការទូទាត់ប្រាក់បំណាច់អតីតភាពការងាររបស់បុគ្គលិក");
                $sheet->getDelegate()->getStyle('A3:R3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:R3');
                $event->sheet->getDelegate()->getStyle('A3:R3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:R4');
                $sheet->setCellValue('A4',$this->getKhmerMonths());
                $sheet->getDelegate()->getStyle('A4:R4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:R4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //footer
                $sheet->mergeCells('A'.$rows.':N'.$rows);
                $sheet->setCellValue('A'.$rows, "សរុប");
                $sheet->getDelegate()->getStyle("A".$rows.':N'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':N'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue I
                $sheet->setCellValue("O".$rows, $this->totalAverageSalary);
                $sheet->getDelegate()->getStyle("O".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("O".$rows);
                $event->sheet->getDelegate()->getStyle("O".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue J
                $sheet->setCellValue("P".$rows, $this->totalSalaryReceive);
                $sheet->getDelegate()->getStyle("P".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("P".$rows);
                $event->sheet->getDelegate()->getStyle("P".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue J
                $sheet->setCellValue("Q".$rows, $this->totalTaxExemptionSalary);
                $sheet->getDelegate()->getStyle("Q".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("Q".$rows);
                $event->sheet->getDelegate()->getStyle("Q".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue J
                $sheet->setCellValue("R".$rows, $this->totalTaxableSalary);
                $sheet->getDelegate()->getStyle("R".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("R".$rows);
                $event->sheet->getDelegate()->getStyle("R".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

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
            'H' => 20,
            'I' => 18,
            'J' => 15,
            'K' => 15,
            'L' => 15,
            'M' => 15,
            'N' => 15,
            'O' => 15,
            'P' => 20,
            'Q' => 15,
            'R' => 15,
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
            "ទីតាំងការងារ",
            "ថ្ងៃចូលធ្វើការ",
            "ខែដែលទទួលបាន",
            "ខែទី ១/៧",
            "ខែទី ២/៨",
            "ខែទី ៣/៩",
            "ខែទី ៤/១០",
            "ខែទី ៥/១១",
            "ខែទី ៦/១២",
            "ប្រាក់បំណាច់សរុប",
            "ប្រាក់បំណាច់អតីតភាពការងារ",
            "ប្រាក់ខែលើកលែងពន្ធ",
            "ប្រាក់ខែជាប់ពន្ធ",
        ];
    }
}
