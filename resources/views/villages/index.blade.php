@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.village')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.village')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    {{-- @if ($permission->is_create == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_trainer"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif --}}
                    @if ($permission->is_import == "1")
                        <a href="#" class="btn add-btn me-2" data-toggle="modal" id="importVillage"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    @endif
                </div>
            </div>
        </div>
        @if ($permission->is_view == "1")
            {!! Toastr::message() !!}
            <div class="content">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="" class=" dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table mb-0 tbl-village">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30px;">#</th>
                                                    <th>@lang('lang.code')</th>
                                                    <th>@lang('lang.phum_name_km')</th>
                                                    <th>@lang('lang.phum_name_latin')</th>
                                                    <th>@lang('lang.phum_name_en')</th>
                                                    <th>@lang('lang.name_km')</th>
                                                    <th>@lang('lang.name_latin')</th>
                                                    <th>@lang('lang.name_en')</th>
                                                    <th>@lang('lang.full_name_km')</th>
                                                    <th>@lang('lang.full_name_latin')</th>
                                                    <th>@lang('lang.full_name_en')</th>
                                                    <th>@lang('lang.commune')</th>
                                                    <th>@lang('lang.districts')</th>
                                                    <th>@lang('lang.province')</th>
                                                    <th>@lang('lang.address_km')</th>
                                                    <th>@lang('lang.address_latin')</th>
                                                    <th>@lang('lang.address_en')</th>
                                                    <th class="text-end">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data populated dynamically via ServerSide AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('villages.import')
@endsection
@include('includs.script')

<script>
    $(function(){
        $(document).ready(function() {
            datashow();
        });
        $("#importVillage").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#importVillageModal').modal('show');
        });
    });
    function datashow() {
        let table = $('.tbl-village').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            pageLength: 10,
            order: [[0, 'desc']],
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            ajax: {
                url: "{{ url('address/village') }}",
                type: "POST", // ប្តូរទៅប្រើ POST
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // បន្ថែម CSRF Token
                },
                error: function(xhr, error, code) {
                    console.log(xhr.responseText);
                }
            },
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });

        let searchTimer;
        $('.dataTables_filter input')
            .off('keyup search input')
            .on('keyup', function() {
                clearTimeout(searchTimer);
                let searchVal = this.value;
                searchTimer = setTimeout(function() {
                    table.search(searchVal).draw();
                }, 500);
            });
    }
</script>