<?php

namespace App\Traits\Convertors;

trait ConvertNumbersToWordsTrait
{
	/**
	 * How to use
	 * use \App\Traits\Convertors\ConvertNumbersToWordsTrait;
	 */

	/**
	 *  How to use convertNumbers2Words
	 *  ‘Read In English: convertNumbers2Words($value, 0);
	 *  ‘Not Read In Khmer: convertNumbers2Words($value, 1);
	 */
	public function convertNumbers2Words($number, $kh = 0, $lang = null)
	{
		$number = round($number, 2);
		if ($kh) {
			$hyphen      = '';
			$conjunction = '  ';
			$separator   = ' ';
			$negative    = 'ដក ';
			$decimal     = ' ក្បៀស ';
			$dictionary  = array(
				0 => ' សូន្យ ',
				1 => ' មួយ ',
				2 => ' ពីរ ',
				3 => ' បី ',
				4 => ' បួន ',
				5 => ' ប្រាំ ',
				6 => ' ប្រាំមួយ ',
				7 => ' ប្រាំពីរ ',
				8 => ' ប្រាំបី ',
				9 => ' ប្រាំបួន ',
				//	'00' => ' សូន្យសូន្យ ',
				'01' => ' សូន្យមួយ ',
				'02' => ' សូន្យពីរ ',
				'03' => ' សូន្យបី ',
				'04' => ' សូន្យបួន ',
				'05' => ' សូន្យប្រាំ ',
				'06' => ' សូន្យប្រាំមួយ ',
				'07' => ' សូន្យប្រាំពីរ ',
				'08' => ' សូន្យប្រាំបី ',
				'09' => ' សូន្យប្រាំបួន ',
				'000' => ' សូន្យសូន្យសូន្យ ',
				'001' => ' សូន្យសូន្យមួយ ',
				'002' => ' សូន្យសូន្យពីរ ',
				'003' => ' សូន្យសូន្យបី ',
				'004' => ' សូន្យសូន្យបួន ',
				'005' => ' សូន្យសូន្យប្រាំ ',
				'006' => ' សូន្យសូន្យប្រាំមួយ ',
				'007' => ' សូន្យសូន្យប្រាំពីរ ',
				'008' => ' សូន្យសូន្យប្រាំបី ',
				'009' => ' សូន្យសូន្យប្រាំបួន ',
				10 => ' ដប់ ',
				11 => ' ដប់មួយ ',
				12 => ' ដប់ពីរ ',
				13 => ' ដប់បី ',
				14 => ' ដប់បួន ',
				15 => ' ដប់ប្រាំ ',
				16 => ' ដប់ប្រាំមួយ ',
				17 => ' ដប់ប្រាំពីរ ',
				18 => ' ដប់ប្រាំបី ',
				19 => ' ដប់ប្រាំបួន',
				20 => ' ម្ភៃ ',
				30 => ' សាមសិប ',
				40 => ' សែសិប ',
				50 => ' ហាសិប ',
				60 => ' ហុកសិប ',
				70 => ' ចិតសិប ',
				80 => ' ប៉ែតសិប ',
				90 => ' កៅសិប ',
				100 => ' រយ ',
				1000 => ' ពាន់ ',
				10000 => ' មុឺន ',
				100000 => ' សែន ',
				1000000 => ' លាន ',
				1000000000 => ' ពាន់លានដុល្លារ ',
				1000000000000 => ' ពាន់ពាន់លាន ',
				1000000000000000 => ' quadrillion ',
				1000000000000000000 => ' quintillion '

			);
		} else {
			$hyphen      = '-';
			$conjunction = ' and ';
			$separator   = ', ';
			$negative    = 'negative ';
			$decimal     = ' point ';
			$dictionary  = array(
				0                   => 'zero',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20                  => 'twenty',
				30                  => 'thirty',
				40                  => 'fourty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety',
				100                 => 'hundred',
				1000                => 'thousand',
				1000000             => 'million',
				1000000000          => 'billion',
				1000000000000       => 'trillion',
				1000000000000000    => 'quadrillion',
				1000000000000000000 => 'quintillion'
			);
		}

		if (!is_numeric($number)) {
			return false;
		}

		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convertNumbers2Words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}

		if ($number < 0) {
			return $negative . $this->convertNumbers2Words(abs($number, $kh));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
		if ($fraction == '00') {
			$fraction = 0;
			$decimal = '';
		}
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . $this->convertNumbers2Words($remainder, $kh);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->convertNumbers2Words($numBaseUnits, $kh) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $this->convertNumbers2Words($remainder, $kh);
				}
				break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= $this->convertNumbers2Words($fraction, $kh);
		}

		if (!empty($lang) && strtolower($lang) == 'en') :
			return str_replace(' ', ' ', $string);
		else :
			return str_replace(' ', '', $string);
		endif;
	}
}
