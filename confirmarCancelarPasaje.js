function SubmitForm(frm){
	var opcion = confirm('Si cancela un pasaje con menos de 48hs de ancipicacion se le devolvera el 50% del monto abonado, caso contrario se devolvera el 100% ¿Esta seguro que desea continuar?');
		if(opcion == true){
			frm.submit();
		}else{
			return false;
		}
}
