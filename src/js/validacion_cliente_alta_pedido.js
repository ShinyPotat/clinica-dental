var imported = document.createElement('script');
imported.src = '../../js/dates.js';
document.head.appendChild(imported);

function dateValidation(fechaSolicitud, fechaEntrega) {
    fechaSolicitud = new Date(fechaSolicitud);
    fechaEntrega = new Date(fechaEntrega);

    if (dates.compare(fechaSolicitud,fechaEntrega) == 1) {
        console.error("Error con la fecha");
        var error = "Error con la fecha";
    } else {
        var error = "";
    }
    return error;
}

function solicitudValidation(fechaSolicitud) {
    var today = new Date();
    fechaSolicitud = new Date(fechaSolicitud);

    if(dates.compare(fechaSolicitud,today) == 1){
        console.error("Error con la fecha");
        var error = "Fecha mayor al dia de hoy";
    }else{
        var error = "";
    }
    return error;
}