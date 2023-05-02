<?php

namespace App\Exports;

use App\Models\MotorRentel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportMotorRentel implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MotorRentel::select("id","employee_id","gasoline_price_per_liter")->orderBy('id', 'desc')->get();
    }

    public function headings():array{
        return[
            'ID',
            'Employee ID',
            'Gasoline Price',
        ];
    
    }
}
