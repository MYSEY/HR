<div class="col-sm-12">
    <div class="row">
        <div class="col-md-6">
            <h1 class="navbar-brand custom-navbar-brand mb-0 text-uppercase rounded-top">
                <strong>fixed duration contract</strong>
            </h1>
            <div class="shadow-sm border p-3">
                <div class="row">
                    <input type="hidden" name="fixedDuration" value="fixedDuration">
                    <div class="form-group col-12 col-sm-6 col-md-6">
                        <label for="fixed_dura_con_type">Type</label>
                        <div class="input-group">
                            <select id="fixed_dura_con_type" name="fixed_dura_con_type" class="form-control">
                                <option value="FDC" @if ($entry->fixed_dura_con_type == 'FDC') @endif selected>FDC</option>
                                <option value="UDC" @if ($entry->fixed_dura_con_type == 'UDC') @endif selected>UDC</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-6 hiddenfdcDate">
                        <label for="fdc_date">Start Date</label>
                        <div class="input-group">
                            <input type="date" id="fdc_date" name="fdc_date" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-12 hiddenfdcEnd">
                        <label for="fdc_end">End Date</label>
                        <div class="input-group"> 
                            <div class="input-group">
                                <input type="date" id="fdc_end" name="fdc_end" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h1 class="navbar-brand custom-navbar-brand mb-0 text-uppercase rounded-top">
                <strong>Employment Status</strong>
            </h1>
            <div class="shadow-sm border p-3">
                <div class="row">
                    <div class="form-group col-12 col-sm-6 col-md-6">
                        <label for="employee_status">Status</label>
                        <div class="input-group">
                            <select name="employee_status" class="form-control">
                                <option value="" selected>select status</option>
                                <option value="" selected>{{$entry->status}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-6">
                        <label for="">Start Date</label>
                        <div class="input-group">
                            <input type="date" name="status_date" class="form-control">
                        </div>
                    </div>

                    <div class="form-group col-12 col-sm-6 col-md-12">
                        <label for="">Reason</label>
                        <div class="input-group">
                            <textarea class="form-control" rows="2"  placeholder="Reason"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('after_styles')
    <style>
        .label-required { color:#ff0000; }
        .no-error-border { border-color: #d2d6de !important; }
        .no-error-label { color: #333 !important; }
        .repeatable-element{padding: 10px;border: 1px solid rgba(0,40,100,.12);border-radius: 5px;background-color: #f0f3f94f;margin-right: 0px;margin-left: 0;}
        .delete-element{z-index: 2; position: absolute !important; margin-left: -25px; margin-top: 0px; height: 30px; width: 30px; border-radius: 15px; text-align: center; background-color: #e8ebf0 !important;}
    </style>
@endpush


@push('after_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(function(){
            $('#fixed_dura_con_type').on('change',function(){
                if(this.value == 'UDC'){
                    $(".hiddenfdcDate").hide();
                    $(".hiddenfdcEnd").hide();
                }else{
                    $(".hiddenfdcDate").show();
                    $(".hiddenfdcEnd").show();
                }
            });
        });
    </script>
@endpush