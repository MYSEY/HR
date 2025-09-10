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
    protected $num;

    public function __construct($id)
    {
        $data = Performance::leftJoin('users', 'performances.employee_id', '=', 'users.id')
            ->leftJoin('performance_details', 'performances.id', '=', 'performance_details.performance_id')
            ->select(
                'users.number_employee',
                'users.employee_name_kh',
                'performance_details.performance_id',
                'performance_details.title_id',
                'performance_details.purpose_id',
                'performance_details.key_kpi',
                'performance_details.action_plan',
                'performance_details.goal',
                'performance_details.goal_type',
                'performance_details.progress',
            )
        ->where('performances.status', 'approved')->where('performances.id', $id)->get();
        // dd($data);
        $i = 0;
        foreach ($data as $value) {
            $i++;
            $this->num = $i;
            $dataPer[]=[
                $value->number_employee,
                $value->employee_name_kh,
                $value->performance_id,
                $value->title_id,
                $value->purpose_id,
                $value->key_kpi,
                $value->action_plan,
                $this->formatGoal($value->goal),
                $value->goal_type,
                $value->progress,
            ];
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
            'A' => 10,
            'B' => 10,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 20,
            'G' => 15,
            'H' => 20,
            'I' => 20,
            'J' => 18
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
        ];
    }

    private function formatGoal($goal)
    {
        return $goal . ' ' . $goal;
    }
}
