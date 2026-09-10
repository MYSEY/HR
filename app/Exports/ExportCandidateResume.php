<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ExportCandidateResume implements FromView, WithEvents, WithDrawings
{
    protected $data;
    protected $date;

    public function __construct($data, $date)
    {
        $this->data = $data;
        $this->date = $date;
    }

    public function view(): View
    {
        return view("recruitments.candidate_resumes.recruitment_export", [
            'data' => $this->data,
            'date' => $this->date,
        ]);
    }

    /**
     * គូររូបភាព Logo បញ្ចូលទៅក្នុង Excel
     */
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Company Logo');
        $drawing->setDescription('Camma Logo');
        
        $drawing->setPath(public_path('/admin/img/camma-logo.png')); 
        
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');
        
        // បើចង់រំកិលរូបភាពឱ្យចេញពីគែមបន្តិច (Optional)
        $drawing->setOffsetX(10); 
        $drawing->setOffsetY(10);

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $sheet->getRowDimension(1)->setRowHeight(70); 
                $sheet->getRowDimension(2)->setRowHeight(40); 

                // ពង្រីកការកំណត់ Font ពី A1 ដល់ AD3 (៣០ Columns)
                $sheet->getStyle('A1:AB3')->getFont()->setName('Khmer OS Battambang');
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A3:AB$highestRow")->getFont()->setName('Khmer OS Battambang');
                
                // 🧭 កំណត់ទទឹង Columns ទាំងអស់ (បន្ថែមពី A ដល់ AD)
                $widths = [
                    'A' => 8, 'B' => 20, 'C' => 25, 'D' => 12, 'E' => 22, 
                    'F' => 22, 'G' => 25, 'H' => 22, 'I' => 22, 'J' => 15, 
                    'K' => 12, 'L' => 22, 'M' => 20, 'N' => 18, 'O' => 20, 
                    'P' => 15, 'Q' => 18, 'R' => 12, 'S' => 20, 'T' => 30,
                    'U' => 20, 'V' => 20, 'W' => 15,
                    'X' => 18, 
                    'Y' => 18,
                    'Z' => 15, 
                    'AA' => 15, 
                    'AB' => 50, 
                ];

                foreach ($widths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Khmer OS Battambang');
            }
        ];
    }
}