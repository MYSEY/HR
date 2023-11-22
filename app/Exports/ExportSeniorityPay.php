<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Seniority;
use KhmerDateTime\KhmerDateTime;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
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

    public function __construct($request)
    {
        $Monthly = null;
        $yearLy = null;
        if ($request->filter_month) {
            $Monthly = Carbon::createFromDate($request->filter_month)->format('m');
            $yearLy = Carbon::createFromDate($request->filter_month)->format('Y');
        }
        $seniority_pay=[];
        $datas = Seniority::with("users")
        ->join('users', 'seniorities.employee_id', '=', 'users.id')
        ->select(
            'seniorities.*',
            'users.number_employee',
            'users.employee_name_en',
            'users.employee_name_kh'
        )
        ->when($request->employee_id, function ($query, $employee_id) {
            $query->where('users.number_employee', 'LIKE', '%'.$employee_id.'%');
        })
        ->when($request->employee_name, function ($query, $employee_name) {
            $query->where('users.employee_name_en', 'LIKE', '%'.$employee_name.'%');
        })
        ->when($Monthly, function ($query, $Monthly) {
            $query->whereMonth('seniorities.payment_date', $Monthly);
        })
        ->when($yearLy, function ($query, $yearLy) {
            $query->whereYear('seniorities.payment_date', $yearLy);
        })->get();
        $i = 0;
        foreach ($datas as $key => $value) {
            $i++;
            $this->num = $i;
            $this->totalAverageSalary += $value->total_average_salary;
            $this->totalSalaryReceive += $value->total_salary_receive;
            $this->totalTaxExemptionSalary += $value->tax_exemption_salary;
            $this->totalTaxableSalary += $value->taxable_salary;
            $seniority_pay[]=[
                $i,
                $value->users == null ? '' : $value->users->number_employee,
                $value->users == null ? '' : $value->users->employee_name_en,
                $value->users == null ? '' : $value->users->EmployeeGender,
                $value->users == null ? '' : $value->users->EmployeePosition,
                $value->users == null ? '' : $value->users->EmployeeBranchAbbreviations,
                $value->users == null ? '' : $value->users->joinOfDate,
                $value->payment_of_month,
                $value->total_average_salary,
                $value->total_salary_receive,
                $value->tax_exemption_salary,
                $value->taxable_salary,
            ];
        }
        $this->export_datas = $seniority_pay;
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
                $event->sheet->getStyle('A5:L5')->applyFromArray([
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
                        $event->sheet->getStyle('A'.$n.':L'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$rows.':L'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A5:L5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:L5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:L5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // block merge cells 
                $sheet->mergeCells('A2:L2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:L2')->getFont()->setSize(18)->setName('Khmer OS Muol Pali')->setUnderline('A2:L2');
                $event->sheet->getDelegate()->getStyle('A2:L2')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:L3');
                $sheet->setCellValue('A3', "តារាងលំអិតអំពីការទូទាត់ប្រាក់បំណាច់អតីតភាពការងាររបស់បុគ្គលិក");
                $sheet->getDelegate()->getStyle('A3:L3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:L3');
                $event->sheet->getDelegate()->getStyle('A3:L3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:L4');
                $sheet->setCellValue('A4',$this->getKhmerMonths());
                $sheet->getDelegate()->getStyle('A4:L4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:L4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //footer
                $sheet->mergeCells('A'.$rows.':H'.$rows);
                $sheet->setCellValue('A'.$rows, "សរុប");
                $sheet->getDelegate()->getStyle("A".$rows.':H'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':H'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue I
                $sheet->setCellValue("I".$rows, number_format($this->totalAverageSalary, 2));
                $sheet->getDelegate()->getStyle("I".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("I".$rows);
                $event->sheet->getDelegate()->getStyle("I".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue J
                $sheet->setCellValue("J".$rows, number_format($this->totalSalaryReceive, 2));
                $sheet->getDelegate()->getStyle("J".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("J".$rows);
                $event->sheet->getDelegate()->getStyle("J".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue J
                $sheet->setCellValue("K".$rows, number_format($this->totalTaxExemptionSalary, 2));
                $sheet->getDelegate()->getStyle("K".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("K".$rows);
                $event->sheet->getDelegate()->getStyle("K".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //total setCellValue J
                $sheet->setCellValue("L".$rows, number_format($this->totalTaxableSalary, 2));
                $sheet->getDelegate()->getStyle("L".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("L".$rows);
                $event->sheet->getDelegate()->getStyle("L".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

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
            'J' => 20,
            'K' => 20,
            'L' => 20,
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
            "ប្រាក់បំណាច់សរុប",
            "ប្រាក់បំណាច់កិច្ចសន្យាសរុប",
            "ប្រាក់ខែលើកលែងពន្ធ",
            "ប្រាក់ខែជាប់ពន្ធ",
        ];
    }
}
