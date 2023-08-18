$(function(){
    // 'use strict'
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    // select option and search value
    $(document).ready(function(){
        $('.hr-select2-option').each(function() {
            $(this).select2({
                width: '100%',
              dropdownParent: $(this).parent(),
            })
          })

        $('.hr-select2-option').on('change', function(event) {
            $(".hr-form-group-select2").each(function(){
                let value = $(this).attr("data-select2-id");
                if(value){ 
                    $(this).find(".select2-selection--single").css("border-color","#198754");
                }
            });
        });
    });
   
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            $(".hr-form-group-select2").each(function(){
                let formGroup = $(this);
                let value = formGroup.attr("data-select2-id");
                let requeredField = formGroup.find(".hr-select2-option").val();
                let requered = formGroup.find(".requered").prop('required');
                if(!value && requered){ 
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else if (!requeredField && requered) {
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }
            });
            $(".loading-icon").css('display', 'block');
            $(".submit-btn").attr("disabled", true);
            $(".btn-txt").css("display", "none");
            setTimeout(function () {
                $(".submit-btn").attr('disabled',false);
                $(".loading-icon").css('display', 'none');
                $(".btn-txt").css("display", 'block');
            }, 500);
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated');
        }, false)
        
    })
});