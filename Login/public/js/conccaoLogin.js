$('a#login').click(function (event) {
    event.preventDefault();
    logar();
    window.open ('reservation.html','_self',false)
});
function logar() {
/*

    jQuery.ajax({
        url: 'localhost/Hotel/object/Cliente.php',
        type: 'POST',
        data: {functionname: 'getX', condition_code: condition_code},
            error:function(data)
            {
                alert("failed");
                console.log(data);
            },
            success: function(data) 
            {
                var obj = jQuery.parseJSON(data);
                alert( obj.x );
    
                console.log(obj); // Inspect this in your console
            }
    });
*/


    
    $.post("/BackEnd/Login.php", formToJSON(), function (data, status) {
        

        if (status == "success") {
            window.alert("Usuario Logado!");
            console.log("logou");

        } else {
            console.log(status);
            window.alert("Usuario não Logado!");
            console.log("nao logou");

        }
    });
}

function formToJSON() {
    return JSON.stringify({
        "email": $("#email").val(),
        "senha": $("#senha").val()
    });
}
