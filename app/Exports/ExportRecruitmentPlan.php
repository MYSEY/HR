<?php

namespace App\Exports;

use App\Models\RecruitmentPlan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

class ExportRecruitmentPlan implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{

    protected $export_datas;
    protected $totalRecord;

    public function __construct($export_data)
    {
        
        $this->totalRecord = count($export_data);

        $this->export_datas = [
            'number'=> 1,
            'January'=> 12
        ];
    }

    public function startCell(): string
    {
        return 'A6';
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

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // block merge cells 
                $sheet->mergeCells('A2:v2');
                $sheet->setCellValue('A2', "PROJECTED STAFF");
                $sheet->getDelegate()->getStyle('A2:V2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:V2');
                $event->sheet->getDelegate()->getStyle('A2:V2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $year = Carbon::now()->format('Y');

                $sheet->mergeCells('A3:V3');
                $sheet->setCellValue('A3', "សម្រាប់​".' '."ឆ្នាំ".$year);
                $sheet->getDelegate()->getStyle('A3:V3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:V3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $sheet->mergeCells('A4:D4');
                // $sheet->setCellValue('A4', "ការិយាល័យកណ្ដាល");
                // $sheet->getDelegate()->getStyle('A4:D4')->getFont()->setName('Khmer OS Muol Light')
                // ->setSize(10)->setUnderline('A4:D4');
                // $event->sheet->getDelegate()->getStyle('A4:D4')
                //                 ->getAlignment()
                //                 ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                // $sheet->getDelegate()->getStyle('G6:H6')->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9);
                // $sheet->getDelegate()->getStyle('O6:P6')->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9);

                // $sheet->getDelegate()->getStyle('A5:V5')->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9)->setBold('A5:V5');
                // $sheet->getDelegate()->getStyle('A6:V6')->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9)->setBold('A6:V6');

                

                // $sheet->mergeCells('G5:H5');
                // $sheet->setCellValue('G5', "កិច្ចសន្យា");
            
                // $sheet->mergeCells('O5:P5');
                // $sheet->setCellValue('O5', "ថ្លៃទទួលបាន");

                // $event->sheet->getDelegate()->getStyle('G5:H5')
                //                 ->getAlignment()
                //                 ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $event->sheet->getDelegate()->getStyle('O5:P5')
                //                 ->getAlignment()
                //                 ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // $event->sheet->getDelegate()->getStyle('A6:V6')
                //                 ->getAlignment()
                //                 ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $fromMerge = $this->totalRecord+6+1;
                // $toMerge = $this->totalRecord+6+1;
                // $sheet->mergeCells("N".$fromMerge.':O'.$toMerge);
                // $sheet->setCellValue('N'.$fromMerge, "សរុប");
                // $sheet->getDelegate()->getStyle("N".$fromMerge.':O'.$toMerge)->getFont()->setName('Khmer OS Muol Light')
                // ->setSize(9);
                // $event->sheet->getDelegate()->getStyle("N".$fromMerge.':O'.$toMerge)
                // ->getAlignment()
                // ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // //set value to body
                // $sheet->setCellValue("P".$fromMerge, number_format($this->totalGagolineAmount,2));
                // $sheet->getDelegate()->getStyle("P".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9)->setBold("P".$fromMerge);
                // $sheet->setCellValue("Q".$fromMerge, number_format($this->totalAmountMotor,2));
                // $sheet->getDelegate()->getStyle("Q".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9)->setBold("Q".$fromMerge);
                // $sheet->setCellValue("R".$fromMerge, number_format($this->totaPriceMotor,2));
                // $sheet->getDelegate()->getStyle("R".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9)->setBold("R".$fromMerge);
                // $sheet->setCellValue("T".$fromMerge, number_format($this->totalTaxFee,2));
                // $sheet->getDelegate()->getStyle("T".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9)->setBold("T".$fromMerge);
                // $sheet->setCellValue("U".$fromMerge, number_format($this->totalAmount,2));
                // $sheet->getDelegate()->getStyle("U".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                // ->setSize(9)->setBold("U".$fromMerge);
            },
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,      
            // 'C' => 20,      
            // 'D' => 10,      
            // 'E' => 30,      
            // 'F' => 30,      
            // 'G' => 15,      
            // 'H' => 15,      
            // 'I' => 10,      
            // 'J' => 10,      
            // 'K' => 10,      
            // 'L' => 10,      
            // 'M' => 15,      
            // 'N' => 10,      
            // 'O' => 10,      
            // 'P' => 15,      
            // 'Q' => 10,      
            // 'R' => 15,      
            // 'S' => 10,      
            // 'T' => 10,      
            // 'U' => 15,      
            // 'V' => 10,
        ];
    }

    public function headings(): array
    {
        return [
            'Position' ,
            'January',
        ];
    }

}
