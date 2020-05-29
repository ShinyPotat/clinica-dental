var imported = document.createElement('script');
imported.src = '../../js/dates.js';
document.head.appendChild(imported);

function dateValidation(fechaCobro, fechaVencimiento, fechaFactura) {

    fechaCobro = new Date(fechaCobro);
    fechaVencimiento = new Date(fechaVencimiento);
    fechaFactura = new Date(fechaFactura);
    console.log(dates.compare(fechaCobro,fechaFactura));
    if (dates.compare(fechaCobro,fechaFactura)==-1 || dates.compare(fechaVencimiento,fechaFactura)==-1) {
        console.error("Error con la fecha de factura");
        var error = "Error con la fecha de factura"
    } else {
        var error = "";
    }
    return error;
}

function dateValidation(fecha) {
    
    var date = new Date(fecha);
    var now = new Date();

    if (dates.compare(date,now) == 1) {
        console.error("Fecha inválida");
        var error = "&emsp;Fecha no válida";
    } else {
        var error = "";
    }
    
    return error;
}
