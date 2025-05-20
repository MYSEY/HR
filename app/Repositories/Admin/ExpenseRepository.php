<?php

namespace App\Repositories\Admin;

use App\Models\ExpenseRequest;
use App\Models\FnDetailLocation;
use App\Models\LeaveAllocation;
use App\Models\LeaveRequest;
use App\Repositories\BaseRepository;
use App\Traits\UploadFiles\UploadFIle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExpenseRepository extends BaseRepository
{
    use UploadFIle;
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return ExpenseRequest::class;
    }

    public function getDataByLocation($request){
        $datasDetails = FnDetailLocation::with(["expenseRequest", "location", "department"])
        ->leftJoin('expense_requests', 'fn_detail_locations.expense_request_id', '=', 'expense_requests.id')
            ->select(
                'fn_detail_locations.*', 
                'expense_requests.*',
            )
        ->where('expense_requests.status', "approved")
        ->when($request->tracking_id, function ($query, $tracking_id) {
            $query->where('expense_requests.tracking_id', $tracking_id);
        })
        ->when($request->date_request, function ($query, $date_request) {
            $query->whereDate('expense_requests.date_request', $date_request);
        })
        ->when($request->date_approve, function ($query, $date_approve) {
            $query->where('expense_requests.date_approve', $date_approve);
        })
        ->when($request->type, function ($query, $type) {
            if ($type == 3) {
                $query->where('expense_requests.type','=', 0);
            }else{
                $query->where('expense_requests.type','=', $type);
            }
        })
        ->when($request->expense_type, function ($query, $expense_type) {
            $query->where('expense_requests.expense_type', $expense_type);
        })
        ->when($request->location_id, function ($query, $location_id) {
            $query->where('fn_detail_locations.location_id', $location_id);
        })
        ->orderBy('expense_requests.id', 'DESC');

         $perPage = $request->get('per_page', 10);

        if ($perPage === 'all') {
            $datasDetails = $datasDetails->get();
            $datasDetails = new \Illuminate\Pagination\LengthAwarePaginator(
                $datasDetails,
                $datasDetails->count(),
                $datasDetails->count(),
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $datasDetails = $datasDetails->paginate($perPage)->withQueryString();
        }
        return $datasDetails;
    }
}