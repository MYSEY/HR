<div id="add_pay_motor_rentel" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-ms" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Pay Motor Rental</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('motor-rentel/create-pay')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Gasoline price per liter<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">៛</span>
                                    <input class="form-control @error('gasoline_price_per_liter') is-invalid @enderror" type="number" step="0.00" value="" id="gasoline_price_per_liter" required name="gasoline_price_per_liter">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Tax rate (%)<span class="text-danger">*</span></label>
                                <input class="form-control @error('tax_rate') is-invalid @enderror" type="number" id="tax_rate" required name="tax_rate" value="{{old('tax_rate')}}">
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">
                            {{-- Submit --}}
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                            <span class="btn-txt">{{ __('Submit') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>