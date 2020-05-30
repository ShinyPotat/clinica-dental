var imported = document.createElement('script');
imported.src = '../../js/dates.js';
document.head.appendChild(imported);

function dateValidation(fechaCobro, fechaFactura) {

    const inputFecha = document.getElementById('fechaFactura');

    fechaCobro = new Date(fechaCobro);
    fechaFactura = new Date(fechaFactura);
    var now = new Date();

    if (dates.compare(fechaFactura,now) == 1) {
        console.error("Fecha inválida");
        var error = "Fecha inválida";
    } else if (dates.compare(fechaCobro,fechaFactura)==-1) {
        console.error("Factura después de cobro");
        var error = "Factura después de cobro";
    } else {
        var error = "";
    }
    inputFecha.setCustomValidity(error);
    return error;
}

function cobroValidation(fecha) {

    const inputFecha = document.getElementById('fechaCobro');
    
    var date = new Date(fecha);
    var now = new Date();

    if (dates.compare(date,now) == 1) {
        console.error("Fecha inválida");
        var error = "Fecha no válida";
    } else {
        var error = "";
    }
    inputFecha.setCustomValidity(error);
    return error;
}

function vencimientoValidation(fecha) {

    const inputFecha = document.getElementById('fechaVencimiento');
    
    var date = new Date(fecha);
    var now = new Date();

    if (dates.compare(now,date) == 1) {
        console.error("Fecha inválida");
        var error = "Fecha no válida";
    } else {
        var error = "";
    }
    inputFecha.setCustomValidity(error);
    return error;
}
