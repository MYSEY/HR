<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\Payroll;
use Faker\Calculator\Inn;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class EmployeePayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return view('payrolls.index',compact('user'));
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
        $amount_exchang = '4065';
        $pension_contribution = 5.91;
       
        //calculated khmer_new_year and pchumBen_bonus
        $employee = User::where('id',$request->employee_id)->first();
        $userJoinDate = $employee->date_of_commencement;
        $days = Carbon::now()->diffInDays($userJoinDate);
        $months = Carbon::now()->diffInMonths($userJoinDate);
        $years = Carbon::now()->diffInYears($userJoinDate);
        $dayOf365 = 365;
        if($request->khmer_new_year_pchum_ben_allowance == null){
            if ($years == 0) {
                $totalSalaryDay = ($request->net_salary * $days) / $dayOf365;
                $totalSalaryKhmerPchumBen = $totalSalaryDay + $request->net_salary;
            } else {
                $percentSalary = ($request->net_salary * $request->khmer_new_year_pchum_ben_allowance) / 100;
                $totalSalaryKhmerPchumBen = $percentSalary + $request->net_salary;
            }
        }

        // sum benefit children
        if ($employee->number_of_children == null) {
            $totalAmountChild = 0;
        } else if($employee->number_of_children == 1) {
            $totalAmountChild = 10;
        }else if($employee->number_of_children == 2){
            $totalAmountChild = 20;
        }else if($employee->number_of_children == 3){
            $totalAmountChild = 30;
        }else if($employee->number_of_children == 4){
            $totalAmountChild = 40;
        }
        // dd($totalAmountChild);

        //sum salary and sum other benefit
        if ($request->khmer_new_year_pchum_ben_allowance == null) {
            $totalGrossSalary = $totalSalaryKhmerPchumBen + $request->phone_allowance + $request->monthly_quarterly_bonuses + $request->annual_incentive_bonus + $request->other_allowances + $totalAmountChild - $pension_contribution;
        } else {
            $totalGrossSalary = $request->net_salary + $request->phone_allowance + $request->monthly_quarterly_bonuses + $request->annual_incentive_bonus + $request->other_allowances + $totalAmountChild - $pension_contribution;
        }
        
        // dd($totalGrossSalary);

        //total exchange rate
        $totalExchangeRiel =  $amount_exchang * $totalGrossSalary;

        //total that កាត់បន្ទុកកូន
        if ($employee->number_of_children == null) {
            $totalChargesReduced = 0;
        } else if($employee->number_of_children == 1) {
            $totalChargesReduced = 150000;
        }else if($employee->number_of_children == 2){
            $totalChargesReduced =  300000;
        }else if($employee->number_of_children == 3){
            $totalChargesReduced =  450000;
        }else if($employee->number_of_children == 4){
            $totalChargesReduced = 600000;
        }
        
        // dd($totalExchangeRiel);

        
        //មូលដ្ឋានគិតពន្ធ
        if ($employee->number_of_children == null) {
            $totalTtaxBbaseRiel = $totalExchangeRiel;
        } else if($employee->number_of_children == 1) {
            $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
        }else if($employee->number_of_children == 2){
            $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
        }else if($employee->number_of_children == 3){
            $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
        }else if($employee->number_of_children == 4){
            $totalTtaxBbaseRiel = $totalExchangeRiel - $totalChargesReduced;
        }
        
        // dd($totalTtaxBbaseRiel);

        // អត្រា ពន្ធ(%)
        if($totalExchangeRiel >= 0 && $totalExchangeRiel <= 1500000){
            $totalTax = 0;
        }elseif($totalExchangeRiel >= 1500001 && $totalExchangeRiel <= 2000000){
            $totalTax = 5;
        }elseif($totalExchangeRiel >= 2000001 && $totalExchangeRiel <= 8500000){
            $totalTax = 10;
        }elseif($totalExchangeRiel >= 8500001 && $totalExchangeRiel <= 12500000){
            $totalTax = 15;
        }else{
            $totalTax = 20;
        }

        // dd($totalExchangeRiel);

        //​cululate salaray Taxable
        if($totalExchangeRiel <= 1500000){
            $totalSalaryTaxRiel = 0;
        }elseif($totalExchangeRiel > 1500001 && $totalExchangeRiel <= 2000000){
            $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 75000;
        }elseif($totalExchangeRiel > 2000001 && $totalExchangeRiel <= 8500000){
            $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 175000;
        }elseif($totalExchangeRiel > 8500001 && $totalExchangeRiel <= 12500000){
            $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 600000;
        }else{
            $totalSalaryTaxRiel = ($totalExchangeRiel * $totalTax) / 100 - 1225000;
        }

        //ពន្ធលើប្រាក់បៀវត្ស រៀល/Riel
        $totalSalaryTaxUsd = round($totalSalaryTaxRiel / $amount_exchang,2);
        dd($totalSalaryTaxUsd);

        // if ($employee->number_of_children == null) {
        //     $totalSalaryTaxUsd = 0;
        // } else if($employee->number_of_children == 1) {
        //     $totalSalaryTaxUsd - $totalChargesReduced;
        // }else if($employee->number_of_children == 2){
        //     $totalSalaryTaxUsd - $totalChargesReduced;
        // }else if($employee->number_of_children == 3){
        //     $totalSalaryTaxUsd =  - $totalChargesReduced;
        // }else if($employee->number_of_children == 4){
        //     $totalSalaryTaxUsd - $totalChargesReduced;
        // }
        dd($totalSalaryTaxUsd);
        //ពន្ធលើប្រាក់បៀវត្ស ដុល្លារ/USD
        $totalSalaryAfterTax = $totalGrossSalary - $totalSalaryTaxUsd;
        dd($totalSalaryAfterTax);
        Payroll::create([
            'employee_id'               => $request->employee_id,
            'net_salary'                => number_format($request->net_salary,2),
            'payment_amount'            => number_format($request->net_salary,2),
            'total_gross_salary'            => number_format($request->net_salary,2),
            'total_child_allowance'            => $totalAmountChild,
            'phone_allowance'            => $request->phone_allowance,
            'monthly_quarterly_bonuses'            => $request->monthly_quarterly_bonuses,
            'khmer_new_year_pchum_ben_allowance'            => $request->khmer_new_year_pchum_ben_allowance,
            'annual_incentive_bonus'            => $request->annual_incentive_bonus,
            'base_salary_received_usd'  => number_format($totalGrossSalary,2),
            'base_salary_received_riel' => number_format($totalExchangeRiel),
            'tax_base_riel'             => number_format($totalTtaxBbaseRiel),
            'total_charges_reduced'             => number_format($totalChargesReduced),
            'total_rate'                => $totalTax,
            'total_salary_tax_riel'     => number_format($totalSalaryTaxRiel),
            'total_salary_tax_usd'      => $totalSalaryTaxUsd,
            'total_salary'              => $totalSalaryAfterTax,
        ]);
        Toastr::success('Created prayroll successfully.','Success');
        return redirect()->back();
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
