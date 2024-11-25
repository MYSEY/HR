<?php

namespace App\Helpers;

use App\Models\permissions;
use \Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Models\Setting;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use KhmerDateTime\KhmerDateTime;

class Helper
{
    /**
     * @param string $value
     * @param string $format
     * @return string
     * USAGE:
     * Helper::dateFormating($value, $format)
     */
    static function dateFormating($value = null, $format = null)
    {
        $val = '';
        if (empty($format) && empty($value)) {
            $val = Carbon::today()->format('d-m-Y');
        } elseif ($format == 'd-m-Y') {
            $val = Carbon::parse($value)->format('d-m-Y');
        } elseif ($format == 'Y-m-d') {
            $val = Carbon::parse($value)->format('Y-m-d');
        } else {
            $val = Carbon::parse($value)->format('Y-m-d H:i');
        }
        return $val;
    }
    static function isUrl($value)
    {
        if (!empty($value) && filter_var($value, FILTER_VALIDATE_URL) !== false) {
            return true;
        }
        return false;
    }
    /**
     * @param int $value
     * @param int $length
     * @param string $symbol
     * @return string
     * USAGE:
     * Helper::formatCurrency(120.50)
     */
    static function formatCurrency($value, $symbol = null, $showSymbol = true, $length = 2)
    {
        if (is_numeric($value) && !empty($symbol) && is_numeric($length)) {
            if (strtolower($symbol) == "usd" || $symbol == "$") {
                return self::formatCurrencyDollar($value, $length, $symbol, $showSymbol);
            }
            if (strtolower($symbol) == "riel" || $symbol == "៛") {
                return self::formatCurrencyRiel($value, $symbol, $showSymbol);
            }
        }
        return null;
    }
    /**
     * @param int $value
     * @param int $leng
     * @param string $symbol
     * @return string
     * USAGE:
     * Helper::formatCurrencyDollar(120.50)
     */
    static function formatCurrencyDollar($value, $leng = 2, $symbol = "$", $showSymbol = true)
    {
        if (is_numeric($value) && is_numeric($leng)) {
            $symbol = strtolower($symbol) == 'usd' ? strtoupper($symbol) : $symbol;
            if ($showSymbol) {
                return $symbol . number_format($value, $leng);
            } else {
                return number_format($value, $leng);
            }
        }
        return null;
    }
    /**
     * @param int $value
     * @param int $leng
     * @param string $symbol
     * @return string
     * USAGE:
     * Helper::formatCurrencyRiel(120.50)
     */
    static function formatCurrencyRiel($value, $symbol = '៛', $showSymbol = true)
    {
        if (is_numeric($value)) {
            $amount = round($value / 100) * 100;
            $symbol = strtolower($symbol) == 'riel' ? strtoupper($symbol) : $symbol;
            if ($showSymbol) {
                return number_format($amount, 0, ',', ',') . $symbol;
            } else {
                return number_format($amount, 0, ',', ',');
            }
        }
        return null;
    }
    // ROTANA : FIND LEAD YEAR
    static function is_leap_year($year)
    {
        return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
    }

    // GET DYNAMIC LANGUAGE
    static function getLang()
    {
        return app()->getLocale();
    }

    static function getKhmerMonths($data){
        $month = Carbon::now()->format('Y');
        $dateTime = KhmerDateTime::parse($month);
        $monthKH = $dateTime->fullMonth();
        $yearKH = $dateTime->year();
        $result = "ប្រាក់បៀវត្សរ៍ប្ររ៍ចាំខែ".' : '.$monthKH.' '.$yearKH;
        return $result;
    }
    static function geENMonths($data){
        $month = Carbon::now()->format('M Y');
        $result = "Employee Payslip".' : '.$month;
        return $result;
    }
    static function startOfLastendOfLastMonth(){
        $currentDay = Carbon::now()->format('d');
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        if ($currentDay > 20 ) {
            $startOfLastMonth = Carbon::now()->startOfMonth();
            $endOfLastMonth = Carbon::now()->endOfMonth();
        }
        return (object) [
            "startOfLastMonth" => $startOfLastMonth,
            "endOfLastMonth" => $endOfLastMonth
        ];
    }


    static function getKhmerMonthsMotorRantal($data){
        $month = Carbon::now()->format('Y');
        $dateTime = KhmerDateTime::parse($month);
        $monthKH = $dateTime->fullMonth();
        $yearKH = $dateTime->year();
        $result = "ថ្លៃជួលប្រចាំខែ".' : '.$monthKH.' '.$yearKH;
        return $result;
    }
    static function getENMonthsMotorRantal($data){
        $month = Carbon::now()->format('M Y');
        $result = "Monthly Rental Fee".' : '.$month;
        return $result;
    }

    static function permissionAccess($menu_id,$name_button){
        $id=Auth::user()->role_id;
        $permission = permissions::where('role_id',$id)->get()->toArray();
        $arrayPermissions = [];
        foreach ($permission as $row) {
            $arrayPermissions[$row["menu_id"]] = $row;
        }
        return $arrayPermissions[$menu_id][$name_button];
    }

    static public function getCurrenYear(){
        if (Helper::getLang() == 'en') {
            $month = Carbon::now()->format('Y');
            $result = $month;
        }else{
            $month = Carbon::now()->format('Y');
            $dateTime = KhmerDateTime::parse($month);
            $year = $dateTime->year();
            $result = $year;
        }
        return $result;
    }

    //function  count daty remove Saturday and Sunday

    static public function countWeekdays($startDate, $endDate)
    {
        // Create Carbon instances for the start and end dates
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Generate the period between the dates
        $period = CarbonPeriod::create($start, $end);

        // Filter out Saturdays and Sundays
        $weekdays = $period->filter(function (Carbon $date) {
            return !$date->isWeekend();
        });

        // Return the count of weekdays
        return $weekdays->count();
    }

    static public function calculateAgeMotor($year){
        $now = new DateTime();
        $past = new DateTime($year . '-01-01');
        $nowYear = (int)$now->format('Y');
        $pastYear = (int)$past->format('Y');
        $age = $nowYear - $pastYear;
        return $age;
    }

    static public function countWorkingDays($fromDate, $toDate) {
        $start = Carbon::parse($fromDate);
        $end = Carbon::parse($toDate);
    
        $workingDays = 0;
    
        while ($start->lte($end)) {
            if (!$start->isWeekend()) { // Check if the day is not a weekend
                $workingDays++;
            }
            $start->addDay(); // Move to the next day
        }
    
        return $workingDays;
    }
}
