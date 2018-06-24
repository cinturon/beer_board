function validateBrewery() {

    event.preventDefault();
    var name, location, error, hasError;

    hasError = false;
    name = document.getElementById("brewery_name").value;

    if (name.length < 1) {
        hasError = true;
        error = "Please enter a name";
    }else {
        hasError = false;
        $("#name-error").hide();
        // $('#beer_form').submit();
    }
    document.getElementById("name-error").innerHTML = error;

    location = document.getElementById("brewery_location").value;

    if (location.length < 1) {
        hasError = true;
        error = "Please enter a city ";
    }else {
        hasError = false;
        $("#location-error").hide();

    }
    console.log(hasError);
    document.getElementById("location-error").innerHTML = error;

    if (!hasError){
        $('#brewery_form').submit();
    }
}