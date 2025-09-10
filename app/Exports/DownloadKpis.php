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

class DownloadKpis implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents

{
    protected $export_datas;
    protected $num;

    public function __construct($id)
    {
        // $data = Performance::with('users')
        //     // ->leftJoin('users', 'performances.employee_id', '=', 'users.id')
        //     ->leftJoin('performance_details', 'performances.id', '=', 'performance_details.performance_id')
        //     ->select(
        //         'performance_details.performance_id',
        //         'performance_details.title_id',
        //         'performance_details.purpose_id',
        //         'performance_details.key_kpi',
        //         'performance_details.action_plan',
        //         'performance_details.goal',
        //         'performance_details.goal_type',
        //         'performance_details.progress',
        //     )
        // ->where('performances.status', 'approved')->get();
        // dd($data);
        // $i = 0;
        // $dataPer = [];
        // foreach ($data as $value) {
        //     $i++;
        //     $this->num = $i;
        //     $dataPer[]=[
        //         $value->users->number_employee,
        //         $value->users->employee_name_kh,
        //         $value->performance_id,
        //         $value->title_id,
        //         $value->purpose_id,
        //         $value->key_kpi,
        //         $value->action_plan,
        //         $this->formatGoal($value->goal),
        //         $value->goal_type,
        //         $value->progress,
        //     ];
        // }

        $data = Performance::with(['users', 'performanceDetails'])->where('status', 'approved')->get();
        $i = 0;
        $dataPer = [];
        foreach ($data as $performance) {
            foreach ($performance->performanceDetails as $detail) {
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
}