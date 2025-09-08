<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\AnnualBonu;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class GenerateAnnaulBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('generate_annual_bonus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            [$year, $month] = explode('-', $request->increasement_year);

            // Get increasement settings
            $data = AnnualBonu::where('increasement_year', $year)->orderBy('id')->get();

            // Get all approved performance records for that year/month
            $performances = Performance::whereYear('to_date', $year)->whereMonth('to_date', $month)->where('status', 'approved')->get();
            foreach ($performances as $kpiPerform) {
                $employeeId = $kpiPerform->employee_id;
                // KPI Score
                $kpiScores = (float) $kpiPerform->total_score_direct_chairman;

                // Match KPI score with increasement range
                $interest = 0;
                $total_percentage = 0;
                foreach ($data as $item) {
                    [$min, $max] = array_map('floatval', explode('-', $item->total_score));
                    if ($kpiScores >= $min && $kpiScores <= $max) {
                        $interest = $item->percentage / 100;
                        $total_percentage = $item->percentage;
                        break;
                    }
                }

                // Working days adjustment
                $user = User::find($employeeId);
                $dateOfCommencement = $user && $user->date_of_commencement ? Carbon::parse($user->date_of_commencement) : Carbon::create($year, 1, 1);
                $endOfYear = Carbon::create($year, 12, 31);
                $months = $dateOfCommencement->diffInMonths($endOfYear) + 1; // +1 if inclusive
                if ($months > 2) {
                    $endOfYear = Carbon::create($year, 12, 31);
                    $totalWorkingDays = $dateOfCommencement->diffInDays($endOfYear) + 1;
                    $daysInYear = $endOfYear->isLeapYear() ? 366 : 365;
    
                    if ($totalWorkingDays > $daysInYear) {
                        $totalWorkingDays = $daysInYear;
                    }
                    $totalsAnnaulBonus = (400/365) * $totalWorkingDays;

                    dd([
                        'employee_id' => $employeeId,
                        'performance_id' => $kpiPerform->id,
                        'increasement_of_year' => $request->increasement_year,
                        'score' => $kpiScores,
                        'annaul_bonus' => $totalsAnnaulBonus,
                        'percentage' => $total_percentage,
                        'created_by' => Auth::id(),
                    ]);
                    // Final salary increasement calculation
                    
                    // Replace old record for this employee/year-month
                    // GenerateAnnualSalaryIncreasement::where('employee_id', $employeeId)->where('increasement_of_year', $request->increasement_year)->delete();
    
                    // GenerateAnnualSalaryIncreasement::create([
                    //     'employee_id' => $employeeId,
                    //     'performance_id' => $kpiPerform->id,
                    //     'basic_salary' => $payroll->basic_salary,
                    //     'increasement_of_year' => $request->increasement_year,
                    //     'salary_increasement' => $totalsAnnaulBonus,
                    //     'percentage' => $total_percentage,
                    //     'created_by' => Auth::id(),
                    // ]);
                }
            }
            DB::commit();
            Toastr::success('Generate annual bonus successfully','Success');
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Generate annual bonus fail','Error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
