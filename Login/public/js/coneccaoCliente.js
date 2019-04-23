$('a#submit').click(function (event) {
    event.preventDefault();
    cadastrar();
    });

function cadastrar() {

    $.ajax({
        type: "POST",
        url: index.php/v1/cliente,
        data: formToJSON()
      });   
}

function formToJSON() {
    return JSON.stringify({
        "nome": $("#name").val(),
        "cpf": $("#cpf").val(),
        "endereco": $("#endereco").val(),
        "telefone": $("#telefone").val(),
        "email": $("#email").val(),
        "senha": $("#senha").val()
    });
}
