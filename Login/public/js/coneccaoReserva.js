$('a#reserva').click(function (event) {
    event.preventDefault();
    reservar();
    
});

function reservar() {
    console.log(formToJSON);
    $.post("/BackEnd/public/index.php/v1/reserva", formToJSON(), function (data, status) {
        if (status == "success") {
            alert("Reserva com sucesso!");
            window.open ('reservationOK.html','_self',false);
            
        } else {
            console.log(status);
           alert("Reserva sem sucessoS");
           window.open ('reservationFail.html','_self',false);
        }
    });
}

function formToJSON() {
    return JSON.stringify({
        "idQuartoReserva": $("#room").val(),
        "dataDia": $("#dataDia").val(),
        "dataMes": $("#dataMes").val(),
        "dataAno": $("#dataAno").val(),
        "qntDias": $("#totalDias").val(),
        "cpf": $("#cpf2").val()
        
    });
}