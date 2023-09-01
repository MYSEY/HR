<?php

namespace App\Traits\Convertors;

use App\Models\Currency;
use Illuminate\Support\Str;

/**
 * How to use
 * use \App\Traits\Convertors\NumberTrait;
 */
trait NumberTrait
{
    // Khmer Number *************************
    public static function kh_number($number)
    {
        try {
            $standard_number = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
            $khmer_number = array("០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩");
            return str_replace($standard_number, $khmer_number, $number);
        } catch (\Exception $exp) {
            return null;
        }
    }

    // Khmer Digital Number *************************
    public static function kh_digital_number($number)
    {
        $kh_digitals = number_format(self::unformat_currency($number), 2, ".", ",");

        $kh_number = ["០", '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        for ($i = 0; $i < 10; $i++) {
            $kh_digitals = str_replace($i, $kh_number[$i], $kh_digitals);
        }
        return $kh_digitals ?? '';
    }

    // Khmer Number Format *************************
    public static function kh_format_number($number)
    {
        $kh_digitals = number_format($number);

        $kh_number = ["០", '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        for ($i = 0; $i < 10; $i++) {
            $kh_digitals = str_replace($i, $kh_number[$i], $kh_digitals);
        }
        return $kh_digitals ?? '';
    }

    // Khmer Number Format *************************
    public static function kh_format_number_ft_string($string)
    {
        $kh_number = ["០", '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        for ($i = 0; $i < 10; $i++) {
            $string = str_replace($i, $kh_number[$i], $string);
        }
        return Str::length($string) > 0 ? $string : null;
    }

    // International number *************************
    public static function digital_number($amount, $digit = 2)
    {
        try {
            if (!empty($digit) && is_numeric($digit)) {
                return number_format($amount, $digit);
            } else {
                return $amount;
            }
        } catch (\Exception $e) {
            /**
             * ERROR
             */
        }
    }

    // _________ Unformat money when parsing _________ \\
    public static function unformat_currency($value)
    {
        try {
            return floatval(preg_replace('/[^\d\.]/', '', $value));
        } catch (\Exception $e) {
            /**
             * ERROR
             */
        }
        return NULL;
    }

    // _________ Shorten long number to KMB _________ \\
    public static function shorten_long_numbers_2KMB($value)
    {
        $money = '';
        if (is_numeric($value)) :
            // If number bigger than zero
            if ($value >= 1000000000) {
                $val = ($value / 1000000000);
                $money = round($val, 2) . __('flexi.b_usd');
            } elseif ($value >= 1000000) {
                $val = ($value / 1000000);
                $money = round($val, 2) . __('flexi.m_usd');
            } elseif ($value >= 1000) {
                $val = ($value / 1000);
                $money = round($val, 2) . __('flexi.k_usd');
            } elseif ($value >= 0) {
                $money = round($value, 2) . __('flexi._usd');
            } elseif ($value < 0) {
                // If number smaller than zero 
                if (($value * (-1)) >= 10000000) {
                    $val = (($value * (-1)) / 10000000);
                    $money = '-' . round($val, 2) . 'B';
                } elseif (($value * (-1)) >= 1000000) {
                    $val = (($value * (-1)) / 1000000);
                    $money = '-' . round($val, 2) . 'M';
                } elseif (($value * (-1)) >= 1000) {
                    $val = (($value * (-1)) / 1000);
                    $money = '-' . round($val, 2) . 'K';
                } else {
                    $money = round($value, 2);
                }
            }
        endif;
        return $money;
    }

    // *** Ordinal Number
    public static function ordinal_number($value, $option = true)
    {
        $_ordinal = '';
        $_ordinal_number = '';
        if (is_numeric($value)) {
            $last1Digit = $value % 10;
            $last2Digit = $value % 100;

            if (in_array($last2Digit, [11, 12, 13])) {
                $_ordinal = 'th';
            } else {
                switch ($last1Digit) {
                    case (1):
                        $_ordinal = 'st';
                        break;
                    case (2):
                        $_ordinal = 'nd';
                        break;
                    case (3):
                        $_ordinal = 'rd';
                        break;
                    default:
                        $_ordinal = 'th';
                }
            }
        }

        if ($option) {
            $_ordinal_number = $value . $_ordinal;
        } else {
            $_ordinal_number = $_ordinal . $value;
        }
        return $_ordinal_number;
    }

    // *** Easy phone number. Add or remove prefix code
    public static function easy_phone_number($value, $option = true): string
    {
        $phone = '';
        // *** Add
        if (!empty($value) && $option) {
            $strDigit = (string) preg_replace('/\s+/', '', $value);
            $firstCharacter = substr($strDigit, 0, 1);
            if ($firstCharacter == '0') {
                $phone = '+855' . ltrim($strDigit, '0');
            }elseif (self::isGlobalPhone($strDigit)) {
                $phone = self::isGlobalPhone($strDigit);
            }else {
                $phone = '+855' . $strDigit;
            }
        }

        // *** Remove
        if (!empty($value) && !$option) {
            $resault = preg_replace(
                '/\+(?:998|996|995|994|993|992|977|976|975|974|973|972|971|970|968|967|966|965|964|963|962|961|960|886|880|856|855|853|852|850|692|691|690|689|688|687|686|685|683|682|681|680|679|678|677|676|675|674|673|672|670|599|598|597|595|593|592|591|590|509|508|507|506|505|504|503|502|501|500|423|421|420|389|387|386|385|383|382|381|380|379|378|377|376|375|374|373|372|371|370|359|358|357|356|355|354|353|352|351|350|299|298|297|291|290|269|268|267|266|265|264|263|262|261|260|258|257|256|255|254|253|252|251|250|249|248|246|245|244|243|242|241|240|239|238|237|236|235|234|233|232|231|230|229|228|227|226|225|224|223|222|221|220|218|216|213|212|211|98|95|94|93|92|91|90|86|84|82|81|66|65|64|63|62|61|60|58|57|56|55|54|53|52|51|49|48|47|46|45|44\D?1624|44\D?1534|44\D?1481|44|43|41|40|39|36|34|33|32|31|30|27|20|7|1\D?939|1\D?876|1\D?869|1\D?868|1\D?849|1\D?829|1\D?809|1\D?787|1\D?784|1\D?767|1\D?758|1\D?721|1\D?684|1\D?671|1\D?670|1\D?664|1\D?649|1\D?473|1\D?441|1\D?345|1\D?340|1\D?284|1\D?268|1\D?264|1\D?246|1\D?242|1)\D?/',
                '',
                $value
            );
            $phone = '0' . $resault;
        }
        return $phone;
    }
    static function isGlobalPhone($phone)
    {
        if(!empty($phone)){
            $phone = (string) preg_replace('/\s+/', '', $phone);
            $codes = ["+376","+971","+93","+1268","+1264","+355","+374","+599","+244","+672","+54","+1684","+43","+61","+297","+994","+387","+1246","+880","+32","+226","+359","+973","+257","+229","+590","+1441","+673","+591","+55","+1242","+975","+267","+375","+501","+1","+61","+243","+236","+242","+41","+225","+682","+56","+237","+86","+57","+506","+53","+238","+61","+357","+420","+49","+253","+45","+1767","+1809","+213","+593","+372","+20","+291","+34","+251","+358","+679","+500","+691","+298","+33","+241","+44","+1473","+995","+233","+350","+299","+220","+224","+240","+30","+502","+1671","+245","+592","+852","+504","+385","+509","+36","+62","+353","+972","+44","+91","+964","+98","+354","+39","+1876","+962","+81","+254","+996","+855","+686","+269","+1869","+850","+82","+965","+1345","+7","+856","+961","+1758","+423","+94","+231","+266","+370","+352","+371","+218","+212","+377","+373","+382","+1599","+261","+692","+389","+223","+95","+976","+853","+1670","+222","+1664","+356","+230","+960","+265","+52","+60","+258","+264","+687","+227","+234","+505","+31","+47","+977","+674","+683","+64","+968","+507","+51","+689","+675","+63","+92","+48","+508","+870","+351","+680","+595","+974","+40","+381","+250","+966","+677","+248","+249","+46","+65","+290","+386","+421","+232","+378","+221","+252","+597","+239","+503","+963","+268","+1649","+235","+228","+66","+992","+690","+670","+993","+216","+676","+90","+1868","+688","+886","+255","+380","+256","+598","+998","+39","+1784","+58","+1284","+1340","+84","+678","+681","+685","+381","+967","+262","+27","+260","+263"];
            foreach($codes as $code){
                $length = strlen($code);
                if($code === substr($phone, 0, $length)){
                    return $phone;
                }elseif(ltrim($code, '+') === substr($phone, 0, ($length-1))){
                    return '+'.$phone;
                }
            }
        }
        return false;
    }
}
