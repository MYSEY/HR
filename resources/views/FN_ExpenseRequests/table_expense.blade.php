<div class="tab-pane active show clearTabs" id="tbl_request" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-expense-request" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr>
                            <th class="stuck-scroll-3">#</th>
                            <th class="stuck-scroll-3">@lang('lang.tracking_id')</th>
                            <th class="stuck-scroll-3">@lang('lang.status')</th>
                            <th >@lang('lang.type')</th>
                            <th>@lang('lang.type_of_expense')</th>
                            <th>@lang('lang.amount') @lang('lang.usd')</th>
                            <th>@lang('lang.amount') @lang('lang.kh')</th>
                            <th>@lang('lang.reference')</th>
                            <th>@lang('lang.description')</th>
                            <th>@lang('lang.location')</th>
                            <th>@lang('lang.reason')</th>
                            <th style="text-align: center;">@lang('lang.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($datas)>0)
                            @foreach ($datas as $key=>$item)
                                @php
                                    $locations = "";
                                    if ($item->type == "2" ) {
                                        if (count($item->departments)>0) {
                                            $num = 1;
                                            foreach ($item->departments as $in => $location) {
                                                if ($location->Location) {
                                                    $locations .= $num . ". " . $location->department->name_english . "\n";
                                                    $num++;
                                                    // $locations .= $location->department->name_english.", ";
                                                }
                                            }
                                        }
                                    }else{
                                        if (count($item->locationDetails)>0) {
                                            $num = 1;
                                            foreach ($item->locationDetails as $ind => $location) {
                                                // dd($location->Location);
                                                if ($location->Location) {
                                                    $locations .=  $num . ". " .$location->Location->branch_name_en."\n";
                                                    $num++;
                                                }
                                                
                                            }
                                        }
                                    }
                                    
                                @endphp
                                <tr class="odd">
                                    <td class="stuck-scroll-3">{{$key+1}}</td>
                                    <td class="stuck-scroll-3"><a href="#">{{$item->tracking_id}}</a></td>
                                    <td class="stuck-scroll-3"> 
                                        @if ($item->status == "" || $item->status == "pending")
                                            <span class="badge bg-inverse-info" style="font-size: 13px;">@lang('lang.pending') @lang('lang.review')  {{$item->review_type}}</span>
                                        @elseif($item->status == "pending_approve")
                                            <span class="badge bg-inverse-warning" style="font-size: 13px;">@lang('lang.pending') @lang('lang.approved')</span>
                                        @elseif ($item->status == "rejected")
                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected by {{$item->review_type ? "review ".$item->reject_review_type : "Approved"}}</span>
                                        @elseif ($item->status == "cancel")
                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">@lang('lang.cancel')</span>
                                        @elseif($item->status == "approved")
                                            <span class="badge bg-inverse-success" style="font-size: 13px;">@lang('lang.approved')</span>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        {{-- {{$item->type == "1" ? "Special Expense": "General Expense"}} --}}
                                        @if ($item->type == "1")
                                            <span >Special Expense</span>
                                        @elseif ($item->type == "2")
                                            <span >Tax Expense</span>
                                        @else
                                            <span >General Expense</span>
                                        @endif
                                    </td>
                                    <td >
                                        {{
                                            $item->type == "0" ?  $item->expense_type == "1" ? "Regular Expense": "Irregular Expense" : ""
                                        }}

                                    </td>
                                    <td >{{number_format($item->ge_total_amount_usd, 2)}}</td>
                                    <td>{{$item->type == "2" ? number_format($item->te_total_tax ,2) : number_format($item->ge_total_amount_riel, 2)}}</td>
                                    @if(count($item->References) <= 1)
                                        @php
                                            $cleanReference = str_replace('null,', '', $item->reference);
                                            $cleanReference = ltrim($cleanReference, ','); // remove leading comma if exists
                                            $cleanReference = trim($cleanReference);      // clean up spaces
                                        @endphp
                                        <td>
                                            @if(isset($item->References[0]->file_upload))
                                                <small class="block text-ellipsis">
                                                    <a href="{{ url('uploads/FnRegularExspenses/' . $item->References[0]->file_upload) }}" target="_blank">
                                                        {{ $cleanReference }}
                                                    </a>
                                                </small>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            @foreach ($item->References as $rf)
                                                @php
                                                    $cleanReference = str_replace('null,', '', $rf->serialref);
                                                    $cleanReference = ltrim($cleanReference, ',');
                                                    $cleanReference = trim($cleanReference);
                                                @endphp
                                                <small class="block text-ellipsis">
                                                    <a href="{{ url('uploads/FnRegularExspenses/' . $rf->file_upload) }}" target="_blank">
                                                        {{ $cleanReference }}
                                                    </a>
                                                </small>
                                            @endforeach
                                        </td>
                                    @endif
                                    <td data-toggle="tooltip" data-html="true" title="{!! $item->subject !!}">
                                        {{ Str::limit($item->subject, 30, '...') }}
                                    </td>

                                    <td data-toggle="tooltip" data-html="true" title="{!! $locations !!}" >
                                        {{ Str::limit($locations, 30, '...') }}
                                    </td>
                                    <td data-toggle="tooltip" data-html="true" title="{!! $item->reason !!}">
                                        {{ Str::limit($item->reason, 25, '...') }}
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if (($item->review_type == "1" && $item->status == "pending") || ($item->expense_type == 1 && $item->status == "pending_approve") || $item->status == "rejected")
                                                    @if ($item->type == "2")
                                                        <a class="dropdown-item update" href="{{url("fn/tax-expense/edit",$item->id)}}" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                    @else
                                                        <a class="dropdown-item update" href="{{url("fn/expense-request/edit",$item->id)}}" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                    @endif
                                                    <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_ER"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                @endif
                                                {{-- @if ($item->status == "approved" || ($item->expense_type == 1 && $item->status == "pending_approve")) --}}
                                                    <a class="dropdown-item {{ $item->type == '2' ? 'btn-TEXP-print' : 'btn-GEXP-print'}}" href="#" data-datas="{{$item}}"><i class="fa fa-print fa-lg m-r-5"></i> @lang('lang.print')</a>
                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane show clearTabs" id="tbl_assign" role="tabpanel">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr>
                            <th class="stuck-scroll-3">#</th>
                            <th class="stuck-scroll-3">@lang('lang.tracking_id')</th>
                            <th>@lang('lang.status')</th>
                            {{-- <th class="stuck-scroll-3">@lang('lang.type')</th> --}}
                            {{-- <th>@lang('lang.type_of_expense')</th> --}}
                            <th>@lang('lang.amount') @lang('lang.usd')</th>
                            <th>@lang('lang.amount') @lang('lang.kh')</th>
                            {{-- <th>@lang('lang.type_of_payment')</th> --}}
                            {{-- <th>@lang('lang.serialref')</th> --}}
                            <th>@lang('lang.description')</th>
                            <th>@lang('lang.request_date')</th>
                            <th>@lang('lang.location')</th>
                            {{-- <th>@lang('lang.request_by')</th> --}}
                            <th>@lang('lang.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($dataAsign)>0)
                            @foreach ($dataAsign as $key=>$item)
                                @php
                                    $reference = '';
                                    $asignLocations = "";
                                    if ($item->type == "2" ) {
                                        if (count($item->departments)>0) {
                                            $asignNum = 1;
                                            foreach ($item->departments as $in => $location) {
                                                if ($location->Location) {
                                                    $asignLocations .= $asignNum . ". " . $location->department->name_english . "\n";
                                                    $asignNum++;
                                                }
                                            }
                                        }
                                    }else{
                                        if (count($item->locationDetails)>0) {
                                            $asignNum = 1;
                                            foreach ($item->locationDetails as $ind => $location) {
                                                if ($location->Location) {
                                                    $asignLocations .=  $asignNum . ". " .$location->Location->branch_name_en."\n";
                                                    $asignNum++;
                                                }
                                                
                                            }
                                        }
                                    }
                                    
                                @endphp
                                <tr class="odd">
                                    <td class="stuck-scroll-3">{{$key+1}}</td>
                                    <td class="stuck-scroll-3"><a href="#">{{$item->tracking_id}}</a></td>
                                    <td class="stuck-scroll-3"> 
                                        @if ($item->status == "" || $item->status == "pending")
                                            <span class="badge bg-inverse-info" style="font-size: 13px;">@lang('lang.pending') @lang('lang.review') {{$item->review_type}}</span>
                                        @elseif($item->status == "pending_approve")
                                            <span class="badge bg-inverse-warning" style="font-size: 13px;">@lang('lang.pending') @lang('lang.approved')</span>
                                        @elseif ($item->status == "rejected")
                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">Rejected by {{$item->review_type ? "review ".$item->reject_review_type : "Approved"}}</span>
                                        @elseif ($item->status == "cancel")
                                            <span class="badge bg-inverse-danger" style="font-size: 13px;">@lang('lang.cancel')</span>
                                        @elseif($item->status == "approved")
                                            <span class="badge bg-inverse-success" style="font-size: 13px;">Approved</span>
                                        @endif
                                    </td>
                                    <td>$ {{ number_format($item->ge_total_amount_usd, 2) }}</td>
                                    <td>
                                        {{ $item->type == "2" ? '$ ' . number_format($item->te_total_tax, 2) : '៛ ' . number_format($item->ge_total_amount_riel, 2) }}
                                    </td>

                                    @if(count($item->References) <= 1 && isset($item->References[0]->file_upload))
                                        @php
                                            $cleanReference = str_replace('null,', '', $item->reference);
                                            $cleanReference = ltrim($cleanReference, ',');
                                            $cleanReference = trim($cleanReference);
                                            $html = '<small class="block text-ellipsis">
                                                        <a href="' . url('uploads/FnRegularExspenses/' . $item->References[0]->file_upload) . '" target="_blank">'
                                                            . $cleanReference .
                                                        '</a>
                                                    </small>';
                                            $reference = htmlspecialchars($html, ENT_QUOTES);
                                        @endphp
                                    @else
                                        @php
                                            $html = '';
                                            foreach ($item->References as $rf) {
                                                $cleanReference = str_replace('null,', '', $rf->serialref);
                                                $cleanReference = ltrim($cleanReference, ',');
                                                $cleanReference = trim($cleanReference);
                                                $html .= '<small class="block text-ellipsis">
                                                            <a href="' . url('uploads/FnRegularExspenses/' . $rf->file_upload) . '" target="_blank">'
                                                                . $cleanReference .
                                                            '</a>
                                                        </small>';
                                            }
                                            $reference = htmlspecialchars($html, ENT_QUOTES);
                                        @endphp
                                    @endif
                                    <td data-toggle="tooltip" data-html="true" title="{!! $item->subject !!}">
                                        {{ Str::limit($item->subject, 30, '...') }}
                                    </td>
                                    <td>{{$item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y H:i') : ''}}</td>
                                    <td data-toggle="tooltip" data-html="true" title="{!! $asignLocations !!}" >
                                        {{ Str::limit($asignLocations, 30, '...') }}
                                    </td>
                                    <td style="text-align: center;">

                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item btn-review" href="#" data-datas="{{$item}}" data-reference="{!! $reference !!}"><i class="fa fa-eye m-r-5"></i> @lang('lang.review')</a>
                                                <a class="dropdown-item {{ $item->type == '2' ? 'btn-TEXP-print' : 'btn-GEXP-print'}}" href="#" data-datas="{{$item}}"><i class="fa fa-print fa-lg m-r-5"></i> @lang('lang.print')</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>