<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Position;
use App\Models\Education;

class SyncHrDataToPgsql extends Command
{
    protected $signature = 'sync:hr-pgsql';
    protected $description = 'Sync positions, employees, education_informations to PostgreSQL';

    public function handle()
    {
        $this->info('===== HR DATA SYNC START =====');

        DB::connection('pgsql_bi')->beginTransaction();

        try {
            // Disable FK checks (PostgreSQL)
            DB::connection('pgsql_bi')->statement("SET session_replication_role = replica");

            $this->syncPositions();
            $this->syncEmployees();
            $this->syncEducations();

            DB::connection('pgsql_bi')->statement("SET session_replication_role = DEFAULT");
            DB::connection('pgsql_bi')->commit();

            $this->info('===== HR DATA SYNC SUCCESS =====');
            return Command::SUCCESS;

        } catch (\Throwable $e) {

            DB::connection('pgsql_bi')->rollBack();
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }

    // ================= POSITIONS =================
    private function syncPositions()
    {
        $this->info('Syncing positions...');

        Position::chunk(300, function ($positions) {

            $data = [];

            foreach ($positions as $p) {
                $data[] = [
                    'id'                    => $p->id,
                    'name_khmer'            => $p->name_khmer,
                    'name_english'          => $p->name_english,
                    'type'                  => $p->type,

                    // ✅ use NULL instead of ""
                    'position_level'        => null,
                    'position_type'         => $p->position_type,
                    'position_tax'          => $p->position_range,
                    'managerial_posistion'  => null,
                ];
            }

            DB::connection('pgsql_bi')
                ->table('positions')
                ->upsert(
                    $data,
                    ['id'], // must be UNIQUE or PK
                    [
                        'name_khmer',
                        'name_english',
                        'type',
                        'position_level',
                        'position_type',
                        'position_tax',
                        'managerial_posistion',
                    ]
                );
        });

    }

    // ================= EMPLOYEES =================
    private function syncEmployees()
    {
        $this->info('Syncing employees...');

      User::whereIn('emp_status', ['Probation','2','3','4','5','6','7','8','9','10'])
        ->with(['branch', 'employeeGender'])
        ->chunk(300, function ($users) {

            foreach ($users as $u) {
                DB::connection('pgsql_bi')
                    ->table('employees')
                    ->updateOrInsert(
                        // WHERE (unique key)
                        ['id' => $u->id],

                        // VALUES
                        [
                            'number_employee'       => $u->number_employee,
                            'employee_name_kh'      => $u->employee_name_kh,
                            'employee_name_en'      => $u->employee_name_en,
                            'gender'                => $u->employeeGender,
                            'position_id'           => $u->position_id,
                            'location_en'           => optional($u->branch)->branch_name_en,
                            'location_kh'           => optional($u->branch)->branch_name_kh,
                            'date_of_commencement'  => $u->date_of_commencement,
                            'date_of_birth'         => $u->date_of_birth,
                            'marital_status'        => $u->EmployeeMaritalStatus,
                            'is_loan'               => $u->is_loan,
                            'emp_status'            => $u->emp_status,
                            'resign_date'           => $u->resign_date,
                            'report_date'           => now(),
                        ]
                    );
            }
        });
    }

    // ================= EDUCATION =================
    private function syncEducations()
    {
        $this->info('Syncing education_informations...');

        Education::with(['optionDegree', 'optionFieldofstudy'])
        ->chunk(300, function ($educations) {

            $data = [];

            foreach ($educations as $e) {
                $data[] = [
                    'id'             => $e->id,
                    'employee_id'    => $e->employee_id,
                    'school'         => $e->school,
                    'degree'         => optional($e->optionDegree)->name_english,
                    'field_of_study' => optional($e->optionFieldofstudy)->name_english,
                    'start_date'     => $e->start_date,
                    'end_date'       => $e->end_date,
                    'grade'          => $e->grade,
                ];
            }

            DB::connection('pgsql_bi')
                ->table('education_informations')
                ->upsert(
                    $data,
                    ['id'], // MUST be UNIQUE in PostgreSQL
                    [
                        'employee_id',
                        'school',
                        'degree',
                        'field_of_study',
                        'start_date',
                        'end_date',
                        'grade',
                    ]
                );
        });
    }
}
