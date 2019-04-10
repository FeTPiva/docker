$('a#submit').click(function (event) {
    event.preventDefault();
    cadastrar();
    });

function cadastrar() {
    
    var data = {};
    data["nome"] = $("#name").val();
    data["cpf"] = $("#cpf").val();
    data["endereco"] = $("#endereco").val();
    data["telefone"] = $("#telefone").val();
    data["email"] = $("#email").val();
    data["senha"] = $("#senha").val();

    const url = "/T4/BackEnd/HotelSlim/public/v1/cliente";

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function (resultdata, textStatus, xhr) {
            // Do something with the result
            if (xhr.status == 201) {
                alert("Usuário cadastrado com sucesso!");
                window.open ('reservation.html','_self',false);
            } else {
                alert("Falha no cadastro do usuário!");
            }
        },
        complete: function (xhr, textStatus) {
            console.log(xhr.status);
        }

    });
}


