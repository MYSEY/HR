@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.form_rental')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.form_rental')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formRentalModal">
                            <i class="fa fa-plus"></i> @lang('lang.new') @lang('lang.form_rental')
                        </button>
                        {{-- <a href="{{url('form-rental/form')}}" class="btn add-btn"><i class="fa fa-plus"></i> @lang('lang.add_new')</a> --}}
                    @endif
                </div>
            </div>
        </div>
        @if ($permission->is_view == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-form-rental"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th >@lang('lang._no')</th>
                                                <th >@lang('lang.form_name')</th>
                                                <th >@lang('lang.condition')</th>
                                                <th >@lang('lang.type')</th>
                                                <th> @lang('lang.createdby')</th>
                                                <th> @lang('lang.status')</th>
                                                <th >@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Delete Modal -->
        <div class="modal custom-modal fade" id="delete_rental" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ url('form-rental/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="delete_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Modal -->
        @include('form_rentals.modal_form')
    </div>
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
<script>
    $(function(){
        datashowTables();
        // $(document).on('click', '.btn-view', function() {
        //     let id = $(this).data("id");
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ url('form-rental/view') }}",
        //         data: { id: id },
        //         dataType: "JSON",
        //         success: function(response) {
        //             if (response.status === 200) {
        //                 let data = response.data;
                        
        //                 // Set Modal Header Title
        //                 $("#form-name").text(data.title);

        //                 // Clear previous fields HTML
        //                 let fieldContainer = $("#field-teble");
        //                 fieldContainer.empty();

        //                 // Check if fields exist and loop through them
        //                 if (data.fields && data.fields.length > 0) {
        //                     $.each(data.fields, function(index, field) {
        //                         let requiredMark = field.is_required === 'yes' ? '<span class="text-danger">*</span>' : '';
        //                         let inputType = field.field_type || 'text';
                                
        //                         let fieldHtml = `
        //                             <div class="col-md-6 mb-3">
        //                                 <label class="form-label font-weight-bold">
        //                                     ${field.field_label} ${requiredMark}
        //                                 </label>
        //                                 <input type="${inputType}" 
        //                                     class="form-control" 
        //                                     placeholder="${field.field_label}" 
        //                                     readonly>
        //                             </div>
        //                         `;

        //                         fieldContainer.append(fieldHtml);
        //                     });
        //                 } else {
        //                     fieldContainer.html('<div class="col-12 text-center text-muted">No fields available for this form.</div>');
        //                 }

        //                 $("#view_form_rentel").modal("show");
        //             }
        //         },
        //         error: function(xhr) {
        //             new Noty({
        //                 text: "Failed to load form details.",
        //                 type: "error",
        //                 timeout: 3000
        //             }).show();
        //         }
        //     });
        // });
        $(document).on('click','.btn-delete', function() {
            let id = $(this).data("id");
            $('.delete_id').val(id);
            $("#delete_rental").modal("show");
        });
        $('body').on('click', '#btn-status a', function() {
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-name');
            let old_status = $(this).attr('data-status-old');
            let text_status = "";
            let text_old_status = "";
            if (old_status == "0") {
                text_old_status = "@lang('lang.active')"
            }else if(old_status == "1"){
                text_old_status = "@lang('lang.inactive')"
            }
            if (status == "0") {
                text_status = "@lang('lang.active')"
            }else if(status == "1"){
                text_status = "@lang('lang.inactive')"
            }

            $.confirm({
                title: '@lang("lang.change_status")!',
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                        '<label>@lang("lang.are_you_sure_want_change_status") '+'<label style="color:red">'+text_old_status+'</label>'+' @lang("lang.to_") '+'<label style="color:red">'+text_status+'</label>'+'?</label>'+
                        '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">',
                buttons: {
                    confirm: {
                        text: '@lang("lang.submit")',
                        btnClass: 'add-btn-status',
                        action: function() {
                            var id = this.$content.find('.id').val();
                            var status = this.$content.find('.status').val();
                            axios.post('{{ URL('form-rental/status') }}', {
                                    'id': id,
                                    'status': status,
                                }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.the_process_has_been_successfully').",
                                    type: "success",
                                    icon: true
                                }).show();
                                $('.card-footer').remove();
                                window.location.replace("{{ URL('form-rental') }}");
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                    type: "error",
                                    icon: true
                                }).show();
                            });
                        }
                    },
                    cancel: {
                        text: '@lang("lang.cancel")',
                        btnClass: 'btn-secondary btn-sm',
                    },
                }
            });
        });
        $(document).on('click', '.btn-edit', function () {
            $.ajax({
                type: "GET",
                url: "{{ url('form-rental/view') }}",
                data: { id: $(this).data("id") },
                dataType: "JSON",
                success: function (response) {
                    if (response.status === 200) openFormRentalModal(mapEdit(response.data));
                },
                error: function () {
                    new Noty({ text: "Failed to load form details.", type: "error", timeout: 3000 }).show();
                }
            });
        });
    });

    function datashowTables() {
        $('#loading-overlay').show();

        var tableId = '#DataTables_Table_0';
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().clear().destroy();
            $(tableId + ' tbody').empty(); 
        }
        $(tableId).DataTable({
            retrieve: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            order: [[0, 'desc']],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '{{ url("form-rental") }}', // កែប្រែដកអក្សរ 't' ចេញត្រង់នេះ
                type: 'GET'
            },
            columns: [
                { 
                    data: null, 
                    name: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { 
                    data: "title", 
                    name: 'title',
                    defaultContent: ''
                },
                { 
                    data: 'rental_rate.name', 
                    name: 'rental_rate.name',
                    defaultContent: 'N/A'
                },
                { 
                    data: 'type', 
                    name: 'type',
                    defaultContent: 'N/A'
                },
                { 
                    data: 'created_by.employee_name_en', 
                    name: 'created_by.employee_name_en',
                    defaultContent: 'N/A'
                },
                { 
                    data: null, 
                    name: 'status',
                    render: function (data, type, row) {
                        let isUpdate = '{{ $permission->is_update }}' === '1';
                        let isStatus = row.status ? true : false;
                        
                        let statusText = isStatus ? '@lang("lang.inactive")' : '@lang("lang.active")';
                        let statusIcon = isStatus ? 'text-danger' : 'text-success';
                        
                        if (!isUpdate) {
                            return `
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm btn-rounded" href="#">
                                        <i class="fa fa-dot-circle-o ${statusIcon}"></i>
                                        <span>${statusText}</span>
                                    </a>
                                </div>`;
                        }

                        return `
                            <div class="dropdown action-label">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-dot-circle-o ${statusIcon}"></i>
                                    <span>${statusText}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                    <a class="dropdown-item change-status" data-id="${row.id}" data-name="0" data-status-old="${row.status}" href="#">
                                        <i class="fa fa-dot-circle-o text-success"></i> @lang('lang.active')
                                    </a>
                                    <a class="dropdown-item change-status" data-id="${row.id}" data-name="1" data-status-old="${row.status}" href="#">
                                        <i class="fa fa-dot-circle-o text-danger"></i> @lang('lang.inactive')
                                    </a>
                                </div>
                            </div>`;
                    }
                },
                { 
                    data: null, 
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        let isUpdate = '{{ $permission->is_update }}' === '1';
                        let isDelete = '{{ $permission->is_delete }}' === '1';

                        if (!isUpdate && !isDelete) return '';

                        let editUrl = "{{ url('form-rental/edit') }}/" + row.id;
                        let editBtn = isUpdate
                        ? `<a class="dropdown-item btn-edit" data-id="${row.id}" href="javascript:void(0);"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>`
                        : '';
    
                        // let editBtn = isUpdate ? `<a href="${editUrl}" class="dropdown-item update"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>` : '';
                        let deleteBtn = isDelete ? `<a class="dropdown-item btn-delete" data-id="${row.id}"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>` : '';

                        return `
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ${editBtn}
                                    ${deleteBtn}
                                </div>
                            </div>`;
                    }
                }
            ],
            drawCallback: function() {
                $('#loading-overlay').hide();
            }
        });
    }
    function yes(v) { return ['1', 'yes', 1, true, 'true'].indexOf(v) > -1 ? 1 : 0; }
    function parseOpt(o) {
        if (typeof o === 'string') { try { o = JSON.parse(o); } catch (e) { o = []; } }
        return Array.isArray(o) ? o : [];
    }
    function mapEdit(d) {
        return {
            form_rental_id: d.id,
            title: d.title,
            type: d.type === 'motor' ? 'motorcycle' : d.type,
            condition_id: d.rental_rates_id,
            datas: (d.fields || []).map(f => ({
                field_id: f.id, field_label: f.field_label, field_type: f.field_type,
                is_required: yes(f.is_required), is_condition: yes(f.is_condition),
                option: parseOpt(f.options)
            }))
        };
    }

</script>
@endsection
