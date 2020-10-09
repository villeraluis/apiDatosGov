




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





function listar() {



    $.ajax({
        method: "GET",
        url: "http://localhost/api/casos",
       
    })
        .done(function (respuesta) {


            {

                $datos = $('#listarFallecidos');

                // creo la tabla y muestro los datos


                $tabla = $('<table class="table table-bordered mt-4"> <thead><tr>' +
                    '<th scope="col">Id</th>' +
                    '<th scope="col">Dependencia</th>'
                    + '<th scope="col">Tipo</th>' +
                    '<th scope="col">Nombres</th>' +
                    '<th scope="col">Apellidos</th>' +
                    '<th scope="col">Email</th>' +
                    '<th scope="col">Asunto</th>' +
                    '<th scope="col">Descripcion</th>' +
                    '<th scope="col">Fecha</th>' +


                    '</tr>' +
                    '</thead>' +
                    '</table>');

                // hago un ciclo
                for (var i = 0; i < respuesta.length; i++) {
                    var $tr = $('<tr></tr>');
                    $tr.append('<td>' + respuesta[i].id_de_caso  + '</td>');
                    $tr.append('<td>' + respuesta[i].ciudad_de_ubicaci_n + '</td>');
                    $tr.append('<td>' + respuesta[i].fecha_de_muerte+ '</td>');
                    $tr.append('<td>' + respuesta[i].edad + '</td>');
                    $tr.append('<td>' + respuesta[i].sexo + '</td>');
                    $tr.append('<td>' + respuesta[i].tipo + '</td>');
                    $tr.append('<td>' + respuesta[i].fecha_diagnostico + '</td>');
                    $tr.append('<td>' + respuesta[i].fecha_reporte_web + '</td>');
                    $tr.append('<td>' + respuesta[i].atenci_n + '</td>');

                    // agrego la columna tr a la tabla
                    $tabla.append($tr);
                }

                // agrego la tabla al div 
                $datos.append($tabla);
            }



        });

}




function leer() {

    var tiket_id = document.getElementById("inputIdentificacionRead").value;

    $.ajax({
        method: "GET",
        url: "http://localhost/api/tickets/" + tiket_id,
        // data: { name: "John", location: "Boston" }
    })
        .done(function (respuesta) {

            if (respuesta.success == null) {


                $datos = $('#listarTodos');

                // creo la tabla y muestro los datos


                $tabla = $('<table class="table table-bordered mt-4"> <thead><tr>' +
                    '<th scope="col">Id</th>' +
                    '<th scope="col">Dependencia</th>'
                    + '<th scope="col">Tipo</th>' +
                    '<th scope="col">Nombres</th>' +
                    '<th scope="col">Apellidos</th>' +
                    '<th scope="col">Email</th>' +
                    '<th scope="col">Asunto</th>' +
                    '<th scope="col">Descripcion</th>' +
                    '<th scope="col">Fecha</th>' +


                    '</tr>' +
                    '</thead>' +
                    '</table>');



                var $tr = $('<tr></tr>');
                $tr.append('<td>' + respuesta.id + '</td>');
                $tr.append('<td>' + respuesta.nombre_dependencia + '</td>');
                $tr.append('<td>' + respuesta.nombre_tipo + '</td>');
                $tr.append('<td>' + respuesta.nombres + '</td>');
                $tr.append('<td>' + respuesta.apellidos + '</td>');
                $tr.append('<td>' + respuesta.email + '</td>');
                $tr.append('<td>' + respuesta.asunto + '</td>');
                $tr.append('<td>' + respuesta.descripcion + '</td>');
                $tr.append('<td>' + respuesta.fecha + '</td>');

                // agrego la columna tr a la tabla
                $tabla.append($tr);


                // agrego la tabla al div 
                $datos.append($tabla);
                if ($("#botonDelete").length) {
                    if ($("#botonReadD").attr("disabled", true));
                    document.getElementById("botonDelete").style.visibility = "visible";
                    document.getElementById("botonCancel").style.visibility = "visible";

                }
            }
            else {


                window.alert(respuesta.success);
            }



        });
    if ($("#botonRead").attr("disabled", true));
    if ($("#botonDesabled").removeAttr("disabled", false));

}




function borrar() {

    var id_ticket = document.getElementById("inputIdentificacionRead").value;


    $.ajax({
        method: "DELETE",
        url: "http://localhost/api/tickets/" + id_ticket,
        // data: { name: "John", location: "Boston" }
    })
        .done(function (respuesta) {

            window.alert(respuesta.success);
            recargar();


            //if($("#botonDesabled").removeAttr("disabled",false));

        });

    if ($("#botonDelete").attr("disabled", true)) {

    };



}





function cargaEditar() {

    var tiket_id = document.getElementById("inputIdentificacionRead").value;

    $.ajax({
        method: "GET",
        url: "http://localhost/api/tickets/" + tiket_id,
        // data: { name: "John", location: "Boston" }
    })
        .done(function (respuesta) {


            if (respuesta.success == null) {

                document.getElementById("einputDependencia").value = respuesta.id_dependencia;
                document.getElementById("einputTipo").value = respuesta.id_tipo;
                document.getElementById("einputNombres").value = respuesta.nombres;
                document.getElementById("einputApellidos").value = respuesta.apellidos;
                document.getElementById("einputEmail").value = respuesta.email;
                document.getElementById("einputAsunto").value = respuesta.asunto;
                document.getElementById("einputDescripcion").value = respuesta.descripcion;
                document.getElementById("einputFecha").value = respuesta.fecha;

            } else {


                window.alert(respuesta.success);
            }


            // agrego la columna tr a la tabla



            // agrego la tabla al div 

            if ($("#botonDelete").length) {
                if ($("#botonReadD").attr("disabled", true));
                document.getElementById("botonDelete").style.visibility = "visible";
                document.getElementById("botonCancel").style.visibility = "visible";

            }




        });
    // if($("#botonRead").attr("disabled",true));
    // if($("#botonDesabled").removeAttr("disabled",false));

}


function editar() {

    var tiket_id = document.getElementById("inputIdentificacionRead").value;

    var id_dependencia = document.getElementById("einputDependencia").value;
    var id_tipo = document.getElementById("einputTipo").value;
    var nombres = document.getElementById("einputNombres").value;
    var apellidos = document.getElementById("einputApellidos").value;
    var email = document.getElementById("einputEmail").value;
    var asunto = document.getElementById("einputAsunto").value;
    var descripcion = document.getElementById("einputDescripcion").value;
    var fecha = document.getElementById("einputFecha").value;


    $.ajax({
        method: "PATCH",
        url: "http://localhost/api/tickets/" + tiket_id + "?id_dependencia=" + id_dependencia +
            "&id_tipo=" + id_tipo + "&nombres=" + nombres + " &apellidos=" + apellidos + "&email=" + email +
            "&asunto=" + asunto + "&descripcion=" + descripcion + "&fecha=" + fecha,


    })

        .done(function (msg) {
            //  if($("#botonCreate").attr("disabled",true));
            // location.reload();
        });

}




function buscar() {

    var dato = document.getElementById("inputSearchFiltro").value;

    var id = document.getElementById("inputIdSearch").value;

    $.ajax({
        method: "OPTIONS",
        url: "http://localhost/api/tickets/" + id + "?dato=" + dato,
    })
        .done(function (respuesta) {


            {

                $datos = $('#listarTodos');

                // creo la tabla y muestro los datos


                $tabla = $('<table class="table table-bordered mt-4"> <thead><tr>' +
                    '<th scope="col">Id</th>' +
                    '<th scope="col">Dependencia</th>'
                    + '<th scope="col">Tipo</th>' +
                    '<th scope="col">Nombres</th>' +
                    '<th scope="col">Apellidos</th>' +
                    '<th scope="col">Email</th>' +
                    '<th scope="col">Asunto</th>' +
                    '<th scope="col">Descripcion</th>' +
                    '<th scope="col">Fecha</th>' +


                    '</tr>' +
                    '</thead>' +
                    '</table>');

                // hago un ciclo
                for (var i = 0; i < respuesta.length; i++) {
                    var $tr = $('<tr></tr>');
                    $tr.append('<td>' + respuesta[i].id + '</td>');
                    $tr.append('<td>' + respuesta[i].nombre_dependencia + '</td>');
                    $tr.append('<td>' + respuesta[i].nombre_tipo + '</td>');
                    $tr.append('<td>' + respuesta[i].nombres + '</td>');
                    $tr.append('<td>' + respuesta[i].apellidos + '</td>');
                    $tr.append('<td>' + respuesta[i].email + '</td>');
                    $tr.append('<td>' + respuesta[i].asunto + '</td>');
                    $tr.append('<td>' + respuesta[i].descripcion + '</td>');
                    $tr.append('<td>' + respuesta[i].fecha + '</td>');

                    // agrego la columna tr a la tabla
                    $tabla.append($tr);
                }

                // agrego la tabla al div 
                $datos.append($tabla);
            }





        });
    if ($("#botonRead").attr("disabled", true));
    if ($("#botonDesabled").removeAttr("disabled", false));
}

function recargar() {


    location.reload();

}




$(document).ready(function () {
    if ($("#botonDelete").length) {
        (document.getElementById("botonDelete").style.visibility = "hidden");
        (document.getElementById("botonCancel").style.visibility = "hidden");
    }


});
