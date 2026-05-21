<?php

namespace App\Exports;
use Carbon\Carbon;
use KhmerDateTime\KhmerDateTime;
use Illuminate\Support\Collection;
use App\Models\GenerateAnnaulBonus;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportAnnualBonus implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $increasement_of_year;
    protected $totalBasiceSalary;
    protected $totalAnnaulBounus;
    protected $branch_name;

    public function __construct($request)
    {
        $query = GenerateAnnaulBonus::leftJoin('users', 'generate_annaul_bonuses.employee_id', '=', 'users.id')
            ->leftJoin('options', 'users.gender', '=', 'options.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->leftJoin('performance_appraisals', 'generate_annaul_bonuses.performance_id', '=', 'performance_appraisals.id')
            ->select(
                'generate_annaul_bonuses.*',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'options.name_khmer as gender_name_kh',
                'options.name_english as gender_name_en',
                'users.date_of_commencement',
                'departments.name_english as dep_name',
                'positions.name_english as positions_name_en',
                'positions.name_khmer as positions_name_kh',
                'branchs.branch_name_en',
                'branchs.abbreviations',
                'performance_appraisals.total_score',
                'performance_appraisals.total_score_live_staff',
                'performance_appraisals.total_score_direct_chairman'
            );

        // Filters
        $query->when($request->employee_id, fn($q,$employee_id) =>
            $q->where('generate_annaul_bonuses.employee_id', $employee_id)
        );

        $query->when($request->employee_name, fn($q,$employee_name) =>
            $q->where('users.employee_name_en', 'LIKE', "%{$employee_name}%")
        );

        $query->when($request->branch_id, fn($q,$branch_id) =>
            $q->where('users.branch_id', $branch_id)
        );

        $data = $query->get();
        $dataExcel = [];
        $no = 1;

        foreach ($data as $row) {
            $this->increasement_of_year = $row->increasement_of_year;
            $this->totalBasiceSalary += $row->basice_salary;
            $this->totalAnnaulBounus += $row->total_annaul_bounus;
            $dataExcel[] = [
                $no++,
                $row->number_employee,
                $row->employee_name_kh,
                $row->gender_name_kh,
                $row->positions_name_kh,
                $row->abbreviations,
                $row->date_of_commencement,
                $row->basice_salary ?? '',
                $row->working_days_per_year ?? '',
                $row->incentive ?? '',
                $row->total_score_direct_chairman,
                $row->of_incentive_by_pa,
                $row->achieved_vs_pa,
                $row->number_months_received ?? '',
                $row->total_annaul_bounus ?? '',
            ];
        }
        
        if ($request->branch_id=='1') {
            $this->branch_name = 'ប្រចាំការិយាល័យកណ្តាល';
        }elseif ($request->branch_id=='2') {
            $this->branch_name = 'ប្រចាំការិយាល័យប្រតិបត្តិការ';
        }elseif ($request->branch_id=='3') {
            $this->branch_name = 'ប្រចាំសាខាអង្គស្នួល';
        }elseif ($request->branch_id=='4') {
            $this->branch_name = 'ប្រចាំសាខាតាខ្មៅ';
        }elseif ($request->branch_id=='5') {
            $this->branch_name = 'ប្រចាំសាខាគងពិសី';
        }elseif ($request->branch_id=='6') {
            $this->branch_name = 'ប្រចាំសាខាកំពង់ស្ពឺ';
        }elseif ($request->branch_id=='7') {
            $this->branch_name = 'ប្រចាំសាខាស្អាង';
        }elseif ($request->branch_id=='8') {
            $this->branch_name = 'ប្រចាំសាខាកំពង់ត្រាច';
        }elseif ($request->branch_id=='9') {
            $this->branch_name = 'ការិយាល័យប្រតិបត្តិការ ផ្នែកឌីជីថល';
        }else {
            $this->branch_name = 'គ្រប់សាខា';
        }
        $this->export_datas = $dataExcel;
    }

    public function collection()
    {
        return new Collection([
            $this->export_datas,
        ]);
    }

    public function startCell(): string
    {
        return 'A6';
    }
    public function getKhmerMonths(){
        $month = Carbon::createFromDate($this->increasement_of_year)->format('Y-m-d');
        $dateTime = KhmerDateTime::parse($month);
        $yearKH = $dateTime->year();
        $result = "តារាងលំអិតអំពីប្រាក់លើកទឹកចិត្តប្រចាំឆ្នាំ".$yearKH;
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
            "ទីតាំងការងារ",
            "ថ្ងៃចូលធ្វើការ",
            "បៀវត្សគោលចុងគ្រា ($)",
            "#ថ្ងៃធ្វើការក្នុងឆ្នាំ",
            "%​ប្រាក់លើកទឹកចិត្ត",
            "PA Score",
            "% of Incentive by PA",
            "% សម្រេចធៀបនឹង %PA",
            "ចំនួនខែត្រូវទទួលបាន",
            "ប្រាក់ឧបត្ថម្ភលើកទឹកចិត្តឆ្នាំ",
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 15,
            'C' => 22,
            'D' => 8,
            'E' => 18,
            'F' => 10,
            'G' => 18,
            'H' => 16,
            'I' => 16,
            'J' => 16,
            'K' => 12,
            'L' => 12,
            'M' => 12,
            'N' => 20,
            'O' => 22,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // $sheet = $event->sheet->getDelegate();
                // Add the logo to the sheet
                $sheet = $event->sheet;
                $rows = count($this->export_datas) + 6 + 1;
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Camma Logo');
                $drawing->setPath(public_path('admin/img/logo/commalogo1.png')); // Correct path
                $drawing->setHeight(100); // Adjust size as needed
                $drawing->setCoordinates('B1'); // Cell position
                $drawing->setWorksheet($sheet->getDelegate()); // Bind to sheet

                
                $sheet->getDelegate()->getStyle('A6:O6')->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold('A6:O6');
                $event->sheet->getStyle('A6:O6')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // block merge cells 
                $sheet->mergeCells('A2:O2');
                $sheet->setCellValue('A2', $this->getKhmerMonths());
                $sheet->getDelegate()->getStyle('A2:O2')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->getColor()->setARGB('FF0000FF'); 
                $event->sheet->getDelegate()->getStyle('A2:O2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:O3');
                $sheet->setCellValue('A3', "សម្រាប់គ្រប់បុគ្គលិក".$this->branch_name);
                $sheet->getDelegate()->getStyle('A3:O3')->getFont()->setName('Khmer OS Fasthand')->setSize(9)->getColor()->setARGB('FF0000FF');
                $event->sheet->getDelegate()->getStyle('A3:Z3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A6:N6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $lastRow = count($this->export_datas) + 1;
                $n=6;
                if ($lastRow > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':O'.$n)->applyFromArray([
                            'font' => [
                                'name' => 'Khmer OS Battambang', // Font name
                                'size' => 9, // Font size
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }

                //footer
                $event->sheet->getStyle('A'.$rows.':O'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->mergeCells('A'.$rows.':G'.$rows);
                $sheet->setCellValue('A'.$rows, "សរុប");
                $sheet->getDelegate()->getStyle("A".$rows.':G'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':G'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue H
                $sheet->setCellValue("H".$rows, number_format($this->totalBasiceSalary, 2));
                $sheet->getDelegate()->getStyle("H".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("H".$rows);
                $event->sheet->getDelegate()->getStyle("H".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                //total setCellValue O
                $sheet->setCellValue("O".$rows, number_format($this->totalAnnaulBounus, 2));
                $sheet->getDelegate()->getStyle("O".$rows)->getFont()->setName('Khmer OS Battambang')->setSize(9)->setBold("O".$rows);
                $event->sheet->getDelegate()->getStyle("O".$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
}