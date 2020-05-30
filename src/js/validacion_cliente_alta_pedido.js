var imported = document.createElement('script');
imported.src = '../../js/dates.js';
document.head.appendChild(imported);

function entregaValidation(fechaEntrega) {

    const fecha = document.getElementById('fechaEntrega');

    var today = new Date();
    fechaEntrega = new Date(fechaEntrega);

    if (dates.compare(today,fechaEntrega) == 1) {
        console.error("Error con la fecha");
        var error = "Fecha menor al dia de hoy";
    } else {
        var error = "";
    }
    fecha.setCustomValidity(error);
    return error;
}

function solicitudValidation(fechaSolicitud) {

    const fecha = document.getElementById('fechaSolicitud');

    var today = new Date();
    fechaSolicitud = new Date(fechaSolicitud);

    if(dates.compare(fechaSolicitud,today) == 1){
        console.error("Error con la fecha");
        var error = "Fecha mayor al dia de hoy";
    }else{
        var error = "";
    }
    fecha.setCustomValidity(error);
    return error;
}