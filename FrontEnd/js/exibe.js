
function exibir(){

    $.getJSON('../APIConsulta/public/index.php/v1/quarto', function (data) {
        console.log(data);
       
        var data2 = JSON.stringify(data);
        console.log(data2);

       // document.getElementById("json").innerHTML = JSON.stringify(data, undefined, 2);
       document.querySelector('#json').innerHTML = JSON.stringify(data, undefined,1)
       .replace(/\n( *)/g, function (match, p1) {
           return '<br>' + '&nbsp;'.repeat(p1.length);
       });
                 
      });

}