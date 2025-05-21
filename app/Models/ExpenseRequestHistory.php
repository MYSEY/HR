<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRequestHistory extends Model
{
    use HasFactory;
    protected $table = 'expense_request_histories';
    protected $guarded = ['id'];

    protected $fillable = [
        "expense_id",
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
        "location_review",
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
}
