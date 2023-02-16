<?php

namespace App\Traits;

use App\Address;
use Illuminate\Support\Str;

trait AddressTrait
{
    /**
     * ADDRESS 
     * @param string $parameter (city, district, commune, village, full)
     * @param string $lang (kh, en)
     * @param numeric $code (address code)
     * @return string
     */
    public static function getAddress($param, $lang, $code)
    {
        $parameters = ['city', 'district', 'commune', 'village', 'full'];
        $address = self::queryAddress($code);

        if (!empty($address)) :

            if (!empty($lang) && in_array($lang, ['kh', 'en'])) :
                $langPath = '_path_' . $lang;
                $fullPath = $address->{$langPath};
            endif;

            if (!empty($param) && in_array($param, $parameters)) :
                switch ($param) {
                    case 'city':
                        return self::getAddressByIndex($fullPath ?? '', 0);
                        break;

                    case 'district':
                        return self::getAddressByIndex($fullPath ?? '', 1);
                        break;

                    case 'commune':
                        return self::getAddressByIndex($fullPath ?? '', 2);
                        break;

                    case 'village':
                        return self::getAddressByIndex($fullPath ?? '', 3);
                        break;

                    case 'full':
                        return self::getFullAddress($code, $fullPath ?? '', $lang);
                        break;
                }
            endif;

        endif;
        return null;
    }
    /////////////////////////////
    // GET ADDRESS BY INDEX 
    /////////////////////////////
    public static function getAddressByIndex($fullPath, $index)
    {
        $paths = explode('/', $fullPath);
        return !empty($paths[$index]) ? self::removeSpaceAddress($paths[$index]) : '';
    }
    public static function removeSpaceAddress($address)
    {
        if ($address[0] == " "){
            $address = substr($address, 1);
        }
        if (substr($address, -1) == " ")
        {
            $address = substr($address, 0, -1);
        }

        return $address;
    }
    /////////////////////////////
    // GET FULL ADDRESS 
    /////////////////////////////
    public static function getFullAddress($code, $fullPath, $lang = 'kh')
    {
        $fullAddress = '';
        if (!empty($fullPath) && $code) :
            $paths = explode('/', $fullPath);
            $isComma = $lang == 'en' ? ',' : ' ';
            if ($lang == 'en') :
                $fullAddress .= !empty($paths[3]) ? $paths[3] . ' ' . self::getTypeOfAddress($code, 8, $lang) . $isComma : '';
                $fullAddress .= !empty($paths[2]) ? $paths[2] . ' ' . self::getTypeOfAddress($code, 6, $lang) . $isComma : '';
                $fullAddress .= !empty($paths[1]) ? $paths[1] . ' ' . self::getTypeOfAddress($code, 4, $lang) . $isComma : '';
                $fullAddress .= !empty($paths[0]) ? $paths[0] : '';
            else :
                $fullAddress .= !empty($paths[3]) ? self::getTypeOfAddress($code, 8, $lang) . $paths[3] . $isComma : '';
                $fullAddress .= !empty($paths[2]) ? self::getTypeOfAddress($code, 6, $lang) . $paths[2] . $isComma : '';
                $fullAddress .= !empty($paths[1]) ? self::getTypeOfAddress($code, 4, $lang) . $paths[1] . $isComma : '';
                $fullAddress .= !empty($paths[0]) ? $paths[0] : '';
            endif;
        endif;
        return $fullAddress;
    }
    /////////////////////////////
    // GET TYPE OF ADDRESS 
    /////////////////////////////
    public static function getTypeOfAddress($code, $length, $lang = 'kh')
    {
        if (!empty($code) && !empty($length)) :
            $code =  Str::limit($code, $length, '');
            if (strlen($code) == $length) :
                $query = self::queryAddress($code);
                if (!empty($query)) :
                    $type = '_type_' . $lang;
                    return $query->{$type};
                endif;
            endif;
        endif;
        return null;
    }
    /////////////////////////////
    // QUERY ADDRESS 
    /////////////////////////////
    public static function queryAddress($code)
    {
        return Address::select('_code', '_path_en', '_path_kh', '_type_en', '_type_kh')->where('_code', $code)->first();
    }
    /////////////////////////////
    // GET ADDRESS BY ADDRESS STRING CODE
    /////////////////////////////
    public static function getAddressKhOrEn($code, $lang)
    {
        $cityCode = substr($code, 0, 2);
        $lang = !empty($lang) ? $lang : 'en';
        if (strlen($code) >= 4) :  $districtCode =  substr($code, 0, 4);
        endif;
        if (strlen($code) >= 6) : $communeCode =  substr($code, 0, 6);
        endif;
        if (strlen($code) >= 8) : $villageCode =  substr($code, 0, 8);
        endif;

        return [
            'city'      => [
                'code' => $cityCode ?? '',
                'name' => self::getAddress('city', $lang, $code)
            ],
            'district'  => [
                'code' => $districtCode ?? '',
                'name' => self::getAddress('district', $lang, $code)
            ],
            'commune'   => [
                'code' => $communeCode ?? '',
                'name' => self::getAddress('commune', $lang, $code)
            ],
            'village'   => [
                'code' => $villageCode ?? '',
                'name' => self::getAddress('village', $lang, $code)
            ]
        ];
    }
    public static function getAddressNull()
    {
        return [
            'city'      => [
                'code' => '',
                'name' => NULL
            ],
            'district'  => [
                'code' => '',
                'name' => NULL
            ],
            'commune'   => [
                'code' => '',
                'name' => NULL
            ],
            'village'   => [
                'code' => '',
                'name' => NULL
            ]
        ];
    }
}
