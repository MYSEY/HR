<?php

namespace App\Traits;

use App\Models\ExpenseRequest;
use App\Models\FnRegularExspense;
use Carbon\Carbon;
use App\Models\GenerateIdEmployee;
use App\Models\GenerateIdExpense;

trait GeneratingCode
{
   
    //*** Generate employee
    public function generate_EmployeeId($date)
    {
        $count = 0;
        $employeeDate = Carbon::parse($date);
        $lastInId = GenerateIdEmployee::orderBy('number_employee', 'DESC')->get();
        if (!empty($lastInId)) {
            for ($i = 0; $i < count($lastInId); $i++) {
                $current = (int) substr(strrchr($lastInId[$i]->number_employee, "-"), 1);
                if ($i + 1 < count($lastInId)) {
                    $next = (int) substr(strrchr($lastInId[$i + 1]->number_employee, "-"), 1);
                }
                if (isset($next) && $current + 1 != $next) {
                    $count = (int) substr(strrchr($lastInId[$i]->number_employee, "-"), 1);
                    break;
                } else {
                    $count = (int) substr(strrchr($lastInId[$i]->number_employee, "-"), 1);
                }
            }
        }
        
        do {
            $eployeeId =  $employeeDate->format('y') .'0'. '-' . str_pad(($count + 1), 3, "0", STR_PAD_LEFT);
            $alreadyExist = GenerateIdEmployee::select('number_employee')->where('number_employee', $eployeeId)->first()->number_employee ?? null;
            $count++;
        } while ($alreadyExist);
        return [
            'number_employee' => $eployeeId
        ];
    }
    //*** Generate Expense
    public function generateExpenseCode($date)
     {
         $count = 0;
         $expDate = Carbon::parse($date);
         $lastInId = ExpenseRequest::orderBy('tracking_id', 'DESC')->get();
         if (!empty($lastInId)) {
             for ($i = 0; $i < count($lastInId); $i++) {
                 $current = (int) substr(strrchr($lastInId[$i]->tracking_id, "-"), 1);
                 if ($i + 1 < count($lastInId)) {
                     $next = (int) substr(strrchr($lastInId[$i + 1]->tracking_id, "-"), 1);
                 }
                 if (isset($next) && $current + 1 != $next) {
                     $count = (int) substr(strrchr($lastInId[$i]->tracking_id, "-"), 1);
                     break;
                 } else {
                     $count = (int) substr(strrchr($lastInId[$i]->tracking_id, "-"), 1);
                 }
             }
         }
         
         do {
            $year = $expDate->format('y');
            $month = $expDate->format('m');
            $day = $expDate->format('d');
             $expId =  "FND".$year.$month.$day. str_pad(($count + 1), 3, "0", STR_PAD_LEFT);
             $alreadyExist = ExpenseRequest::select('tracking_id')->where('tracking_id', $expId)->first()->tracking_id ?? null;
             $count++;
         } while ($alreadyExist);
         return [
             'tracking_id' => $expId
         ];
     }
    //*** Generate Serialef
    public function generateSerialCode($date)
     {
         $count = 0;
         $expDate = Carbon::parse($date);
         $lastInId = FnRegularExspense::orderBy('serialref', 'DESC')->get();
         if (!empty($lastInId)) {
             for ($i = 0; $i < count($lastInId); $i++) {
                 $current = (int) substr(strrchr($lastInId[$i]->serialref, "-"), 1);
                 if ($i + 1 < count($lastInId)) {
                     $next = (int) substr(strrchr($lastInId[$i + 1]->serialref, "-"), 1);
                 }
                 if (isset($next) && $current + 1 != $next) {
                     $count = (int) substr(strrchr($lastInId[$i]->serialref, "-"), 1);
                     break;
                 } else {
                     $count = (int) substr(strrchr($lastInId[$i]->serialref, "-"), 1);
                 }
             }
         }
         
         do {
            $year = $expDate->format('y');
            $month = $expDate->format('m');
            $day = $expDate->format('d');
             $expId =  "REF".$year.$month.$day. str_pad(($count + 1), 3, "0", STR_PAD_LEFT);
             $alreadyExist = FnRegularExspense::select('serialref')->where('serialref', $expId)->first()->serialref ?? null;
             $count++;
         } while ($alreadyExist);
         return [
             'serialref' => $expId
         ];
     }
}
