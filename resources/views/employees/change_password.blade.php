<div id="modal_change_password" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="account-box">
                    <div class="account-wrapper">
                        <form class="needs-validation" novalidate>
                            @csrf
                            <input type="text" value="{{ $data->number_employee }}" name="" id="number_employee_id" hidden>
                            <div class="form-group Password-icon">
                                <div class="row">
                                    <div class="col">
                                        <label>Current Password <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <input type="password" id="current_password" class="form-control pass-input emp_required" name="current_password" required>
                                    <span class="fa fa-eye-slash toggle-password"></span>
                                    <div class="text-danger pt-2">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group Password-icon">
                                <div class="row">
                                    <div class="col">
                                        <label>New Password <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <input type="password" id="new_password" class="form-control emp_required pass-input" name="password" required>
                                    <span class="fa fa-eye-slash toggle-password"></span>
                                    <div class="text-danger pt-2">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group Password-icon">
                                <div class="row">
                                    <div class="col">
                                        <label>Confirm New Password <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <input type="password" id="comfirm_password" class="form-control emp_required pass-input" name="comfirm_password" required>
                                    <span class="fa fa-eye-slash toggle-password"></span>
                                    <div class="text-danger pt-2"></div>
                                </div>
                            </div>
                            <div class="submit-section text-end">
                                <button type="button" class="btn btn-primary" id="btn-change-passwork">Submit</button>
                            </div>
                        </form>
                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

