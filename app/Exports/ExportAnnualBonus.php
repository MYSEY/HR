<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\GenerateAnnaulBonus;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportAnnualBonus implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;

    public function __construct($request)
    {
        $query = GenerateAnnaulBonus::leftJoin('users', 'generate_annaul_bonuses.employee_id', '=', 'users.id')
            ->leftJoin('options', 'users.gender', '=', 'options.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('branchs', 'users.branch_id', '=', 'branchs.id')
            ->leftJoin('performance_appraisals', 'generate_annaul_bonuses.performance_id', '=', 'performance_appraisals.id')
            ->select(
                'generate_annaul_bonuses.*',
                'users.number_employee',
                'users.employee_name_kh',
                'users.employee_name_en',
                'options.name_khmer as gender_name_kh',
                'options.name_english as gender_name_en',
                'users.date_of_commencement',
                'departments.name_english as dep_name',
                'positions.name_english as positions_name_en',
                'positions.name_khmer as positions_name_kh',
                'branchs.branch_name_en',
                'branchs.abbreviations',
                'performance_appraisals.total_score',
                'performance_appraisals.total_score_live_staff',
                'performance_appraisals.total_score_direct_chairman'
            );

        // Filters
        $query->when($request->employee_id, fn($q,$employee_id) =>
            $q->where('generate_annaul_bonuses.employee_id', $employee_id)
        );

        $query->when($request->employee_name, fn($q,$employee_name) =>
            $q->where('users.employee_name_en', 'LIKE', "%{$employee_name}%")
        );

        $query->when($request->branch_id, fn($q,$branch_id) =>
            $q->where('users.branch_id', $branch_id)
        );

        $data = $query->get();
        $dataExcel = [];
        $no = 1;

        foreach ($data as $row) {
            $dataExcel[] = [
                $no++,
                $row->number_employee,
                $row->employee_name_kh,
                $row->gender_name_kh,
                $row->positions_name_kh,
                $row->abbreviations,
                $row->date_of_commencement,
                $row->basice_salary ?? '',
                $row->working_days_per_year ?? '',
                $row->incentive ?? '',
                $row->pa_score,
                $row->of_incentive_by_pa,
                $row->achieved_vs_pa,
                $row->number_months_received ?? '',
                $row->total_annaul_bounus ?? '',
            ];
        }

        $this->export_datas = $dataExcel;
    }

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

    public function headings(): array
    {
        return [
            "ល.រ",
            "ប័ណ្ណ ការងារ",
            "នាម និង គោត្តនាម",
            "ភេទ",
            "មុខងារ",
            "ទីតាំងការងារ",
            "ថ្ងៃចូលធ្វើការ",
            "បៀវត្សគោលចុងគ្រា ($)",
            "#ថ្ងៃធ្វើការក្នុងឆ្នាំ",
            "%​ប្រាក់លើកទឹកចិត្ត",
            "PA Score",
            "% of Incentive by PA",
            "% សម្រេចធៀបនឹង %PA",
            "ចំនួនខែត្រូវទទួលបាន",
            "ប្រាក់ឧបត្ថម្ភលើកទឹកចិត្តឆ្នាំ",
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 15,
            'C' => 22,
            'D' => 8,
            'E' => 18,
            'F' => 10,
            'G' => 18,
            'H' => 16,
            'I' => 16,
            'J' => 16,
            'K' => 12,
            'L' => 12,
            'M' => 12,
            'N' => 20,
            'O' => 22,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = count($this->export_datas) + 1;

                // Apply border for all used cells
                $sheet->getStyle("A1:O{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ]
                    ]
                ]);
            },
        ];
    }
}
