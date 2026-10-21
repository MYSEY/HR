<div id="importContract" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.contract') @lang('lang.upload')</h5>
                <button type="button" class="close btn-close btn-close-goals" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="card-title mb-0">@lang('lang.import_file/pdf_or_zip,rar')</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12 alert contract_thanLess" style="display:none;background-color:#F7D7DA">
                                <span id="contract_thanLess"></span>
                            </div>
                            <input type="hidden" id="motor_id">
                            <div class="col-md-12" style="padding-left: 2%;">
                                <input type="file" id="contract" accept=".pdf, .zip, .rar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="javascript:" class="btn btn-primary submit-btn upload_file_data">
                        <span class="btn-text-submit">@lang('lang.submit')</span>
                        <span class="btn-loading" id="btn-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="error-container" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="error-message" class="modal-title">@lang('lang.import_goals')</h5>
                <button type="button" class="close btn-close btn-close-error" data-bs-dismiss="modal" aria-label="Close">
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
    $(function() {$("#contract").on("change", function(){
            $(".contract_thanLess").hide();
            $("#contract_thanLess").text("");
        });
        
        $(".btn-close-error").on("click", function (){
            window.location.reload();
        });

        $(".upload_file_data").on("click", function(e) {
            let btn = $(this);
            if (btn.hasClass('disabled')) {
                e.preventDefault();
                return false;
            }

            var file_input = $('#contract').prop('files');
            if (file_input.length == 0) {
                $("#contract_thanLess").text("សូមជ្រើសរើស File ប្រភេទ PDF, ZIP ឬ RAR ដែលមានទំហំតូចជាង ឬស្មើ 3 MB").css("color", "red");
                $(".contract_thanLess").show();
                return false;
            }

            var file_data = file_input[0];
            var id_upload = $('#motor_id').val();
            var fileName  = file_data['name'];
            var fileSize  = file_data['size']; // គិតជា Bytes
            var fileExtension = fileName.split('.').pop().toLowerCase(); // បំប្លែងជា lowercase

            var maxAllowedSize = 3 * 1024 * 1024; // 3MB (3,145,728 Bytes)
            var allowedExtensions = ['pdf', 'zip', 'rar'];

            // 1. ពិនិត្យមើល Extension និង File Size (<= 3MB)
            if (allowedExtensions.includes(fileExtension) && fileSize <= maxAllowedSize) {
                
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('id', id_upload);
                form_data.append('_token', "{{ csrf_token() }}");

                btn.addClass('disabled');
                $(".btn-close-goals").addClass('disabled');
                $(".btn-text-submit").hide();
                $(".btn-loading").css('display', 'block');

                $.ajax({
                    type: 'POST',
                    url: "{{ url('/rental/contract/upload') }}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data.status == 200) {
                            $("#importContract").modal("hide");
                            toastr.success('Data has been save success');
                            window.location.reload();
                        }
                        if(data.status == 422 || data.status == 500){
                            btn.removeClass('disabled');
                            $(".btn-close-goals").removeClass('disabled');
                            $(".btn-text-submit").show();
                            $(".btn-loading").hide();

                            let errorHtml = '';

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

                            $('#error-message').text(data.message || ' Upload មិនជោគជ័យ!');
                            $('#error-list').html(errorHtml);
                            $('#error-container').modal("show");
                            
                            new Noty({
                                text: "ការ Upload មិនជោគជ័យទាំងអស់ឡើយ សូមពិនិត្យបញ្ជីកំហុសខាងក្រោម!",
                                type: "error",
                                timeout: 5000,
                            }).show();
                            $("#importContract").modal("hide");
                        }
                    },
                    error: function(xhr) {
                        btn.removeClass('disabled');
                        $(".btn-close-goals").removeClass('disabled');
                        $(".btn-text-submit").show();
                        $(".btn-loading").hide();
                        
                        let msg = "មានបញ្ហាក្នុងការ Upload File!";
                        if(xhr.responseJSON && xhr.responseJSON.message){
                            msg = xhr.responseJSON.message;
                        }
                        $("#contract_thanLess").text(msg).css("color", "red");
                        $(".contract_thanLess").show();
                    }
                });
            } else {
                // ប្រសិនបើ File លើសពី 3MB ឬ ខុស Extension
                $("#contract_thanLess").text("សូមជ្រើសរើស File (PDF, ZIP, RAR) ដែលមានទំហំមិនឱ្យលើសពី 3 MB ឡើយ!").css("color", "red");
                $(".contract_thanLess").show();
            }
        });
    });
</script>
