<?php

namespace App\Exports;

use App\Models\Performance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportKpis implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents

{
    protected $export_datas;

    public function __construct($id)
    {
        $data = Performance::leftJoin('users', 'performances.employee_id', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->select(
                'performances.*',
                'users.position_id',
                'users.department_id',
                'users.branch_id',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'users.branch_id',
                'departments.name_english as dep_name',
                'positions.name_english as positions_name',
                'branchs.branch_name_en',
                'branchs.branch_name_kh',
            )
        ->where('performances.status', 'approved')->where('performances.id', $id)->first();
        $this->export_datas = $data;
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
                $rows = $this->export_datas;
                // dd($rows);
                $event->sheet->getStyle('A5:K5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A5:K5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A5:K5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A5:K5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:K5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:K5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // block merge cells 
                $sheet->mergeCells('A2:K2');
                $sheet->setCellValue('A2', "ទម្រង់ផែនការការងាររបស់បុគ្គលិកប្រចាំឆ្នាំ២០២៥");
                $sheet->getDelegate()->getStyle('A2:K2')->getFont()->setSize(18)->setName('Khmer OS Content')->setUnderline('A2:K2');
                $event->sheet->getDelegate()->getStyle('A2:K2')->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:K3');
                $sheet->setCellValue('A3', "ប្រចាំឆ្នាំ៖ ២០២៥");
                $sheet->getDelegate()->getStyle('A3:K3')->getFont()->setName('Khmer OS Content');
                $event->sheet->getDelegate()->getStyle('A3:K3')->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:K4');
                $sheet->setCellValue('A4', "(ពីថ្ងៃខែឆ្នាំ៖ 01/01/2025    ដល់ថ្ងៃខែឆ្នាំ៖ 31/12/2025)");
                $sheet->getDelegate()->getStyle('A4:K4')->getFont()->setName('Khmer OS Content')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:K4')->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A5:K5');
                $sheet->setCellValue('A5', "ផ្នែកទី១៖ ព័ត៌មានទូទៅរបស់បុគ្គលិក");
                $sheet->getDelegate()->getStyle('A5:K5')->getFont()->setName('Khmer OS Content')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A5:K5');

                $sheet->mergeCells('A6:A6');
                $sheet->setCellValue('A6', 'អត្តលេខធ្វើការ៖');
                $sheet->setCellValue('A6', '២២០-៤១៣');

                $sheet->mergeCells('D6:E6');
                $sheet->setCellValue('D6', 'ថ្ងៃខែឆ្នាំចូលបម្រើការងារ៖');
            },
        ];
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
            'J' => 25,
            'K' => 25
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
            "បៀវត្សគោលចុងគ្រា",
            "បៀវត្ស​គោលទទួលបាន",
            "ប្រាក់បំណាច់កិច្ចសន្យាសរុប"
        ];
    }
}
