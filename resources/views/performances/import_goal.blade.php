<div id="importGoal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.import_goals')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="card-title mb-0">@lang('lang.import_excel_/_XLS_XLSX_or_CSV')</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12 alert kpi_thanLess" style="display:none;background-color:#F7D7DA">
                                <span id="kpi_thanLess"></span>
                            </div>
                            <div class="col-md-12" style="padding-left: 2%;">
                                <input type="file" id="result_file_kpi" accept=".xlsx, .xls, .csv">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="javascript:" class="btn btn-primary submit-btn upload_file_data">
                        <span class="btn-text-submit">@lang('lang.submit')</span>
                        <span id="btn-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="error-container" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="error-message" class="modal-title">@lang('lang.import_goals')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ol id="error-list" class="list-group list-group-numbered"></ol>
            </div>
        </div>
    </div>
</div>
@include('includs.script')
<script type="text/javascript">
    $(function() {
        $("#result_file_kpi").on("change", function(){
            $(".kpi_thanLess").hide();
            $("#kpi_thanLess").text("");
        });

        $(".upload_file_data").on("click", function() {
            if ($('#result_file_kpi').val() == "") {
                $("#kpi_thanLess").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css("color", "red");
                $(".kpi_thanLess").show();
                return false;
            }
            var file_data = $('#result_file_kpi').prop('files')[0];
            var fileName = file_data['name'];
            var form_data = new FormData();
            var fileExtension = fileName.split('.').pop();
            var fileSize = file_data['size'];
            form_data.append('file', file_data);
            form_data.append('_token', "{{ csrf_token() }}");
            if (fileExtension == "xls" || fileExtension == "xlsx" || fileExtension == "csv" && fileSize < 1048576) {
                $(".upload_file_data").prop('disabled', true);
                $(".btn-text-submit").hide();
                $("#btn-loading").css('display', 'block');

                $("#importGoal").modal("show");
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/performance/import/goal') }}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data.status == 200) {
                            $("#importGoal").modal("hide");
                            toastr.success('Data has been save success');
                            window.location.reload();
                        }
                        if(data.status == 422){
                           let errorHtml = '';

                            // ១. ឆែកមើល Error របស់បុគ្គលិក (Staff IDs)
                            if (data.invalid_staff && data.invalid_staff.length > 0) {
                                data.invalid_staff.forEach(function(staffId) {
                                    errorHtml += `<li class="list-group-item">Sheet <strong>${staffId}</strong> រកមិនឃើញក្នុងប្រព័ន្ធ</li>`;
                                });
                            }

                            if (data.row_errors && data.row_errors.length > 0) {
                                data.row_errors.forEach(function(error) {
                                    errorHtml += `<li class="list-group-item">${error}</li>`;
                                });
                            }

                            // បង្ហាញក្នុង Container
                            $('#error-message').text(data.message);
                            $('#error-list').html(errorHtml);
                            $('#error-container').modal("show");
                            new Noty({
                                text: "ការ Upload មិនជោគជ័យទាំងអស់ឡើយ សូមពិនិត្យបញ្ជីកំហុសខាងក្រោម!",
                                type: "error",
                                timeout: 5000,
                            }).show();
                            $("#importGoal").modal("hide");
                        }
                    }
                });
            }else{
                $("#kpi_thanLess").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css("color", "red");
                $(".kpi_thanLess").show();
            }
        });
    });
</script>
