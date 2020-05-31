var imported = document.createElement('script');
imported.src = '../../js/dates.js';
document.head.appendChild(imported);

function entregaValidation(inputfechaEntrega) {

    var today = new Date();
    var fechaEntrega = new Date(inputfechaEntrega.value);

    if (dates.compare(today,fechaEntrega) == 1) {
        console.error("Error con la fecha");
        var error = "Fecha menor al dia de hoy";
    } else {
        var error = "";
    }
    inputfechaEntrega.setCustomValidity(error);
    return error;
}

function solicitudValidation(inputfechaSolicitud) {

    var today = new Date();
    var fechaSolicitud = new Date(inputfechaSolicitud.value);

    if(dates.compare(fechaSolicitud,today) == 1){
        console.error("Error con la fecha");
        var error = "Fecha mayor al dia de hoy";
    }else{
        var error = "";
    }
    inputfechaSolicitud.setCustomValidity(error);
    return error;
}