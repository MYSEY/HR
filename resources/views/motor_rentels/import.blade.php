<div id="import_motor_rentel" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import New Motor Rentel</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Import Excel / XLS, XLSX or CSV</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-12 alert thanLess" style="display:none;background-color:#F7D7DA">
                                <span id="thanLess"></span>
                            </div>
                            <div class="col-md-12" style="padding-left: 2%;">
                                <input type="file" id="result_file">
                            </div>
                        </div><br>
                        <div class="btn-group " style="padding-left: 2%;">
                            <div>
                                <a href="javascript:" class="btn btn-primary submit-btn upload_file_data">submit</a>
                            </div>
                        </div>
                    </div>
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
                $("#thanLess").text("Please select a xls, xlsx and csv file and size less then 1 MB").css(
                    "color", "red");
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
                $("#import_motor_rentel").modal("show");
                $.ajax({
                    type: 'POST',
                    url: "{{ url('motor-rentel/import') }}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data == 1) {
                            $("#import_motor_rentel").modal("hide");
                            toastr.success('Data has been save success');
                            window.location.replace("{{ URL('motor-rentel/list') }}");
                        }
                        if (data == 2) {
                            $("#import_motor_rentel").modal("hide");
                            $("#thanLess").text("Data duplicate").css("color", "red");
                            $(".thanLess").show();
                        }
                        if (data == 0) {
                            $("#import_motor_rentel").modal("show");
                            data == 0;
                            $("#thanLess").text(
                                "Please select a xlsx, xls or csv file and size liss then 1 MB"
                                ).css("color", "red");
                            $(".thanLess").show();
                        }
                    }
                });
            }else{
                $("#thanLess").text("Please select a xls, xlsx and csv file and size less then 1 MB").css(
                    "color", "red");
                $(".thanLess").show();
            }
        });
    });
</script>
