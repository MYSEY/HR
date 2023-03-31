<?php

namespace App\Helpers;

use \Carbon\Carbon;
use App\Models\Setting;
use App\Traits\AddressTrait;

class Helper
{
    use AddressTrait;
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

   
    // GET DYNAMIC LANGUAGE
    static function getLang()
    {
        return app()->getLocale();
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
    // PHONE FORMAT AND REMOVE +855
    static function formatPhoneNumber($number)
    {
        if (!empty($number)) {
            $global = $number . '0';
            if (substr($global, 0, 4) == '+855') {
                $local = '0' . substr($global, 4, -1);
                return preg_replace('/\d{3}/', '$0 ', str_replace('.', '', trim($local)), 2);
            }
        }
        return null;
    }
    // REMOVE +855 FROM PHONE
    static function removeGlobalPhoneNumber($phone)
    {
        if (!empty($phone)) {
            $resault = preg_replace(
                '/\+(?:998|996|995|994|993|992|977|976|975|974|973|972|971|970|968|967|966|965|964|963|962|961|960|886|880|856|855|853|852|850|692|691|690|689|688|687|686|685|683|682|681|680|679|678|677|676|675|674|673|672|670|599|598|597|595|593|592|591|590|509|508|507|506|505|504|503|502|501|500|423|421|420|389|387|386|385|383|382|381|380|379|378|377|376|375|374|373|372|371|370|359|358|357|356|355|354|353|352|351|350|299|298|297|291|290|269|268|267|266|265|264|263|262|261|260|258|257|256|255|254|253|252|251|250|249|248|246|245|244|243|242|241|240|239|238|237|236|235|234|233|232|231|230|229|228|227|226|225|224|223|222|221|220|218|216|213|212|211|98|95|94|93|92|91|90|86|84|82|81|66|65|64|63|62|61|60|58|57|56|55|54|53|52|51|49|48|47|46|45|44\D?1624|44\D?1534|44\D?1481|44|43|41|40|39|36|34|33|32|31|30|27|20|7|1\D?939|1\D?876|1\D?869|1\D?868|1\D?849|1\D?829|1\D?809|1\D?787|1\D?784|1\D?767|1\D?758|1\D?721|1\D?684|1\D?671|1\D?670|1\D?664|1\D?649|1\D?473|1\D?441|1\D?345|1\D?340|1\D?284|1\D?268|1\D?264|1\D?246|1\D?242|1)\D?/',
                '',
                $phone
            );
            return '0' . $resault;
        }
    }
    // ADD +855 TO PHONE
    static function AddGlobalPhoneNumber($number)
    {
        if (!empty($number)) {
            $string = preg_replace("/[^A-Za-z0-9]/", "", $number);
            $digit = (string)$string;
            if (substr($digit, 0, 1) == '0') :
                return '+855' . ltrim($digit, '0');
            endif;
            return '+855' . $digit;
        }
        return null;
    }
   
    /**
     * @param string $value
     * @return boolean
     */
    static function isUrl($value)
    {
        if (!empty($value) && filter_var($value, FILTER_VALIDATE_URL) !== false) {
            return true;
        }
        return false;
    }
    static function is_extensions($string)
    {
        if (!empty($string)) :
            return strtolower(substr(strrchr($string, '.'), 1));
        endif;
        return null;
    }
    static function checkImageExtension($file)
    {
        $fileExt = self::is_extensions($file);
        $extension = ['jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp', 'png', 'ico', 'cur'];

        return (!empty($file) && in_array($fileExt, $extension)) ? true : false;
    }
    static function checkPdfExtension($extension)
    {
        if (!empty($extension) && in_array(self::is_extensions($extension), ['pdf'])) {
            return true;
        }
        return false;
    }
    static function checkDocxExtension($extension)
    {
        if (!empty($extension) && in_array(self::is_extensions($extension), ['docx'])) {
            return true;
        }
        return false;
    }
    static function checkPptxExtension($extension)
    {
        if (!empty($extension) && in_array(self::is_extensions($extension), ['pptx'])) {
            return true;
        }
        return false;
    }
    /**
     * @param string $value
     * @return string
     */
    static function lastSlashUrlValue($value)
    {
        if (!empty($value) && self::isUrl($value)) {
            return substr(strrchr($value, '/'), 1);
        }
        return null;
    }
    /**
     * @param int $date Date
     * @return integer
     */
    static function findingNumberOfDaysBetweenNow($date)
    {
        try {

            if (!empty($date)) :
                $startDate = Carbon::parse($date);
                $currentDate = Carbon::now();
                $numberOfDays = $startDate->diffInDays($currentDate);
            endif;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $numberOfDays ?? null;
    }


    /**
     * @param string $status
     * @return string
     */
    static function statuslist($status)
    {
        $returnValue = '';
        $end_tags = '</strong></span>';
        switch (strtolower($status)) {
            case 'Probation':
                $returnValue = '<span class="text-warning"><strong>' . 'Probation' .  $end_tags;
                break;
            case 'approval':
                $returnValue = '<span class="text-primary"><strong>' . 'approval' . $end_tags;
                break;
            case 'active':
                $returnValue = '<span class="text-primary"><strong>' . 'active' . $end_tags;
                break;
            case 'rejected':
                $returnValue = '<span class="text-danger"><strong>' . 'rejected' . $end_tags;
                break;
            default:
                $returnValue = '<div class="action-label">
                    <a class="btn btn-white btn-sm btn-rounded" style="border-radius: 50px;background-color: #198754;border: 1px solid #cccccc;color: white;" href="javascript:void(0);">Probation</a>
                </div>';
        }
        return $returnValue;
    }

 
  
    static function getDateInFormat($D, $format = 'd/m/Y', $lang = 'en', $ENN = 'N')
    {
        $DObj = strtotime((string)$D);
        list($YYYY, $MM, $DD) = explode('-', date('Y-m-d', $DObj));

        if ($lang == 'kh') {
            $DateInKH = ['0' => 'ច័ន្ទ', '1' => 'អង្គារ', '2' => 'ពុធ', '3' => 'ព្រហស្បតិ៍', '4' => 'សុក្រ', '5' => 'សៅរ៍', '6' => 'អាទិត្យ'];
            $MonthInKH = [
                '01' => 'មករា', '02' => 'កុម្ភះ', '03' => 'មីនា', '04' => 'មេសា',
                '05' => 'ឧសភា', '06' => 'មិថុនា', '07' => 'កក្កដា', '08' => 'សីហា',
                '09' => 'កញ្ញា', '10' => 'តុលា', '11' => 'វិច្ឆិការ', '12' => 'ធ្នូ'
            ];

            if ($format == "MM") {
                return $MonthInKH[$D];
            }
            if ($format == "DD") {
                return self::kh_number($D);
            }

            $LMN = $MonthInKH[$MM];
            $LDN = $DateInKH[(string)date('w', $DObj)];

            $DR = str_replace(
                'Y',
                $YYYY,
                str_replace(
                    'm',
                    $MM,
                    str_replace(
                        'd',
                        $DD,
                        str_replace(
                            'l',
                            $LDN,
                            str_replace('F', $LMN, $format)
                        )
                    )
                )
            );
            if ($ENN == 'N') {
                $DR = self::kh_number($DR);
            }
        } else {
            $DR = date($format, $DObj);
        }
        return $DR;
    }
}
