<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormRentalField extends Model
{
    use HasFactory;
    protected $table = 'form_rental_fields';
    protected $guarded = ['id'];

    protected $fillable = [
        'form_rental_id',
        'field_label',
        'field_type',
        'is_condition',
        'is_required',
        'options',
    ];

    // ១. ប្រកាស Casts ឱ្យ options ទៅជា Array
    protected $casts = [
        'options' => 'array',
    ];

    // ២. បន្ថែម Attribute 'brands' ចូលទៅក្នុង JSON Output ដោយស្វ័យប្រវត្តិ
    protected $appends = ['brands'];

    /**
     * Accessor សម្រាប់ទាញយក RentalBrand Entities ចេញពី JSON Options [1, 2, 3]
     * វានឹងបង្កើត Key ឈ្មោះ 'brands' ឱ្យ JavaScript ប្រើបានដោយស្វ័យប្រវត្តិ
     */
    public function getBrandsAttribute()
    {
        $optionIds = $this->options;

        // បើជា JSON String នៅឡើយ ត្រូវ Decode វា
        if (is_string($optionIds)) {
            $optionIds = json_decode($optionIds, true);
        }

        if (!empty($optionIds) && is_array($optionIds)) {
            return RentalBrand::whereIn('id', $optionIds)->orderBy('id', 'desc')->get();
        }

        return [];
    }
}
