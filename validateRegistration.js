$("#registerPassword, #registerRepeatPassword").on("keyup", function () {
    if (
      $("#registerPassword").val() != "" &&
      $("#registerRepeatPassword").val() != "" &&
      $("#registerRepeatPassword").val() == $("#registerPassword").val()
    ) {
        $("#registerRepeatPassword")[0].setCustomValidity("");
    }
    else {
        document.getElementById("registerRepeatPassword").setCustomValidity("Passwords do not match");
    }
  });
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict';
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation');
  
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach((form) => {
      form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();