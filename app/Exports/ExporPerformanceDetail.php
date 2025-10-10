<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExporPerformanceDetail implements FromView, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
     public function view(): View
    {
        return view('performance_appraisal.export_excel', [
            'data' => $this->data
        ]);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                // Set Khmer OS Battambang for header
                $sheet->getStyle('A1:K3')->getFont()->setName('Khmer OS Battambang');

                // Set Khmer OS Battambang for table header
                $sheet->getStyle('A6:K6')->getFont()->setName('Khmer OS Battambang');
                $sheet->getStyle('A3:K3')->getFont()->setName('Khmer OS Battambang');
                $sheet->getStyle('A4:K4')->getFont()->setName('Khmer OS Battambang');
                $sheet->getStyle('A5:K5')->getFont()->setName('Khmer OS Battambang');

                // Set Khmer OS Battambang for entire data range
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A7:K$highestRow")->getFont()->setName('Khmer OS Battambang');

                // 🧭 Merge cells for top header/logo
                $sheet->mergeCells('A1:K1');

                 // Header background
                $sheet->getStyle('A3:K3')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF66FF66');
                // Table header background
                $sheet->getStyle('A7:K7')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF66FF66'); // FF = fully opaque

               

                $sheet->getStyle('A:Z')->getAlignment()->setWrapText(true);
                $sheet->getStyle("C8:K$highestRow")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A8:K$highestRow")->getAlignment()->setVertical('center');

                // 🧭 Set column widths
                $widths = [
                    'A' => 35, // (KPI)
                    'B' => 45, // ពណ៌នាផែនការសកម្មភាព (Action Plan)
                    'C' => 25, // គោលដៅ
                    'D' => 15, // Progress
                    'E' => 10, // % ទម្ងន់
                    'F' => 30, // ពិន្ទុសម្រេចបាន (Score Achieved)
                    'G' => 12, // ពិន្ទុ (Score)
                    'H' => 12, // បុគ្គលិកផ្ទាល់
                    'I' => 12, // ប្រធានផ្ទាល់
                    'J' => 50, // កត្តាដែលងាយស្រួល និងលំបាក
                    'K' => 50, // យោបល់/កំណត់សម្គាល់
                ];

                foreach ($widths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }


                $sheet->getStyle('A7:K6')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                // 🧭 Add borders for all data
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A3:K$highestRow")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // 🧭 Center numeric columns
                $sheet->getStyle("D7:K$highestRow")->getAlignment()->setHorizontal('center');
                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Khmer OS Battambang');
            }
        ];
    }
}
