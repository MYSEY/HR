<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\SeverancePay;
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

class ExportSeverancePay implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $num;
    protected $export_datas;

    protected $totalSeveranecPay;
    protected $totalContractSeverancePay;

    public function __construct($request)
    {
        $i = 0;
        foreach ($request as $key => $value) {
           
            $i++;
            $this->num = $i;
            $this->totalSeveranecPay += $value->total_severanec_pay;
            $this->totalContractSeverancePay += $value->total_contract_severance_pay;
            $severance_pay=[
                $i,
                $value->users == null ? '' : $value->users->number_employee,
                $value->users == null ? '' : $value->users->employee_name_en,
                $value->users == null ? '' : $value->users->EmployeeGender,
                $value->users == null ? '' : $value->users->EmployeePosition,
                $value->users == null ? '' : $value->users->EmployeeBranchAbbreviations,
                $value->users == null ? '' : $value->users->joinOfDate,
                $value->users == null ? '' : Carbon::parse($value->users->fdc_end)->format('d-M-Y'),
                // $value->total_severanec_pay,
                // $value->total_contract_severance_pay
            ];
            $totalGross =[
                $value->total_severanec_pay,
                $value->total_contract_severance_pay
            ];
            if ($value->severan_type == "FDC-1") {
                $gross1 = [];
                foreach ($value->gruse_salary_1 as $key => $gruse_salary) {
                    $gross1[] = $gruse_salary->total_fdc1;
                }
                if (count($gross1) < 13) {
                    array_push($gross1, 0.00);
                }
                $result []= array_merge($severance_pay, $gross1, $totalGross);
            }
           
            if ($value->severan_type == "FDC-2") {
                $gross2 = [];
                foreach ($value->gruse_salary_2 as $key => $gruse_salary) {
                    $gross2[] = $gruse_salary->total_fdc2;
                }
                if (count($gross2) < 13) {
                    array_push($gross2, 0.00);
                }
                $result []= array_merge($severance_pay, $gross2, $totalGross);
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
                $event->sheet->getStyle('A5:W5')->applyFromArray([
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
                        $event->sheet->getStyle('A'.$n.':W'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$rows.':W'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A5:W5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:W5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:W5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // block merge cells 
                $sheet->mergeCells('A2:W2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:W2')->getFont()->setSize(18)->setName('Khmer OS Muol Pali')->setUnderline('A2:W2');
                $event->sheet->getDelegate()->getStyle('A2:W2')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:W3');
                $sheet->setCellValue('A3', "តារាងលំអិតអំពីការទូទាត់ប្រាក់បំណាច់កិច្ចសន្យាការងាររបស់បុគ្គលិក");
                $sheet->getDelegate()->getStyle('A3:W3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:W3');
                $event->sheet->getDelegate()->getStyle('A3:W3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:W4');
                $sheet->setCellValue('A4',$this->getKhmerMonths());
                $sheet->getDelegate()->getStyle('A4:W4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:W4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //footer
                $sheet->mergeCells('A'.$rows.':U'.$rows);
                $sheet->setCellValue('A'.$rows, "សរុប");
                $sheet->getDelegate()->getStyle("A".$rows.':U'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':U'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue I
                $sheet->setCellValue("V".$rows, number_format($this->totalSeveranecPay, 2));
                $sheet->getDelegate()->getStyle("V".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("V".$rows);
                $event->sheet->getDelegate()->getStyle("V".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue W
                $sheet->setCellValue("W".$rows, number_format($this->totalContractSeverancePay, 2));
                $sheet->getDelegate()->getStyle("W".$rows)->getFont()->setName('KGmer OS Battambang')->setSize(9)->setBold("W".$rows);
                $event->sheet->getDelegate()->getStyle("W".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

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
            'O' => 20,
            'P' => 20,
            'Q' => 20,
            'R' => 20,
            'S' => 20,
            'T' => 20,
            'U' => 20,
            'V' => 20,
            'W' => 20,
            'X' => 20,
            'Y' => 20,
            'AA' => 20,
            'AB' => 20,
            'AC' => 20,
            'AD' => 20,
            'AE' => 20,
            'AF' => 20,
            'AG' => 20,
            'AH' => 20,
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
            "ថ្ងៃចុងគ្រានៃកិច្ចសន្យា",
            "ខែទី១",
            "ខែទី២",
            "ខែទី៣",
            "ខែទី៤",
            "ខែទី៥",
            "ខែទី៦",
            "ខែទី៧",
            "ខែទី៨",
            "ខែទី៩",
            "ខែទី១០",
            "ខែទី១១",
            "ខែទី១២",
            "ខែទី១៣",
            "ប្រាក់បំណាច់សរុប",
            "ប្រាក់បំណាច់កិច្ចសន្យាសរុប"
        ];
    }
}
