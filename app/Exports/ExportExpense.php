<?php

namespace App\Exports;

use App\Models\ExpenseRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportExpense implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;
    protected $filter;
    

     public function __construct($export_data, $filter)
    {
        $this->totalRecord = count($export_data);
        $this->filter = $filter;
        $i = 0;
        $dataExport = [];
        $type =  "";
        foreach ($export_data as $value) {
            $i++;
            
            if ($value->type == "1"){
               $type = "Special Expense";
            }else if ($value->type == "2"){
               $type = "Tax Expense";
            }else{
                $type = "General Expense";
            };
           $request_date = Carbon::createFromDate($value->date_request)->format('d-M-Y H:i');
           $date_approve = $value->date_approve ? Carbon::createFromDate($value->date_approve)->format('d-M-Y') : "";
            $dataExport[] = [
                "number" => $i,
                "Tracking ID"           =>  $value->tracking_id,
                "Type"                  =>  $type,
                "Type of Expense"       =>  ($value->expense_type == "1" ? "Regular Expense": "Irregular Expense"),
                "Description"           =>  $value->subject,
                "Amount USD"            =>  "$ ".$value->amount_usd,
                "Amount KH"             =>  "៛ ".$value->amount_riel,
                "Type of payment"       =>  $value->payment_term,
                "Request Date"          =>  $request_date,
                "Request By"            =>  ($value->expenseRequest->createdBy ? $value->expenseRequest->createdBy->employee_name_en: ""),
                "Location"              =>  ($value->type == "2" ?  $value->department->name_english : $value->location->branch_name_en ) ,
                "Reference"             =>  $value->reference,
                "Submitted Date"        =>  $date_approve,
                "Approve By"            =>  ($value->expenseRequest->approveBy ? $value->expenseRequest->approveBy->employee_name_en: ""),
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
        return 'A6';
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
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // Add the logo to the sheet
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Camma Logo');
                $drawing->setPath(public_path('admin/img/logo/commalogo1.png')); // Correct path
                $drawing->setHeight(100); // Adjust size as needed
                $drawing->setCoordinates('E1'); // Cell position
                // $drawing->setOffsetX(10); // Optional: horizontal padding
                // $drawing->setOffsetY(10); // Optional: vertical padding
                $drawing->setWorksheet($sheet->getDelegate()); // Bind to sheet

                $sheet->getDelegate()->getStyle('A6:N6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:N6');
                $event->sheet->getStyle('A6:N6')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                 $n=6;
                if ($this->totalRecord > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':N'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }

                // block merge cells 
                $sheet->mergeCells('A2:N2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:N2')->getFont()
                ->setName('Khmer OS Muol Light')
                ->setSize(12)
                ->getColor()->setARGB('FFFF0000'); 
                $event->sheet->getDelegate()->getStyle('A2:N2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:N3');
                $sheet->setCellValue('A3', "CAMMA-FND-002 Report");
                $sheet->getDelegate()->getStyle('A3:N3')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12);
                $event->sheet->getDelegate()->getStyle('A3:Z3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                if ($this->filter->date_request || $this->filter->date_approve) {

                    if($this->filter->date_request && $this->filter->date_approve){
                        $date ="Date Request: ". Carbon::createFromDate($this->filter->date_request)->format('d-M-Y'). ", Date Approve: ". Carbon::createFromDate($this->filter->date_approve)->format('d-M-Y');
                    }else{
                        if ($this->filter->date_request) {
                            $date ="Date Request: ". Carbon::createFromDate($this->filter->date_request)->format('d-M-Y');
                        }else{
                            $date ="Date Approve:". Carbon::createFromDate($this->filter->date_approve)->format('d-M-Y');
                        }
                    }
                   

                    $sheet->mergeCells('A4:N4');
                    $sheet->setCellValue('A4', $date);
                    $sheet->getDelegate()->getStyle('A4:N4')->getFont()->setName('Khmer OS Muol Light')
                    ->setSize(10);
                    $event->sheet->getDelegate()->getStyle('A4:N4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }
               
                $event->sheet->getDelegate()->getStyle('A6:N6')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
      
    public function headings(): array
    {
        return [
                "No",
                "Tracking ID" ,
                "Type",
                "Type of Expense",
                "Description",
                "Amount USD",
                "Amount KH",
                "Type of payment",
                "Request Date",
                "Request By",
                "Location",
                "Reference",
                "Submitted Date",
                "Approve By",
        ];
    }
}
