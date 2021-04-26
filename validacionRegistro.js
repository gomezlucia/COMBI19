
function noesvacio(nombre,apellido){	
	valido = false;
	if(nombre != null) {
		if(apellido != null){
			valido = true;
		}
		else{
			alert('apellido esta vacio')
		}
	}
	else{
		alert('nombre esta vacio');
	}
	return valido;
}

function emailIsValid (email) {
  return /\S+@\S+\.\S+/.test(email);
}
function esAlfabetico(str){ 
			return /^[a-zA-Z]+$/.test(str);
}
function esAlfanumerico(str){ //Es igual a esAlfabetico pero tambien le suma que tambien sea numerico;
			return /^[a-zA-Z0-9]+$/.test(str);;
}
function Checkfiles()
{
var fup = document.getElementById('imagen');
var fileName = fup.value;
var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "doc")
{
return true;
} 
else
{
alert("solo gifs o jpgs");
fup.focus();
return false;
}
}
function validarContrasenia(str){
			var numerosimbolo = 0; //variables para controlar
			var mayus = 0; //Que la contraseña tenga al menos
			var minus = 0; //Un caracter minuscula, mayuscula y un numero o simbolo.
			var i; //Variable i para el for
			for(i=0;i<str.length;i++){
				var caracterActual = str[i]; //Como el str es un string de caracteres (es una palabra), recorremos 
				if(!esAlfabetico(caracterActual)){  //caracter por caracter con la variable i;
					numerosimbolo++;  //Como no hay restriccion de algun caracter especial, si NO es alfabetico, significa que es un numero o un simbolo;
				}else{
					if(caracterActual == caracterActual.toUpperCase()){ //toUpperCase devuelve true si es mayuscula;
						mayus++; //Incrementamos si es mayuscula.
					}
					if(caracterActual == caracterActual.toLowerCase()){ //toLowerCase devuelve true si es minuscula;
						minus++; //Incrementamos si es minuscula;
					}
				}	//Acá significa que ya recorrimos toda la palabra recibida;
			}
			return (numerosimbolo>0 && ((mayus>0 && minus>0))); //Nos dará true si tiene numeros/simbolos Y al menos una letra mayuscula y al menos una letra minúscula. Si da false, saltará un alert.
}

function validacion(){
	var valormail = document.registro.user_mail.value;
	var valornombre = document.registro.nombre.value;
	var valorapellido = document.registro.apellido.value;
	var valorusername = document.registro.user_name.value;
	var valorclave = document.registro.clave.value;
	var valorclave1 = document.registro.clave1.value;
	var varimagen = document.registro.imagen.value;
	if(valornombre){
		if(valorapellido){
		if(esAlfabetico(valornombre) && esAlfabetico(valorapellido)){
			if(emailIsValid(valormail)){
				if(valorusername.length >= 6 ){
					if(esAlfanumerico(valorusername)){
						if(valorclave.length >=6){
							if(validarContrasenia(valorclave)){
								if(valorclave == valorclave1){
									if(varimagen){
										if(Checkfiles){	
										document.registro.submit();
										}
									}
									else{
										alert('debe de cargar una imagen');
									}
									
								}
								else{
									alert('las claves no coinciden');
								}
							}
							else{
								alert('la clave debe de tener mayusucalas , minusculas y un simbolo o numero');
							}
						}
						else{
							alert('la clave debe de tener 6 o mas caracteres');
						}
					}
					else{
						alert('el nombre de usuario solo debe  de tener caracteres alfanumericos');
					}
				}
				else{
					alert('el nombre de usuario debe de tener  6 o mas caracteres');
				}
			}
			else{
				alert('inserte un mail valido');
			}
		}
		else{
			alert('nombre y apellido deben de tener solo caracteres alfabeticos');
		}
		}
		else{
			alert('apellido esta vacio');
		}
	}
	else{
		alert('nombre esta vacio');
	}
}
