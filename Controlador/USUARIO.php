<?php

require_once ("../Modelo/BASE_DE_DATOS.php");

echo "estoy antes de entrar al swtich";

    switch ($_POST['seleccionarMetodo']){

        case "validar":

            $confirmarUsuario = new USUARIO($_POST['nombreUsuario'],$_POST['passwordUsuario']);

            if($confirmarUsuario->validarUsuario() == true ){//if valida a true por default

                $respuesta = true;
                echo $respuesta;  //usuario creado satisfactoriamente

            }else{

                $respuesta = false; //usuario no fue creado correctamente
                //header("Location: ../Vista/DASHBOARD.html");
            }

            break;

        case "registrar":

            $nuevoUsuario = new USUARIO($_POST['nombreUsuario'],$_POST['passwordUsuario']);
            $resultado    = $nuevoUsuario->registrarUsuario();

            if(!$resultado){

                echo $respuesta = true; //"El usuario fue registrado satisfactoriamente";

            }else{
                echo $respuesta = false; //"El usuario fue registrado, ingrese un usuario diferente";
            }
            break;

        case "eliminar":
            break;

        case "actualizar":
            break;

    }

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 10/20/16
 * Time: 4:25 PM
 */
class USUARIO
{

    private $idUsuario; // el ambito o alcance es global para la clase
    private $nombreUsuario;
    private $passwordUsuario;
    private $conexion;
    private $query;

    public function __construct($nombre,$pass)//toda la vida se inicializa automaticamente y no depende de ninguna llamada explicita
    {
        $this->nombreUsuario = $nombre;
        $this->passwordUsuario = $pass;

        $this->conexion = new BASE_DE_DATOS();

    }

    public function validarUsuario(){

        try{

            echo "estoy en le metodo validarUsuario de la clase usuario";

            if($this->verificarExistenciaUsuario($this->nombreUsuario) == true){ //si es diferente de true ejectura el proceso


                echo "estoy dentro del metddo";

                $this->query = "SELECT paswordUsuario FROM USUARIO WHERE nombreUsuario = :nombre";
                $this->conexion->conectarBaseDeDatos();
                $pdoConexion = $this->conexion->conectarBaseDeDatos();

                $bind = $pdoConexion->prepare($this->query);
                $bind->bindParam(":nombre",$this->nombreUsuario);

                $bind->execute();

                $data = $bind->fetchAll(PDO::FETCH_OBJ);


               $contraseña = explode("",$data);

                echo $contraseña[0] . "este es el valor de la contraseña";

                if($this->verificarPassword($data[0])){

                    return true;

                }else{

                    return false;
                }

            }else{
                return false;
            }
        }catch (PDOException $ex){
            return $ex->getMessage();

        }finally{
            $pdoConexion = null;

        }
    }

    public function registrarUsuario(){

        try{

            $fecha = null;

            //invocamos el metodo encryptarPAssword
            $passEncriptada = $this->encryptarPassword($this->passwordUsuario);

            $this->query = "INSERT INTO USUARIO (nombreUsuario,
                                                 paswordUsuario,
                                                 fechaIniSesion) 
                                          VALUES(:nombre,:pass,:fecha)";

            $pdoConexion = $this->conexion->conectarBaseDeDatos();

            $bind = $pdoConexion->prepare($this->query);

            $bind->bindParam(":nombre",$this->nombreUsuario);
            $bind->bindParam(":pass",$passEncriptada);
            $bind->bindParam(":fecha",$fecha);

            $resultado = $bind->execute();

            if($resultado == true){
                return true;

            }else{
                return false;
            }

        }catch (PDOException $ex){
            return $ex->getMessage();

        }finally{
            $pdoConexion = null;
        }
    }

    public function actualizarUsuario(){


    }

    public function eliminarUsuario(){

    }

    private function verificarExistenciaUsuario($nombre){

        try{

            //estoy en le metodo verificar existencia usuario

            $this->query = "SELECT nombreUsuario FROM Usuario WHERE nombreUsuario = :nombre";  //query
            $pdoConexion = $this->conexion->conectarBaseDeDatos();//conecta con la base de datos

            $bind = $pdoConexion->prepare($this->query); //

            $bind->bindParam(":nombre",$nombre);
            $bind->execute();

            $data = $bind->fetchAll(PDO::FETCH_OBJ);


            //print_r($data);

            foreach ($data as $row){

                if($row == $nombre){

                    return true;

                }else{

                    return true;
                }


            }

        }catch(PDOException $ex){
            return $ex->getMessage();
        }finally{
            $pdoConexion = null;
        }

    }//end verificarExistenciaUsuario

    private function verificarNoExistenciaUsuario($nombre){

        try{

            //estoy en le metodo verificar no existencia usuario

            $this->query = "SELECT nombreUsuario FROM Usuario WHERE nombreUsuario = :nombre";  //query
            $pdoConexion = $this->conexion->conectarBaseDeDatos();//conecta con la base de datos

            $bind = $pdoConexion->prepare($this->query); //

            $bind->bindParam(":nombre",$nombre);
            $bind->execute();

            $data = $bind->fetchAll(PDO::FETCH_OBJ);


            print_r($data);

            foreach ($data as $row){

                if($row == $nombre){

                    return true;

                }else{

                    return false;
                }


            }

        }catch(PDOException $ex){
            return $ex->getMessage();
        }finally{
            $pdoConexion = null;
        }



    }

    private function encryptarPassword($pass){

        $hash = password_hash($pass,CRYPT_BLOWFISH);

        return $hash;

    }//end encryptarPassword

    private function verificarPassword($pass,$hash){

        if (password_verify($pass, $hash)) {

            return true;

        } else {

            return false;
        }
    }//end verificarPassword


}//end class