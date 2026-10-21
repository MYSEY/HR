<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotorRentel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'motor_rentels';
    protected $appends = ['motor_brand_name','form_rental_with_price'];
    protected $guarded = ['id'];

    protected $fillable = [
        'employee_id',
        'form_rental',
        'current_position',
        'payment_status',
        'resigned_date',
        'total_work_day',
        'status',
        'contract',
        'created_by',
        'updated_by',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function getFormRentalWithPriceAttribute()
    {
        $forms = is_string($this->form_rental) 
            ? json_decode($this->form_rental, true) 
            : $this->form_rental;

        if (!is_array($forms) || empty($forms)) {
            return [];
        }

        $formRentalIds = array_column($forms, 'form_rental_id');

        $formRentalDetails = FormRental::with('rentalRates')
            ->where("status", 0)
            ->whereIn('id', array_filter($formRentalIds))
            ->get()
            ->keyBy('id');

        if ($formRentalDetails->isEmpty()) {
            return $forms;
        }

        $user = User::where("id", $this->employee_id)
            ->select(['id', 'department_id', 'position_id', 'branch_id'])
            ->first();
        $staffPromoted = StaffPromoted::where("employee_id", $this->employee_id)->latest("date")->first();

        $currentYear = (int) date('Y');

        foreach ($forms as &$formItem) {
            $formId = $formItem['form_rental_id'] ?? null;
            $price = 0;
            $new_price = 0;
            $currency = "";
            $startDate = null; 
            $promoted_date = "";
            $promoted_from_position = "";
            $promoted_to_position = "";
            $promoted_from_position_id = "";
            $promoted_to_position_id = "";

            // 1. Loop ឆែក Dynamic Fields ស្វែងរក "Lease Start Date" ឬ "Start Date"
            if (isset($formItem['fields']) && is_array($formItem['fields'])) {
                foreach ($formItem['fields'] as $field) {
                    $label = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $field['field_label'] ?? ''));
                    if ($label === 'leasestartdate' || $label === 'startdate') {
                        $startDate = $field['value'] ?? null;
                        break;
                    }
                }
            }

            if ($formId && isset($formRentalDetails[$formId])) {
                $formModel = $formRentalDetails[$formId];
                $type      = strtolower($formModel->type ?? '');
                $rates     = $formModel->rentalRates ?? collect();
                $formItem['type'] = $type;

                if ($type === 'motorcycle') {
                    $manufactureYear = 0;

                    if (isset($formItem['fields']) && is_array($formItem['fields'])) {
                        foreach ($formItem['fields'] as $field) {
                            $label = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $field['field_label'] ?? ''));
                            if ($label === 'yearofmanufature' || $label === 'yearofmanufacture') {
                                $manufactureYear = (int) ($field['value'] ?? 0);
                                break;
                            }
                        }
                    }

                    $motorAge = ($manufactureYear > 0) ? ($currentYear - $manufactureYear) : 0;
                    if ($motorAge < 0) $motorAge = 0;
                    $formItem['motor_age'] = $motorAge;

                    if ($user && $rates->isNotEmpty()) {

                        // 1. Helper Function សម្រាប់ Search ស្វែងរក Rate តាម Position ID និង អាយុម៉ូតូ
                        $getRateByPosition = function ($positionId) use ($rates, $motorAge) {
                            if (!$positionId) return null;

                            return $rates->first(function ($rate) use ($positionId, $motorAge) {
                                $matchPosition = ($rate->position_id == $positionId);

                                $from = isset($rate->from) ? (int) $rate->from : 0;
                                $to   = isset($rate->to)   ? (int) $rate->to   : 999;

                                $matchAge = ($motorAge > $from && $motorAge <= $to);

                                return $matchPosition && $matchAge;
                            });
                        };

                        // 2. កំណត់ Position ID សម្រាប់ Old និង New តាម Real Data ក្នុង motor_rentels
                        if ($staffPromoted) {
                            $oldPositionId = $staffPromoted->position_from_id; // Position ID មុន Promoted
                            if($this->current_position && $this->current_position == $staffPromoted->position_to_id){
                                $newPositionId = null;
                                $oldPositionId = $staffPromoted->position_to_id; 
                            }else{
                                $newPositionId = $staffPromoted->position_to_id;
                                $promoted_date = $staffPromoted->date;
                                $promoted_from_position = $staffPromoted->posit_id;
                                $promoted_to_position = $staffPromoted->position_promoted_to;
                                $promoted_from_position_id = $staffPromoted->position_from_id;
                                $promoted_to_position_id = $staffPromoted->position_to_id;
                            }
                        } else {
                            // ករណីអត់មាន Promotion:
                            $oldPositionId = $user->position_id;
                            $newPositionId = null;
                        }

                        // 3. ស្វែងរក Rate សម្រាប់ តួនាទីចាស់ (Old Price)
                        $oldMatchedRate = $getRateByPosition($oldPositionId);
                        if ($oldMatchedRate) {
                            $price = $oldMatchedRate->amount;
                            $currency = $oldMatchedRate->currency;
                        }

                        // 4. ស្វែងរក Rate សម្រាប់ តួនាទីថ្មី (New Promoted Price)
                        if ($newPositionId) {
                            $newMatchedRate = $getRateByPosition($newPositionId);
                            if ($newMatchedRate) {
                                $new_price = $newMatchedRate->amount;
                            }
                        }
                    }
                } elseif (in_array($type, ['tablet', 'car'])) {
                    if ($rates->isNotEmpty()) {
                        $price = $rates->first()->amount;
                        $currency = $rates->first()->currency;
                    }
                }
            }

            // 2. បញ្ចូល start_date, currency, និង price ទៅក្នុង FormItem
            $formItem['start_date']                 = $startDate;
            $formItem['currency']                   = $currency;
            $formItem['price']                      = $price;
            $formItem['new_price']                  = $new_price;
            $formItem['promoted_date']              = $promoted_date;
            $formItem['promoted_from_position']     = $promoted_from_position;
            $formItem['promoted_to_position']       = $promoted_to_position;
            $formItem['promoted_from_position_id']  = $promoted_from_position_id;
            $formItem['promoted_to_position_id']    = $promoted_to_position_id;
        }

        return $forms;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'gender',
            'date_of_birth',
            'id_card_number',
            'current_province',
            'current_district',
            'current_commune',
            'current_village',
            'current_house_no',
            'current_street_no',
        ]);
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by')->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'gender',
            'date_of_birth',
            'id_card_number',
            'current_province',
            'current_district',
            'current_commune',
            'current_village',
            'current_house_no',
            'current_street_no',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class ,'employee_id')
        ->select([
            'id', 
            'employee_name_en',
            'employee_name_kh',
            'number_employee',
            'department_id',
            'position_id',
            'branch_id',
            'gender',
            'date_of_birth',
            'id_card_number',
            'current_province',
            'current_district',
            'current_commune',
            'current_village',
            'current_house_no',
            'current_street_no',
        ])
        ->with('department')
        ->with('position')
        ->with('gender')
        ->with('branch')
        ->with('currentprovince')
        ->with('currentdistrict')
        ->with('currentcommune')
        ->with('currentvillage');
    }

    // Relationship ទៅកាន់ Table RentalBrand
    public function motorBrand()
    {
        return $this->belongsTo(RentalBrand::class, 'motor_brand_id');
    }

    public function getMotorEmployeeAttribute(){
        $user = User::where("id", $this->employee_id)->first();
        return $user;
    }
    
    /**
     * Accessor សម្រាប់បង្ហាញឈ្មោះ Motor Brand តាមលក្ខខណ្ឌ
     * របៀបហៅប្រើក្នុង Blade: $item->motor_brand_name
     */
    public function getMotorBrandNameAttribute()
    {
        // ឆែកមើលថាមាន Relationship motorBrand ដែរឬទេ
        if ($this->motorBrand) {
            // ប្រសិនបើ brand_name ស្មើ "Other" ឱ្យយកតម្លៃពី column motorcycle_brand
            if ($this->motorBrand->brand_name === 'Other') {
                return $this->motorcycle_brand;
            }

            // ប្រសិនបើខុសពី "Other" ឱ្យយក brand_name ពី Table motor_brands
            return $this->motorBrand->brand_name;
        }

        // ករណីគ្មាន motor_brand_id ក្នុង DB ឱ្យយក column motorcycle_brand (បើមាន)
        return $this->motorcycle_brand;
    }

}
