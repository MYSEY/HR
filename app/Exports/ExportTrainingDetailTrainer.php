<?php

namespace App\Exports;

use App\Models\Training;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportTrainingDetailTrainer implements FromCollection,  WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{

    protected $export_datas;
    public function __construct($export_data)
    {
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $training) {
            $i++;
            foreach ($training->trainers as $key => $tri) {
                $dataExport[] = [
                    "training_id"   => $training->id,
                    "trainer_id"    => $tri->id,
                    "name_en"       => ($tri->type == 2 ? $tri->name_en : $tri->employee->employee_name_en),
                ];
            }
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
        // return Training::all();
    }

    public function startCell(): string
    {
        return 'A4';
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:S2');
                $sheet->setCellValue('A2', "CAMMA Microfinance Limited");
                $sheet->getDelegate()->getStyle('A2:S2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:S2');
                $event->sheet->getDelegate()->getStyle('A2:S2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $sheet->mergeCells('A3:S3');
                $sheet->setCellValue('A3', "Training Reports");
                $sheet->getDelegate()->getStyle('A3:S3')->getFont()->setName('Arial')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:S3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,      
            'C' => 20,    
        ];
    }
    public function headings(): array
    {
        return [
                "training_id",
                "trainer_id",
                "name en",
        ];
    }
}
