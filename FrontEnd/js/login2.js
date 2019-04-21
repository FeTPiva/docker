//https://www.formget.com/javascript-login-form/

var attempt = 3; // Variable to count number of attempts.
// Below function Executes on click of login button.
function validate() {
    //isso ja sai como string https://www.w3schools.com/jsref/prop_text_value.asp
    var username = document.getElementById("email").value;
    var password = document.getElementById("senha").value;

    //var url = document.location.protocol + "//" + document.location.hostname + ":9002";
    //var api = url + "/api/emails/custom"

    $.ajax({

        url: "/docker/APILogin/HotelSlim/public/v1/funcionario", // my php file
        type: 'GET', // type of the HTTP request
        //MEXER NESSA MERDA
        success: function (funcionariosArray) {
            var obj = jQuery.parseJSON(result);
            console.log(obj);

            var data = {};
            if (username.equals(data["login"]) && password.equals(data["senha"])) {

                alert("Login successfully");
                window.location = "exibe.html"; // Redirecting to other page.
                return false;

            }

            else {
                attempt--;// Decrementing by one.
                alert("You have left " + attempt + " attempt;");
                // Disabling fields after 3 attempts.
                if (attempt == 0) {
                    document.getElementById("email").disabled = true;
                    document.getElementById("senha").disabled = true;
                    document.getElementById("login").disabled = true;
                    return false;
                }
            }
        }
    });

}