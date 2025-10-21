<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\PerformanceAppraisal;
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
    protected $num;

    public function __construct($id)
    {
        $data = PerformanceAppraisal::with(['users', 'performanceDetail'])->where('performance_appraisals.id', $id)->get();
        $i = 0;
        $dataPer = [];
        foreach ($data as $performance) {
            foreach ($performance->performanceDetail as $detail) {
                $i++;
                $this->num = $i;
                $dataPer[] = [
                    $performance->users->number_employee,
                    $performance->users->employee_name_kh,
                    $detail->performance_id,
                    $detail->title_id,
                    $detail->purpose_id,
                    $detail->key_kpi,
                    $detail->action_plan,
                    $detail->goal,
                    $detail->goal_type,
                    $detail->progress,
                    $detail->weight,
                    $detail->score_achieved,
                    $detail->score,
                    $detail->score_live_staff,
                    $detail->score_direct_chairman,
                ];
            }
        }

        $this->export_datas = $dataPer;
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
        return 'A1';
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 15,
            'D' => 10,
            'E' => 10,
            'F' => 20,
            'G' => 15,
            'H' => 20,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'M' => 10,
            'N' => 10,
            'O' => 10,
            'P' => 10,
        ];
    }
    public function headings(): array
    {
        return [
            "Employee ID",
            "Employee Name",
            "Performance ID",
            "Title ID",
            "Purpose ID",
            "Key kpi",
            "Action Plan",
            "Goal",
            "Goal Type",
            "Progress",
            "Weight",
            "Score Achieved",
            "Score",
            "Score Live Staff",
            "Score Direct Chairman",
        ];
    }
}
