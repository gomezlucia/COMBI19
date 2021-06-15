function SubmitFormulario(frm){
    var opcion = confirm('Si cancela el viaje se le devolvera el 100% del monto abonado a los clientes correspondientes¿Estas seguro que desea continuar?');
        if(opcion == true){
            frm.submit();
        }else{
            return false;
        }
}

