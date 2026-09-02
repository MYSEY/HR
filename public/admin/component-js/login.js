$(document).ready(function(){
    $('#new_password').on('input', function(){
        var password = $(this).val();
        var passwordError = $('#passwordError');

        // Your validation criteria
        var minLength = 8;
        var hasUpperCase = /[A-Z]/.test(password);
        var hasLowerCase = /[a-z]/.test(password);
        var hasNumber = /\d/.test(password);
        var hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
        if(password.length < minLength) {
            passwordError.text('New password must be at least ' + minLength + ' characters long');
        } else if(!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecial) {
            passwordError.text('New password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
        } else {
            passwordError.text('');
        }
    });
});

$(document).ready(function() {
    document.getElementById("password").addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            submitForm();
        }
    });
    document.getElementById("number_employee").addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            submitForm();
        }
    });

    $('#btn-change-pass').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: formData,
            dataType: "JSON",
            success: function(response) {
                let data =  response;
                if (data.status == "error") {
                    toastr.error(data.message);
                    return false;
                }
                var errors = response.errors;
                if (errors) {
                    $.each(errors, function(field, messages) {
                        if (field === 'new_password') {
                            toastr.error(messages[0]);
                        } else {
                            $.each(messages, function(index, message) {
                                toastr.error(messages);
                            });
                        }
                    });
                    return false;
                }
                if (data.role == "Employee") {
                    toastr.success('Login successfully.');
                    window.location.replace(dashboadEmployee); 
                }else{
                    toastr.success('Login successfully.');
                    window.location.replace(dashboadAdmin); 
                }
            },
        });
    });
});
function submitForm() {
    $("#cha_number_employee").val($("#number_employee").val());
    $.ajax({
        type: "post",
        url: loginUrl,
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            number_employee: $("#number_employee").val(),
            password: $("#password").val(),
        },
        dataType: "JSON",
        success: function(response) {
            let data =  response;
            if (data.status == "success" && data.role == null) {
                $("#form-login").css("display", "none");
                $("#id01").css("display", "block");
                return false;
            }
            if (data.status == "error") {
                toastr.error(data.message);
                return false;
            }
            if (data.status == "success" && data.role == "Employee") {
                toastr.success(data.message);
                window.location.replace(dashboadEmployee); 
            }else{
                toastr.success(data.message);
                window.location.replace(dashboadAdmin); 
            }
        }
    });
}