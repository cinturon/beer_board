function validateUser() {

    event.preventDefault();
    var name, password, error, hasError;

    hasError = false;
    name = document.getElementById("username").value;

    if (name.length < 4) {
        hasError = true;
        error = "Name must be at least 4 characters";
    }else {
        hasError = false;
        $("#name-error").hide();
    }
    document.getElementById("name-error").innerHTML = error;

    password = document.getElementById("password").value;

    if (password.length < 6) {
        hasError = true;
        error = "Password must 6 characters ";
    }else {
        hasError = false;
        $("#password-error").hide();
    }
    document.getElementById("password-error").innerHTML = error;

    if (!hasError){
        $('#user_form').submit();
    }
}