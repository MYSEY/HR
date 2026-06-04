<?php

namespace App\Exports;

use App\Helpers\Helper;
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
use Illuminate\Support\Facades\Auth;

class ExportEmployee implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents, WithTitle
{
    protected $export_datas;
    public function __construct($export_data)
    {
        $dataExport = [];
        
        foreach ($export_data as $users) {
            $salary = 0;
            $phone_allowance = 0;
            if(permissionAccess("m2-s1","is_view_salary_staff")->value == "1"){
                $salary = $users->basic_salary;
                $phone_allowance = $users->phone_allowance;
            }
            if(permissionAccess("m2-s1","is_view_salary_staff")->value != "1" && permissionAccess("m2-s1","is_view_salary")->value == "1" && $users->id == Auth::user()->id){
                $salary = $users->basic_salary;
                 $phone_allowance = $users->phone_allowance;
            };

            $dataExport[] = [
                "number_employee" => $users->number_employee,
                "last_name_kh" => $users->last_name_kh,
                "first_name_kh" => $users->first_name_kh,
                "last_name_en" => $users->last_name_en,
                "first_name_en" => $users->first_name_en,
                "id_card_number" => $users->id_card_number,
                "gender" => $users->EmployeeGender,
                "date_of_birth" => $users->date_of_birth ? Carbon::createFromDate($users->date_of_birth)->format('d-m-Y'): "",
                "emp_status" => $users->emp_status,
                "role" => $users->role_id,
                "join_date" =>  $users->date_of_commencement ? Carbon::createFromDate($users->date_of_commencement)->format('d-m-Y'): "",
                "fdc_date" => $users->fdc_date ? Carbon::createFromDate($users->fdc_date)->format('d-m-Y') : "",
                "fdc_end" => $users->fdc_end ? Carbon::createFromDate($users->fdc_end)->format('d-m-Y') : "",
                "udc_end_date" => $users->udc_end_date ? Carbon::createFromDate($users->udc_end_date)->format('d-m-Y') : "",
                "resign_date" => $users->resign_date ? Carbon::createFromDate($users->resign_date)->format('d-m-Y'): "",
                "resign_reason" => $users->EmployeeResignReason == null ? $users->resign_reason : $users->EmployeeResignReason,
                "branch_id" => Helper::getLang() == 'en' ? $users->branch->branch_name_en : $users->branch->branch_name_kh,
                "department_id" => Helper::getLang() == 'en' ? $users->department->name_english : $users->department->name_khmer,
                "position_id" => Helper::getLang() == 'en' ? $users->position->name_english : $users->position->name_khmer,
                "position_type" => $users->positiontype ? $users->positiontype->name_english : "",
                "unit" => $users->unit,
                "level" => $users->level,
                "nationality" => $users->EmployeeNationality,
                "marital_status"=> $users->EmployeeMaritalStatus,
                "basic_salary" => $salary,
                "phone_allowance" => $phone_allowance,
                // "basic_salary" => permissionAccess("m2-s1","is_view_salary")->value == "1" ? $users->basic_salary : 0,
                // "phone_allowance" => $users->phone_allowance,
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

                "current_province"  =>  $users->current_province,
                "current_district"  =>  $users->current_district,
                "current_commune"   =>  $users->current_commune,
                "current_village"   =>  $users->current_village,
                "permanent_province"=>  $users->permanent_province,
                "permanent_district"=>  $users->permanent_district,
                "permanent_commune" =>  $users->permanent_commune,
                "permanent_village" =>  $users->permanent_village

                // "current_province"  =>  $users->currentprovince ? $users->currentprovince->name_en : "",
                // "current_district"  =>  $users->currentdistrict ? $users->currentdistrict->name_en : "",
                // "current_commune"   =>  $users->currentcommune ? $users->currentcommune->name_en : "",
                // "current_village"   =>  $users->currentvillage ? $users->currentvillage->name_en : "",
                // "permanent_province"=>  $users->permanentprovince ? $users->permanentprovince->name_en : "",
                // "permanent_district"=>  $users->permanent_district ? $users->permanentdistrict->name_en : "",
                // "permanent_commune" =>  $users->permanent_commune ? $users->permanentcommune->name_en : "",
                // "permanent_village" =>  $users->permanent_village ? $users->permanentvillage->name_en : "",

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
            'AL' => 15,
            'AM' => 15,
            'AN' => 15,
            'AO' => 15,
            'AP' => 15,
            'AQ' => 15,
            'AR' => 15,
            'AS' => 15,
            'AT' => 15,
        ];
    }
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                $sheet->getDelegate()->getStyle('A1:AT1')->getFont()->setName('Khmer OS Battambang')
                ->setSize(9)->setBold('A1:AT1');
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
            "id_card_number",
            "Gender",
            "Date Of Birth",
            "Employee Status",
            "Role",
            "Date of Commencement",
            "Start FDC",
            "End FDC",
            "udc_end_date",
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
            "Current Province",
            "Current District",
            "Current Commune",
            "Current Village",
            "Permanent Province",
            "Permanent District",
            "Permanent Commune",
            "Permanent Village",
        ];
    }
}
