




function crear() {

    

                            $.ajax({
                                method: "POST",
                                url: "http://localhost/api/insert",
                                data: {
                                    
                                }


                            })

                                .done(function (msg) {
                                    window.alert("Se actualizaron los datos" );
                                    
                                });

}


function generarLetra(){
	var letras = ["a","b","c","d","e","f","0","1","2","3","4","5","6","7","8","9"];
	var numero = (Math.random()*15).toFixed(0);
	return letras[numero];
}
	
function colorHEX(){
	var coolor = "";
	for(var i=0;i<6;i++){
		coolor = coolor + generarLetra() ;
	}
	return "#" + coolor;
}




function listarPositivos() {



    $.ajax({
        method: "GET",
        url: "http://localhost/api/positivos",
       
    })
        .done(function (respuesta) {

                
            {

                $datos = $('#listarPositivos');

                // creo la tabla y muestro los datos


                $tabla = $('<table class="table table-bordered mt-4"> <thead><tr>' +
                    '<th scope="col">Ciudad</th>' +
                    '<th scope="col"> Casos Positivos</th>'
                    + 


                    '</tr>' +
                    '</thead>' +
                    '</table>');

                // hago un ciclo
                 var can=[];
                 var ciudad=[];
                 var color=[];
                for (var i = 0; i < respuesta.length; i++) {
                    var $tr = $('<tr></tr>');
                    $tr.append('<td>' + respuesta[i].Ciudad  + '</td>');
                    $tr.append('<td>' + respuesta[i].Cantidad+ '</td>');
                    ciudad[i]=(respuesta[i].Ciudad);
                    can[i]=(respuesta[i].Cantidad);
                   

                    color[i]=colorHEX();

                    // agrego la columna tr a la tabla
                    $tabla.append($tr);
                }

                // agrego la tabla al div 
                $datos.append($tabla);
                //se crea el grafico
                new Chart(document.getElementById("bar-chart-horizontal"), {
                    type: 'horizontalBar',
                    data: {
                      labels: ciudad,
                      datasets: [
                        {
                          label: "Casos Positivos",
                          backgroundColor: color,
                          data: can
                        }
                      ]
                    },
                    options: {
                      legend: { display: false },
                      title: {
                        display: true,
                        text: 'Reporte de Casos Positivos Por Municipio'
                      }
                    }
                });
            }



        });

}

function listarRecuperados(){

    $.ajax({
        method: "GET",
        url: "http://localhost/api/recuperados",
       
    })
        .done(function (respuesta) {

                
            {

                $datos = $('#listarRecuperados');

                // creo la tabla y muestro los datos


                $tabla = $('<table class="table table-bordered "> <thead><tr>' +
                    '<th scope="col">Ciudad</th>' +
                    '<th scope="col"> Numero de Recuperados</th>'
                    + 


                    '</tr>' +
                    '</thead>' +
                    '</table>');

                // hago un ciclo
                var can=[];
                var ciudad=[];
                var color=[];
               for (var i = 0; i < respuesta.length; i++) {
                   var $tr = $('<tr></tr>');
                   $tr.append('<td>' + respuesta[i].Ciudad  + '</td>');
                   $tr.append('<td>' + respuesta[i].Cantidad+ '</td>');
                   ciudad[i]=(respuesta[i].Ciudad);
                   can[i]=(respuesta[i].Cantidad);
                  

                   color[i]=colorHEX();

                   // agrego la columna tr a la tabla
                   $tabla.append($tr);
               }

               // agrego la tabla al div 
               $datos.append($tabla);
               //se crea el grafico
               new Chart(document.getElementById("bar-chart-horizontal"), {
                   type: 'horizontalBar',
                   data: {
                     labels: ciudad,
                     datasets: [
                       {
                         label: "Pacientes Recuperados",
                         backgroundColor: color,
                         data: can
                       }
                     ]
                   },
                   options: {
                     legend: { display: false },
                     title: {
                       display: true,
                       text: 'Reporte del Numero de Recuperados Por Municipio'
                     }
                   }
               });
           }



        });

}


function listarFallecidos() {

    $.ajax({
        method: "GET",
        url: "http://localhost/api/fallecidos",
       
    })
        .done(function (respuesta) {

                
            {

                $datos = $('#listarFallecidos');

                // creo la tabla y muestro los datos


                $tabla = $('<table class="table table-bordered mt-4"> <thead><tr>' +
                    '<th scope="col">Ciudad</th>' +
                    '<th scope="col"> Numero de Fallecidos</th>'
                    + 


                    '</tr>' +
                    '</thead>' +
                    '</table>');

                 // hago un ciclo
                 var can=[];
                 var ciudad=[];
                 var color=[];
                for (var i = 0; i < respuesta.length; i++) {
                    var $tr = $('<tr></tr>');
                    $tr.append('<td>' + respuesta[i].Ciudad  + '</td>');
                    $tr.append('<td>' + respuesta[i].Cantidad+ '</td>');
                    ciudad[i]=(respuesta[i].Ciudad);
                    can[i]=(respuesta[i].Cantidad);
                   
 
                    color[i]=colorHEX();
 
                    // agrego la columna tr a la tabla
                    $tabla.append($tr);
                }
 
                // agrego la tabla al div 
                $datos.append($tabla);
                //se crea el grafico
                new Chart(document.getElementById("bar-chart-horizontal"), {
                    type: 'horizontalBar',
                    data: {
                      labels: ciudad,
                      datasets: [
                        {
                          label: "Nro de Fallecidos",
                          backgroundColor: color,
                          data: can
                        }
                      ]
                    },
                    options: {
                      legend: { display: false },
                      title: {
                        display: true,
                        text: 'Reporte del Numero de Fallecidos Por Municipio'
                      }
                    }
                });
            }



        });

}

function listarPositivosSx(){

    


    $.ajax({
        method: "GET",
        url: "http://localhost/api/positivosex",
       
    })
        .done(function (respuesta) {

                
            {

                $datos = $('#listarPosex');

                // creo la tabla y muestro los datos


                $tabla = $('<table class="table table-bordered mt-4"> <thead><tr>' +
                    '<th scope="col">sexo</th>' +
                    '<th scope="col"> Numero de Casos</th>'
                    + 


                    '</tr>' +
                    '</thead>' +
                    '</table>');

                // hago un ciclo
                var can=[];
                for (var i = 0; i < respuesta.length; i++) {
                    var $tr = $('<tr></tr>');
                    $tr.append('<td>' + respuesta[i].sexo + '</td>');
                    $tr.append('<td>' + respuesta[i].Cantidad+ '</td>');
                   
                    can[i]=(respuesta[i].Cantidad);
                    

                    // agrego la columna tr a la tabla
                    $tabla.append($tr);
                }


                // agrego la tabla al div 
                $datos.append($tabla);
                
              


                new Chart(document.getElementById("pie-chart"), {
                    type: 'pie',
                    data: {
                      labels: ["Sexo Femenino", "Sexo Masculino"],
                      datasets: [{
                        label: "",
                        backgroundColor: ["#3e95cd", "#8e5ea2"],
                        data: can
                      }]
                    },
                    options: {
                      title: {
                        display: true,
                        text: 'Numero de Casos Postivos en Córdoba por Sexo'
                      }
                    }
                });
            }


          
        });

       

       
}


function listarEdades() {

    $.ajax({
        method: "GET",
        url: "http://localhost/api/edades",
       
    })
        .done(function (respuesta) {

                
            {

                $datos = $('#listarEdades');

                // creo la tabla y muestro los datos


                $tabla = $('<table class="table table-bordered mt-4"> <thead><tr>' +
                    '<th scope="col">Rango de Edad</th>' +
                    '<th scope="col"> Numero de Fallecidos</th>'
                    + 


                    '</tr>' +
                    '</thead>' +
                    '</table>');
                    

                // hago un ciclo

                 var can=[];
                 var  mEdad=[];
                 var color=[];

                for (var i = 0; i < respuesta.length; i++) {
                    var rest;
                    if(respuesta[i].edadmax>90){
                        var $tr = $('<tr></tr>');
                        $tr.append('<td>' + respuesta[i].edadmin +' Años en adelante'+ '</td>');
                        $tr.append('<td>' + respuesta[i].Cantidad+ '</td>');
                        can[i]=respuesta[i].Cantidad;
                        color[i]=colorHEX();
                        // agrego la columna tr a la tabla
                        $tabla.append($tr);
                        mEdad[i]='Mayores de'+' '+respuesta[i].edadmin;
                    }else{

                        var $tr = $('<tr></tr>');
                        $tr.append('<td>' + respuesta[i].edadmin +' - '+respuesta[i].edadmax+' Años'+ '</td>');
                        $tr.append('<td>' + respuesta[i].Cantidad+ '</td>');
                        can[i]=respuesta[i].Cantidad;
                        color[i]=colorHEX();
      
                        mEdad[i]=respuesta[i].edadmin +' - '+respuesta[i].edadmax;
                        // agrego la columna tr a la tabla
                        $tabla.append($tr);

                        new Chart(document.getElementById("polar-chart"), {
                            type: 'doughnut',
                            data: {
                              labels: mEdad,
                              datasets: [
                                {
                                  label: "Edad",
                                  backgroundColor: color,
                                  data: can
                                }
                              ]
                            },
                            options: {
                              title: {
                                display: true,
                                text: 'Reporte por Edad en años'
                              }
                            }
                        });
                        
                    }
                   
                }

                // agrego la tabla al div 
                $datos.append($tabla);
            }



        });

}

