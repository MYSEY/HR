<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportEForm implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;
    protected $totalBaseSalaryReceived;

    public function __construct($export_data)
    {
        $this->totalRecord = count($export_data);
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $i++;
            $this->totalBaseSalaryReceived += $value["total_gross"];
            $joinOfDate = Carbon::createFromDate($value["users"]->date_of_commencement)->format('d-m-Y');
            $date_of_birth = Carbon::createFromDate($value["users"]->date_of_birth)->format('d-m-Y');
            $dataExport[] = [
                "number" => $i,
                "number_employee"               => $value["users"]->number_employee,
                "id_number_nssf"                => $value["users"]->id_number_nssf,
                "id_card_number"                => $value["users"]->id_card_number,
                "last_name_kh"                  => $value["users"]->last_name_kh,
                "first_name_kh"                 => $value["users"]->first_name_kh,
                "last_name_en"                  => $value["users"]->last_name_en,
                "first_name_en"                 => $value["users"]->first_name_en,
                "gender"                        => $value["users"]->EmployeeGender,
                "date_of_birthday"              => $date_of_birth,
                "nationality"                   => $value["users"]->nationality? $value["users"]->nationality : "",
                "join_date"                     => $joinOfDate,
                "group"                         => "",
                "position"                      => $value["users"] == null ? '' : $value["users"]->position->position_range,
                "type_of_employees_nssf"        => $value["users"]->type_of_employees_nssf,
                "status_nssf"                   => $value["users"]->status_nssf,
                "total_gross"                   => $value["total_gross"],
                "payment_date"                  => Carbon::parse($value["payment_date"])->format('d-M-Y'),
            ];
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
    }

    public function startCell(): string
    {
        return 'A4';
    }
    // Khmer OS Muol Light
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,      
            'C' => 20,      
            'D' => 20,      
            'E' => 20,      
            'F' => 20,      
            'G' => 20,      
            'H' => 20,      
            'I' => 20,      
            'J' => 20,      
            'K' => 20,      
            'L' => 20,      
            'M' => 20,      
            'N' => 20,      
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
        ];
    }


    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                // block merge cells 
                $sheet->mergeCells('A2:R2');
                $sheet->setCellValue('A2', "របាយការណ៍ E-Form");
                $sheet->getDelegate()->getStyle('A2:R2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:R2');
                $event->sheet->getDelegate()->getStyle('A2:R2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->getDelegate()->getStyle('A4:R4')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A4:R4');

                $fromMerge = $this->totalRecord+4+1;
                $toMerge = $this->totalRecord+4+1;
                $sheet->mergeCells("O".$fromMerge.':P'.$toMerge);
                $sheet->setCellValue('O'.$fromMerge, "សរុប");
                $sheet->getDelegate()->getStyle("O".$fromMerge.':P'.$toMerge)->getFont()->setName('Khmer OS Muol Light')
                            ->setSize(9);
                
                $event->sheet->getDelegate()->getStyle("O".$fromMerge.':P'.$toMerge)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //set value to body
                $sheet->setCellValue("Q".$fromMerge, number_format($this->totalBaseSalaryReceived,2));
                $sheet->getDelegate()->getStyle("Q".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("Q".$fromMerge);
            },
        ];
    }
      
    public function headings(): array
    {
        return [
                "ល.រ*",
                "អត្ត.នៅសហគ្រាស",
                "លេខអត្ត.ប.ស.ស",
                "អត្ត.ប្រជាពលរដ្ឋ",
                "គោតនាម",
                "នាម",
                "គោតនាមឡាតាំង",
                "នាមឡាតាំង",
                "ភេទ*",
                "ថ្ងៃខែឆ្នាំកំណើត*",
                "សញ្ជាតិ*",
                "កាលបរិ.ចូលធ្វើការ",
                "ក្រុម",
                "តួនាទី",
                "ប្រភេទនិយោជិត",
                "ស្ថានភាព",
                "ប្រាក់បៀវត្ស(រៀល/ដុល្លា)",
                "កាលបរិច្ឆេទទូទាត់",
        ];
    }
}
