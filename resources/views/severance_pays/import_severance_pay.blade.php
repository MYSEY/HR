<div id="importSeverancePayModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.import_payroll')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="card-title mb-0">@lang('lang.import_excel_/_XLS_XLSX_or_CSV')</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12 alert thanLess" style="display:none;background-color:#F7D7DA">
                                <span id="thanLess"></span>
                            </div>
                            <div class="col-md-12" style="padding-left: 2%;">
                                <input type="file" id="result_file">
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

@include('includs.script')

<script type="text/javascript">
    $(function() {

        $("#result_file").on("change", function(){
            $(".thanLess").hide();
            $("#thanLess").text("");
        });

        $(".upload_file_data").on("click", function() {
            if ($('#result_file').val() == "") {
                $("#thanLess").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css("color", "red");
                $(".thanLess").show();
                return false;
            }
            var file_data = $('#result_file').prop('files')[0];
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

                $("#importSeverancePayModal").modal("show");
                $.ajax({
                    type: 'POST',
                    url: "{{ url('import/severance-pay') }}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data == 1) {
                            $("#importSeverancePayModal").modal("hide");
                            toastr.success('Data has been save success');
                            window.location.replace("{{ URL('severance-pay') }}");
                        }
                        if (data == 2) {
                            $("#importSeverancePayModal").modal("hide");
                            $("#thanLess").text("Data duplicate").css("color", "red");
                            $(".thanLess").show();
                        }
                        if (data == 0) {
                            $("#importSeverancePayModal").modal("show");
                            data == 0;
                            $("#thanLess").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css("color", "red");
                            $(".thanLess").show();
                        }
                    }
                });
            }else{
                $("#thanLess").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css("color", "red");
                $(".thanLess").show();
            }
        });
    });
</script>