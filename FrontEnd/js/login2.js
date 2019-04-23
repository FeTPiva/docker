//https://www.formget.com/javascript-login-form/
// Variable to count number of attempts.
// Below function Executes on click of login button.


function validate() {
    //isso ja sai como string https://www.w3schools.com/jsref/prop_text_value.asp
    var username = document.getElementById("email").value;
    var password = document.getElementById("senha").value;
    var data = {};
    //$.getJson('/docker/APILogin/HotelSlim/public/v1/funcionario', function(jsonData){});
    //console.log(jsonData);
    
    $.ajax({
               
        url: '../Login/public/index.php/v1/funcionario', // my php file
        type: 'GET', // type of the HTTP request
        data: data,    
        success: function (resultdata, textStatus, xhr) {
            var obj = jQuery.getJSON(resultdata);
      
            console.log(username + " " + password);
            console.log(obj);
            
            
            if (username == obj["login"] && password == obj["senha"]) {

                alert("Login successfully");
                window.location = "exibe.html"; // Redirecting to other page.
                return false;

            }
           
        }
    });

}