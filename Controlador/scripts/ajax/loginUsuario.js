
//cargar automaticamente html del login
/*$(document).ready(function () {

    $("#layout").load("Vista/usuario/ingresarUsuario.html");

});*/

/*function irRegistroUsuario() {

    $("#content").load("usuario/registrarUsuario.html");

}*/


function validarUsuario() {

    //declar variables que se necesitan
    var metodo = "validar";

    var usuario = document.getElementById("usuario").value;
    var password = document.getElementById("password").value;

    if(usuario.length == 0){

        document.getElementById("lUsuario").innerHTML = "Ingrese Usuario";

    }else if(password.length == 0){

        document.getElementById("lPassword").innerHTML = "Ingrese contraseña";

    }else{

        //llamar la funcion crearXmlHttpRequest que me devuelva el objeto xmlhttp
        xmlhttp = crearXmlHttpRequest();

        xmlhttp.onreadystatechange = function () {

            console.log(xmlhttp.responseText);

            if(xmlhttp.readyState == 4){

                if(xmlhttp.responseText == true){

                    document.document.href = "../../../Vista/DASHBOARD.html";
                    //window.alert("Usuario creado correctamente");

                }else{

                    window.alert("Las credenciales no son correctas");

                }

            }
        }

        var dataForm = "seleccionarMetodo="+metodo+"&nombreUsuario="+usuario+"&passwordUsuario="+password;

        console.log("estoy en le dataForm : " + dataForm);

        xmlhttp.open("POST","Controlador/USUARIO.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        console.log("estoy antes del metodo SEND");

        xmlhttp.send(dataForm);

        console.log("estoy despues del metodo send");

    }

}//end validarUsuario

function registrarUsuario() {

    //declar variables que se necesitan
    var metodo = "registrar";

    var usuario = document.getElementById("usuario").value;
    var password = document.getElementById("password").value;
    var cPassword = document.getElementById("cPassword").value;

    if(usuario.length == 0){

        document.getElementById("lUsuario").innerHTML = "Ingrese Usuario";

    }else if(password.length == 0){

        document.getElementById("lPassword").innerHTML = "Ingrese contraseña";

    }else if(cPassword.length == 0){

        document.getElementById("lcPassword").innerHTML = "Confirme contraseña";

    }else if(password != cPassword){

       window.alert("Las contraseñas no son iguales");

    }else{

        //llamar la funcion crearXmlHttpRequest que me devuelva el objeto xmlhttp
        xmlhttp = crearXmlHttpRequest();

        xmlhttp.onreadystatechange = function () {

            if(xmlhttp.readyState == 4){

                document.getElementById("resultado").innerHTML = xmlhttp.responseText;

            }

        }

        var dataForm = "seleccionarMetodo="+metodo+"&nombreUsuario="+usuario+"&passwordUsuario="+password+"&cPasswordUsuario="+cPassword;

        console.log(dataForm);

        xmlhttp.open("POST","../../Controlador/USUARIO.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


        console.log("estoy antes del metodo SEND");

        xmlhttp.send(dataForm);

        console.log("estoy despues del metodo send");

    }

}//end registrarUsuario


function crearXmlHttpRequest() {

    var xmlhttp;

    if (window.XMLHttpRequest){ //chrome, mozila, safari

        xmlhttp = new XMLHttpRequest();

        return xmlhttp;

    }else{

        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); //internet explorer o edge

        return xmlhttp;
    }


}//end crearXmlHttpRequest





/*

//función creación del objeto XMLHttpRequest.
function registrarUsuario () { //Mayoría de navegadores

    var objetoAjax;

    if (window.XMLHttpRequest) {

        objetoAjax = new XMLHttpRequest();

    }else { //para IE 5 y IE 6

        objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    //Recoger datos del formulario:
    var usuario = document.getElementById("usuario").value;
    var password = document.getElementById("password").value;
    var cPassword = document.getElementById("cPassword").value;

    //datos para el envio por POST:
    var dataUrl = "nombreUsuario="+usuario+"&passwordUsuario="+password+"&cPasswordUsuario="+cPassword;

    //Preparar el envio  con Open
    objetoAjax.open("POST","../../Controlador/USUARIO.php",true);

    //Enviar cabeceras para que acepte POST:
    objetoAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    objetoAjax.setRequestHeader("Content-length", dataUrl.length);
    objetoAjax.setRequestHeader("Connection", "close");


    objetoAjax.send(dataUrl); //pasar datos como parámetro

    objetoAjax.onreadystatechange = function () {

        if(xmlhttp.readyState == 4 && objetoAjax.status==200){

            document.getElementById("resultado").innerHTML = xmlhttp.responseText;

        }

    }

}

*/








