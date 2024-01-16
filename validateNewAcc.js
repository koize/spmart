function validateForm() {
    var name = document.getElementById("registerName").value;
    var username = document.getElementById("registerUsername").value;
    var email = document.getElementById("registerEmail").value;
    var password = document.getElementById("registerPassword").value;
    var password2 = document.getElementById("registerRepeatPassword").value;

  
    if (name == "") {
      alert("Name cannot be blank");
      return false;
    }

    if (username == "") {
        alert("Username cannot be blank");
        return false;
    }     
  
    if (!md.formValidation.validateEmail(email)) {
      alert("Please enter a valid email address");
      return false;
    }

    if (password == "") {
        alert("Password cannot be blank");
        return false;
    }

    if (password2 == "") {
        alert("Please repeat your password");
        return false;
    }

    if (password != password2) {
        alert("Passwords do not match");
        return false;
    }

    
  

    return true;
  }
  
  document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault();
  
    if (!validateForm()) {
      return;
    }
  
    // Submit the form data to the PHP script
    var formData = new FormData(document.getElementById("registerForm"));
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "account.php");
    xhr.send(formData);
  });