//https://www.formget.com/javascript-login-form/
// Variable to count number of attempts.
// Below function Executes on click of login button.

function validate() {
    //isso ja sai como string https://www.w3schools.com/jsref/prop_text_value.asp
    var username = document.getElementById("email").value;
    var password = document.getElementById("senha").value;
    //var data = {};
    //$.getJson('/docker/APILogin/HotelSlim/public/v1/funcionario', function(jsonData){});
    //console.log(jsonData);
    $.getJSON('../APILogin/public/index.php/v1/funcionario', function (data) {
        console.log(data);
       
        var data2 = JSON.stringify(data);
        console.log(data2);

        if ((data2.indexOf(username) > -1) && (data2.indexOf(password) > -1) &&  username != '' && password !='') {
            //In the array!
            
            window.location = "exibe.html";
            alert("Login funcionou :O");
        } else {
            //Not in the array
            alert("Login Fail :( olhe a SUPER dica");
        }

        //for(i=0; i<data2.length; i++){
           // console.log(data2[i]);
       // }
          
      });
     
}

/*<!DOCTYPE html>
<html>
<body>

<h2>JavaScript Prompt</h2>

<button onclick="myFunction()">Try it</button>

<p id="demo"></p>

<script>
function myFunction() {
  var txt;
  var person = prompt("Login");
  var person2 = prompt("Senha:");
  if (person == null || person == "") {
    txt = "User cancelled the prompt.";
  } else {
    txt = "Hello " + person + "! How are you today?" + person2;
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>

</body>
</html>*/