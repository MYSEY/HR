<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

class ExportRecruitmentPlan implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{

    protected $request;
    protected $report_fo_year;
    protected $export_datas;

    public function __construct($request)
    {
        $by_year = null;
        if ($request->filter_year) {
        $by_year = $request->filter_year;
        }else {
            $by_year = Carbon::createFromDate()->format('Y');
        }
        $dataRecruitmentPlans = DB::table('recruitment_plans')
        ->join('branchs', 'recruitment_plans.branch_id', '=', 'branchs.id')
        ->join('positions', 'recruitment_plans.position_id', '=', 'positions.id')
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('branch_id', $branch_id);
        })
        ->when($request->position_id, function ($query, $position_id) {
            $query->where('position_id', $position_id);
        })
        ->when($by_year, function ($query, $filter_year) {
            $query->whereYear('plan_date', $filter_year);
        });
        $trainings = $dataRecruitmentPlans->select('recruitment_plans.*', 'branchs.branch_name_en', 'positions.name_english')->get();
        $branchs = $dataRecruitmentPlans->groupBy('branch_id', 'position_id')->select('branch_id', 'position_id', 'plan_date', "branchs.branch_name_en", 'positions.name_english')->get();
        
        $dataPos =[];
        foreach ($branchs as $key => $bra) {
            $data =[];
            for ($x = 1; $x <= 12; $x++) {
                $year = Carbon::createFromDate($bra->plan_date)->format('Y');
                $this->report_fo_year = $year;
                $x_yearmonth = Carbon::createFromDate($year.'-'.$x)->format('Y-m');
                $total_staff = 0;
                foreach ($trainings as $key => $trai) {
                    $pos_yearmonth = Carbon::createFromDate($trai->plan_date)->format('Y-m');
                    if ($trai->branch_id == $bra->branch_id && $trai->position_id == $bra->position_id  && $x_yearmonth == $pos_yearmonth) {
                        $total_staff += $trai->total_staff;
                    }
                }
                array_push($data,$total_staff);
            }
            $object = [
                "Location name" => $bra->branch_name_en,
                "position name" => $bra->name_english,
                "January" => $data[0],
                "February" => $data[1],
                "March" => $data[2],
                "April" => $data[3],
                "May" => $data[4],
                "June" => $data[5],
                "July" => $data[6],
                "August" => $data[7],
                "September" => $data[8],
                "October" => $data[9],
                "November" => $data[10],
                "December" => $data[11],
            ];
            array_push($dataPos, $object);
        }
        $this->export_datas = $dataPos;
    }

    public function startCell(): string
    {
        return 'A4';
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
                $sheet->mergeCells('A2:N2');
                $sheet->setCellValue('A2', "PROJECTED STAFF");
                $sheet->getDelegate()->getStyle('A2:N2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:N2');
                $event->sheet->getDelegate()->getStyle('A2:N2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:N3');
                $sheet->setCellValue('A3', "For".' '."Year ".$this->report_fo_year);
                $sheet->getDelegate()->getStyle('A3:N3')->getFont()->setName('Khmer OS Freehand')
                ->setSize(10);
                $event->sheet->getDelegate()->getStyle('A3:N3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 10,      
            'C' => 10,      
            'D' => 10,      
            'E' => 10,      
            'F' => 10,      
            'G' => 10,      
            'H' => 10,      
            'I' => 10,      
            'J' => 10,      
            'K' => 10,      
            'L' => 10,      
            'M' => 10,      
            'N' => 10, 
        ];
    }

    public function headings(): array
    {
        return [
            "Location Name",
            "Position Name",
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];
    }
}
