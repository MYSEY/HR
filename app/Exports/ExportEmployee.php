<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportEmployee implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents, WithTitle
{
    protected $export_datas;
    public function __construct($export_data)
    {
        $dataExport = [];
        foreach ($export_data as $users) {
            $dataExport[] = [
                "number_employee" => $users->number_employee,
                "last_name_kh" => $users->last_name_kh,
                "first_name_kh" => $users->first_name_kh,
                "last_name_en" => $users->last_name_en,
                "first_name_en" => $users->first_name_en,
                "gender" => $users->gender,
                "date_of_birth" => $users->date_of_birth ? Carbon::createFromDate($users->date_of_birth)->format('d-m-Y'): "",
                "emp_status" => $users->emp_status,
                "role" => $users->role_id,
                "join_date" =>  $users->date_of_commencement ? Carbon::createFromDate($users->date_of_commencement)->format('d-m-Y'): "",
                "fdc_date" => $users->fdc_date ? Carbon::createFromDate($users->fdc_date)->format('d-m-Y') : "",
                "fdc_end" => $users->fdc_end ? Carbon::createFromDate($users->fdc_end)->format('d-m-Y') : "",
                "resign_date" => $users->resign_date ? Carbon::createFromDate($users->resign_date)->format('d-m-Y'): "",
                "resign_reason" => $users->resign_reason,
                "branch_id" => $users->branch_id,
                "department_id" => $users->department_id,
                "position_id" => $users->position_id,
                "position_type" => $users->position_type,
                "unit" => $users->unit,
                "level" => $users->level,
                "nationality" => $users->nationality,
                "marital_status"=> $users->marital_status,
                "basic_salary" => $users->basic_salary,
                "phone_allowance" => $users->phone_allowance,
                "guarantee_letter" => "",
                "employment_book" => "",
                "personal_phone_number" => $users->personal_phone_number,
                "company_phone_number" => $users->company_phone_number,
                "agency_phone_number" => $users->agency_phone_number,
                "email" => $users->email ? $users->email : "",
                "spouse" => $users->spouse == null ? '' : $users->spouse,
                "is_loan" => $users->is_loan,
                "identity_type" => $users->identity_type,
                "identity_number" => $users->identity_number,
                "issue_date" => $users->issue_date ? Carbon::createFromDate($users->issue_date)->format('d-m-Y') : "",
                "issue_expired_date" => $users->issue_expired_date ? Carbon::createFromDate($users->issue_expired_date)->format('d-m-Y') : "",
                "password" => "",
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
        return 'A1';
    }
    // Khmer OS Muol Light
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,      
            'C' => 15,      
            'D' => 15,      
            'E' => 15,      
            'F' => 15,      
            'G' => 15,      
            'H' => 15,      
            'I' => 15,      
            'J' => 15,      
            'K' => 15,      
            'L' => 15,      
            'M' => 15,      
            'N' => 15,      
            'O' => 15,      
            'P' => 15,      
            'Q' => 15,      
            'R' => 15,      
            'S' => 15,      
            'T' => 15,      
            'U' => 15,      
            'V' => 15,
            'W' => 15,
            'X' => 15,
            'Y' => 15,
            'Z' => 15,
            'AA' => 15,
            'AB' => 15,
            'AC' => 15,
            'AD' => 15,
            'AE' => 15,
            'AF' => 15,
            'AG' => 15,
            'AH' => 15,
            'AI' => 15,
            'AJ' => 15,
            'AK' => 15,
        ];
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                $sheet->getDelegate()->getStyle('A1:AK1')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A1:AK1');
            },
        ];
    }
    public function title(): string
    {
        return 'Employee';
    }
    public function headings(): array
    {
        return [
            "Employee ID",
            "Last Name Khmer",
            "First Name Khmer",
            "Last Name English",
            "First Name English",
            "Gender",
            "Date Of Birth",
            "Employee Status",
            "Role",
            "Date of Commencement",
            "Start FDC",
            "End FDC",
            "Resign Date",
            "Resign Reason",
            "Branch",
            "Department",
            "Position",
            "Position Type",
            "Unit",
            "level",
            "Nationality",
            "Marital status",
            "Basic Salary",
            "Phone Allowance",
            "Guarantee Letter",
            "Employment Book",
            "Personal Phone",
            "Company Phone",
            "Agency Phone",
            "Email",
            "Spouse",
            "Loan",
            "Identity Type",
            "Identity Number",
            "Issue Date",
            "Issue Expired Date",
            "Password",
        ];
    }
}
