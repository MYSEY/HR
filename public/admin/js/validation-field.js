$(function(){
    // 'use strict'
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
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