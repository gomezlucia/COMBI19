function SubmitForm(frm){
	var opcion = confirm('¿Estas seguro que desea cerrar sesión?');
		if(opcion == true){
			frm.submit();
		}else{
			return false;
		}
}
