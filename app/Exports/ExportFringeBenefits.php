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

class ExportFringeBenefits implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;
    protected $totalRecord;

    protected $totalAmount_usd;
    protected $totalAmount_riel;
    protected $totalTaxdeduction_usd;
    protected $totalTaxdeduction_riel;
    protected $totalwithholding_tax_rate_usd;
    protected $totalwithholding_tax_rate_riel;
    protected $totalEarnings_after_tax_usd;
    protected $totalEarnings_after_tax_riel;

    public function __construct($export_data)
    {
        $this->totalRecord = count($export_data);
        $i = 0;
        $dataExport = [];
        foreach ($export_data as $value) {
            $i++;
            $this->totalAmount_usd += $value["amount_usd"] ? $value["amount_usd"] : 0;
            $this->totalAmount_riel += $value["amount_riel"];
            $this->totalTaxdeduction_usd += $value["tax_deduction_usd"] ? $value["tax_deduction_usd"] : 0;
            $this->totalTaxdeduction_riel += $value["tax_deduction_riel"];
            $this->totalwithholding_tax_rate_usd += $value["withholding_tax_rate_usd"] ? $value["withholding_tax_rate_usd"] : 0;
            $this->totalwithholding_tax_rate_riel += $value["withholding_tax_rate_riel"];
            $this->totalEarnings_after_tax_usd += $value["earnings_after_tax_usd"] ? $value["earnings_after_tax_usd"] : 0;
            $this->totalEarnings_after_tax_riel += $value["earnings_after_tax_riel"];
            $date_of_commencement = Carbon::createFromDate($value["employee"]->date_of_commencement)->format('d-m-Y');
            $dataExport[] = [
                "number"                        => $i,
                "number_employee"               => $value["employee"]->number_employee ,
                "employee_name_kh"              => $value["employee"]->employee_name_kh,
                "employee_name_en"              => $value["employee"]->employee_name_en,
                "employeeGender"                => $value["employee"]->employeeGender == "Male" ? "ប្រុស" : "ស្រី",
                "position"                      => $value["employee"]->position ? $value["employee"]->position->name_khmer : "",
                "branch"                        => $value["employee"]->branch ? $value["employee"]->branch->branch_name_kh : "",
                "date_of_commencement"          => $date_of_commencement,
                "amount_usd"                    => $value["amount_usd"],
                "amount_riel"                   => number_format($value["amount_riel"]),
                "tax_deduction_usd"             => $value["tax_deduction_usd"],
                "tax_deduction_riel"            => number_format($value["tax_deduction_riel"]),
                "withholding_tax_rate_usd"      => $value["withholding_tax_rate_usd"],
                "withholding_tax_rate_riel"     => number_format($value["withholding_tax_rate_riel"]),
                "earnings_after_tax_usd"        => $value["earnings_after_tax_usd"],
                "earnings_after_tax_riel"       => number_format($value["earnings_after_tax_riel"]),
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
                $sheet->mergeCells('A2:Q2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:Q2')->getFont()->setName('Khmer OS Muol Pali')
                ->setSize(14)->setUnderline('A2:Q2');
                $event->sheet->getDelegate()->getStyle('A2:Q2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:Q3');
                $sheet->setCellValue('A3', "CAMMA Microfinance Limited.");
                $sheet->getDelegate()->getStyle('A3:Q3')->getFont()->setName('Copperplate Gothic Light')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:Q3')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');
                $sheet->mergeCells('A4:Q4');
                $sheet->setCellValue('A4', "ចំណាយលើប្រាក់អត្ថប្រយោជន៍បន្ថែមខែ ".$month.' '.$year);
                $sheet->getDelegate()->getStyle('A4:Q4')->getFont()->setName('Khmer OS Bokor')
                ->setSize(12);
                $event->sheet->getDelegate()->getStyle('A4:Q4')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('C5:D5');
                $sheet->setCellValue('C5', "នាម និង គោត្តនាម");
                $sheet->getDelegate()->getStyle('C5:D5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('C5:D5')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('I5:J5');
                $sheet->setCellValue('I5', "ចំណាយសរុប");
                $sheet->getDelegate()->getStyle('I5:J5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('I5:J5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('K5:L5');
                $sheet->setCellValue('K5', "ប្រាក់ទទួលបានមុខកាត់ពន្ធ (៥០%)");
                $sheet->getDelegate()->getStyle('K5:L5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('K5:L5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('M5:N5');
                $sheet->setCellValue('M5', "អត្រាពន្ធកាត់ទុក 20%");
                $sheet->getDelegate()->getStyle('M5:N5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('M5:N5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('O5:P5');
                $sheet->setCellValue('O5', "ប្រាក់ដែលទទួលបានបន្ទាប់់ពីកាត់ពន្ធ");
                $sheet->getDelegate()->getStyle('O5:P5')->getFont()->setName('Khmer OS Bokor')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('O5:P5')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->getDelegate()->getStyle('A6:Q6')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A6:Q6');

            
                $fromMerge = $this->totalRecord+6+1;
                $toMerge = $this->totalRecord+6+1;
                $sheet->mergeCells("A".$fromMerge.':H'.$toMerge);
                $sheet->setCellValue('A'.$fromMerge, "សរុប");
                $sheet->getDelegate()->getStyle("A".$fromMerge.':H'.$toMerge)->getFont()->setName('Khmer OS Battambang')
                            ->setSize(10)->setBold("A".$fromMerge.':H'.$toMerge);
                $event->sheet->getDelegate()->getStyle("A".$fromMerge.':H'.$toMerge)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //set value to body
                $sheet->setCellValue("I".$fromMerge, number_format($this->totalAmount_usd,2));
                $sheet->getDelegate()->getStyle("I".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("I".$fromMerge);

                $sheet->setCellValue("J".$fromMerge, number_format($this->totalAmount_riel));
                $sheet->getDelegate()->getStyle("J".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("J".$fromMerge);

                $sheet->setCellValue("K".$fromMerge, number_format($this->totalTaxdeduction_usd,2));
                $sheet->getDelegate()->getStyle("K".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("K".$fromMerge);

                $sheet->setCellValue("L".$fromMerge, number_format($this->totalTaxdeduction_riel));
                $sheet->getDelegate()->getStyle("L".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("L".$fromMerge);

                $sheet->setCellValue("M".$fromMerge, number_format($this->totalwithholding_tax_rate_usd,2));
                $sheet->getDelegate()->getStyle("M".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("M".$fromMerge);

                $sheet->setCellValue("N".$fromMerge, number_format($this->totalwithholding_tax_rate_riel));
                $sheet->getDelegate()->getStyle("N".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("N".$fromMerge);

                $sheet->setCellValue("O".$fromMerge, number_format($this->totalEarnings_after_tax_usd,2));
                $sheet->getDelegate()->getStyle("O".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("O".$fromMerge);

                $sheet->setCellValue("P".$fromMerge, number_format($this->totalEarnings_after_tax_riel));
                $sheet->getDelegate()->getStyle("P".$fromMerge)->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold("P".$fromMerge);
            },
        ];
    }
      
    public function headings(): array
    {
        return [
                "ល.រ*",
                "ប័ណ្ណ ការងារ" ,
                "ភាសាខ្មែរ",
                "អង់គ្លេស",
                "ភេទ",
                "តួនាទី",
                "ទីតាំងការងារ",
                "ថ្ងៃចូលធ្វើការ",
                "USD",
                "Riel",
                "USD",
                "Riel",
                "USD",
                "Riel",
                "USD",
                "Riel",
                "ហត្ថលេខាអ្នកបើកប្រាក់",
        ];
    }
}
