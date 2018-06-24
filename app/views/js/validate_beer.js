function validateBeer() {

    event.preventDefault();
    var abv, error;

    abv = document.getElementById("abv").value;

    if (isNaN(abv) || abv < 1) {
        error = "ABV must be a number greater than 1";
    }else {
        $("#abv-error").hide();
        $('#beer_form').submit();
    }
    document.getElementById("abv-error").innerHTML = error;
}

