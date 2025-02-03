<div id="importUpdateEmployeeModal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.import_employee')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="card-title mb-0">The uploaded information is as follows: </h4><br>
                <p class="text-danger">1, Information for update Employees</p>
                <p class="text-danger">2, Emergency Contact</p>
                <p class="text-danger">3, Education Informations</p>
                <p class="text-danger">4, Experience Informations</p>
                <p class="text-danger">5, Children Informations</p>
                <p class="text-danger">6, Change Password</p>
                <h4 class="card-title mb-0">@lang('lang.import_excel_/_XLS_XLSX_or_CSV')</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12 alert thanLess-e" style="display:none;background-color:#F7D7DA">
                                <span id="thanLess-e"></span>
                            </div>
                            <div class="col-md-12" style="padding-left: 2%;">
                                <input type="file" id="result_file_e">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="javascript:" class="btn btn-primary submit-btn upload_file_data">
                        <span class="btn-text-submit">@lang('lang.submit')</span>
                        <span id="e-btn-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includs.script')

<script type="text/javascript">
    $(function() {

        $("#result_file_e").on("change", function(){
            $(".thanLess-e").hide();
            $("#thanLess-e").text("");
        });

        $(".upload_file_data").on("click", function() {
            if ($('#result_file_e').val() == "") {
                $("#thanLess-e").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css(
                    "color", "red");
                $(".thanLess-e").show();
                return false;
            }
            var file_data = $('#result_file_e').prop('files')[0];
            var fileName = file_data['name'];
            var form_data = new FormData();
            var fileExtension = fileName.split('.').pop();
            var fileSize = file_data['size'];
            form_data.append('file', file_data);
            form_data.append('_token', "{{ csrf_token() }}");
            if (fileExtension == "xls" || fileExtension == "xlsx" || fileExtension == "csv" && fileSize < 1048576) {
                $(".upload_file_data").prop('disabled', true);
                $(".btn-text-submit").hide();
                $("#e-btn-loading").css('display', 'block');

                $("#importUpdateEmployeeModal").modal("show");
                $.ajax({
                    type: 'POST',
                    url: "{{ url('users/import/update/employee') }}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data == 1) {
                            $("#importUpdateEmployeeModal").modal("hide");
                            toastr.success('Data has been save success');
                            window.location.replace("{{ URL('users') }}");
                        }
                        if (data == 2) {
                            $("#importUpdateEmployeeModal").modal("hide");
                            $("#thanLess-e").text("Data duplicate").css("color", "red");
                            $(".thanLess-e").show();
                        }
                        if (data == 0) {
                            $("#importUpdateEmployeeModal").modal("show");
                            data == 0;
                            $("#thanLess-e").text(
                                "@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')"
                                ).css("color", "red");
                            $(".thanLess-e").show();
                        }
                    }
                });
            }else{
                $("#thanLess-e").text("@lang('lang.please_select_a_xls,_xlsx_and_csv_file_and_size_less_then_1_MB')").css(
                    "color", "red");
                $(".thanLess-e").show();
            }
        });
    });
</script>
