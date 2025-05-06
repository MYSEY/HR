<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ExpenseRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected $table = 'expense_requests';
    protected $guarded = ['id'];

    protected $fillable = [
        "tracking_id",
        "type",
        "expense_type",
        "kind_regard",
        "te_through",
        "subject",
        "reference",
        "reason_subject",
        "ge_cost_material_usd",
        "ge_cost_material_riel",
        "ge_cost_lso_usd",
        "ge_cost_lso_riel",
        "ge_total_cost_usd",
        "ge_total_cost_riel",
        "ge_tax_usd",
        "tax_riel",
        "ge_tax_fringe_benefit_usd",
        "tax_fringe_benefit_riel",
        "ge_vat_reverse_charge_usd",
        "vat_reverse_charge_riel",
        "ge_total_amount_usd",
        "ge_total_amount_riel",
        "payment_term",
        "te_payroll_tax_riel",
        "te_tax_services",
        "te_tax_interest",
        "te_tax_non_resident",
        "te_MTO_services",
        "te_tax_wages",
        "te_value_added",
        "te_tax_income",
        "te_total_tax",
        "special",
        "status",
        "position_review",
        "review_type",
        "request_by",
        "approve_by",
        "date_print",
        "date_request",
        "date_approve",
        "date_reject",
        "remark",
        "reason",
        "created_by",
        "updated_by",
        "deleted_at",
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    
    public function getReferencesAttribute()
    {
        if (empty($this->reference)) {
            return collect(); // Return an empty collection
        }
        $items = explode(',', $this->reference);
        return FnRegularExspense::whereIn("serialref", $items)->get();
    }
    public function locationDetails()
    {
        return $this->hasMany(FnDetailLocation::class, 'expense_request_id', 'id')->with("location");
       
    }
    public function departments()
    {
        return $this->hasMany(FnDetailLocation::class, 'expense_request_id', 'id')->with("department");
    }
    public function requestBy()
    {
        return $this->belongsTo(User::class, 'request_by')->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'position_id',
            'branch_id',
            'department_id',
            'gender',
            'date_of_commencement',
            'personal_phone_number',
        );
    }
    public function approveBy()
    {
        return $this->belongsTo(User::class, 'approve_by')->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'position_id',
            'branch_id',
            'department_id',
            'gender',
            'date_of_commencement',
            'personal_phone_number',
        )->with("position");
    }
    public function getPositionReviewsAttribute()
    {
        if (is_array($this->attributes['position_review'] ?? null)) {
            $ids = $this->attributes['position_review'];
        } else {
            $ids = json_decode($this->attributes['position_review'] ?? '[]', true);
        }
    
        return Position::whereIn('id', $ids)->get();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'position_id',
            'branch_id',
            'department_id',
            'gender',
            'date_of_commencement',
            'personal_phone_number',
        );
    }
    public function upldatedBy()
    {
        return $this->belongsTo(User::class ,'updated_by')->select(
            'id',
            'number_employee',
            'last_name_kh',
            'first_name_kh',
            'last_name_en',
            'first_name_en',
            'employee_name_kh',
            'employee_name_en',
            'email',
            'position_id',
            'branch_id',
            'department_id',
            'gender',
            'date_of_commencement',
            'personal_phone_number',
        );
    }
}
