$('a#reserva').click(function (event) {
    event.preventDefault();
    reservar();
    
});

function reservar() {
    
    var data = {};
    data["idQuartoReserva"] = $("#room").val();
    data["dataDia"] = $("#dataDia").val();
    data["dataMes"] = $("#dataMes").val();
    data["dataAno"] = $("#dataAno").val();
    data["qntDias"] = $("#totalDias").val();
    data["cpf"] = $("#cpf2").val();

    const url = "/T4/BackEnd/HotelSlim/public/v1/reserva";

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function (resultdata, textStatus, xhr) {
            // Do something with the result
            if (xhr.status == 201) {
                window.open ('reservationOK.html','_self',false);
            } else {
                window.open ('reservationFail.html','_self',false);
            }
        },
        complete: function (xhr, textStatus) {
            console.log(xhr.status);
        }

    });
}

