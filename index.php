<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <?php
        include "../entidades/alumno.php";

        //Comprobamos los datos del POST
        if(isset($_POST['enviar'])){
            //-------------------
            //  Variables
            //--------------------
            $errores = [];
            $nombre = isset($_POST['nombre'])? $_POST['nombre']:"";
            $apellidos = isset($_POST['apellidos'])? $_POST['apellidos']:"";
            $fecha = isset($_POST['fecha'])? $_POST['fecha']:"";
            $dni = isset($_POST['dni'])? $_POST['dni']:"";
            $email = isset($_POST['email'])? $_POST['email']:"";
            $url = isset($_POST['url'])? $_POST['url']:"";
            $modulos = isset($_POST['modulos'])? $_POST['modulos']:"";

            $alumno = new Alumno($nombre, $apellidos, $fecha, $dni, $email, $url, $modulos);
            $alumno->muestra();

            //--------------------------
            //  Validamos el formulario
            //--------------------------
            //Nombre
            if(!validarTexto($nombre)){
                $errores[] = "hkg,g,";
            }
            //Apellidos
            if(!validarTexto($apellidos)){
                $errores[] = "Los apellidos no pueden estar vacíos";
            }
            //Fecha
            if(empty($fecha)){
                $errores[] = "Debe rellenar la fecha.";
            }
            //Dni
            if(!validarDni($dni)){
                $errores[] = "El dni está vacío o no tiene un formato válido";
            }
            //Email
            if(!validarEmail($email)){
                $errores[] = "El email está vacío o no tiene un formato válido";
            }
            //URL
            if(!validarURL($url)){
                $errores[] = "La URL está vacía o no tiene un formato válido";
            /*} else {
                if(!urlExiste($url)){
                    $errores[] = "La URL introducida no existe.";
                }*/
            }

            //Modulos
            if(empty($modulos)){
                $errores[] = "Debe escoger al menos un módulo.";
            }

        }

    ?>

    <!-------Mostramos errores------->
    <?php
    if(isset($errores)){
        foreach($errores as $error){
            echo '<span style="color:red"><ul><li>'. $error .'</li></ul></span>';
        }
    }
    ?>


    <!-------FORMULARIO-------->
    <h3>---Datos del alumno---</h3>

    <form action="" method="POST">

    <!----Campo nombre-->
        <p>Nombre: <input type="text" name="nombre" value="<?php
                if(empty($_POST['nombre'])){
                    echo '""';
                } else {
                    echo $_POST['nombre'];
                }
            ?>">
        </p>

        <!----Campo apellidos--->
        <p>Apellidos: <input type="text" name="apellidos" value="<?php
                if(empty($_POST['apellidos'])){
                    echo '""';
                } else {
                    echo $_POST['apellidos'];
                }
            ?>">
        </p>

        <!---Fecha nacimiento--->
        <p>Fecha nacimiento: <input type="date" name="fecha" value="<?php
                if(empty($_POST['fecha'])){
                    echo '""';
                } else {
                    echo $_POST['fecha'];
                }
            ?>">
        </p>

        <!----Campo dni--->
        <p>Dni: <input type="text" name="dni" placeholder="12345678H" value="<?php
                if(empty($_POST['dni'])){
                    echo '""';
                } else {
                    echo $_POST['dni'];
                }
            ?>">
        </p>

        <!----Campo email--->
        <p>Email: <input type="text" name="email" placeholder="ejemplo@gmail.com" value="<?php
                if(empty($_POST['email'])){
                    echo '""';
                } else {
                    echo $_POST['email'];
                }
            ?>">
        </p>

        <!----Campo URL--->
        <p>URL: <input type="text" name="url" placeholder="http://ejemplo.com" value="<?php
                if(empty($_POST['url'])){
                    echo '""';
                } else {
                    echo $_POST['url'];
                }
            ?>">
        </p>

        <!----Campo módulos--->
        <p>Módulos que cursa: </p>

        <p>
            <input type="checkbox" name="modulos[]" value="DWEC"
                <?php
                    if(isset($_POST['modulos']) && in_array("DWEC",$_POST['modulos'])){
                         echo 'checked="checked"';
                    }
               ?>
            /> DWEC
            <input type="checkbox" name="modulos[]" value="DWES"
                <?php
                    if(isset($_POST['modulos']) && in_array("DWES",$_POST['modulos'])){
                         echo 'checked="checked"';
                    }
               ?>
            /> DWES
            <input type="checkbox" name="modulos[]" value="DIWEB"
                <?php
                    if(isset($_POST['modulos']) && in_array("DIWEB",$_POST['modulos'])){
                         echo 'checked="checked"';
                    }
               ?>
            /> DIWEB
            <input type="checkbox" name="modulos[]" value="HLC"
                <?php
                    if(isset($_POST['modulos']) && in_array("HLC",$_POST['modulos'])){
                         echo 'checked="checked"';
                    }
               ?>
            /> HLC
            <input type="checkbox" name="modulos[]" value="EIE"
                <?php
                    if(isset($_POST['modulos']) && in_array("EIE",$_POST['modulos'])){
                         echo 'checked="checked"';
                    }
               ?>
            />
            EIE
        </p>

        <!---Botón---->
        <p><input type="submit" name= "enviar" value="Enviar"></p>

    </form>
</body>

<?php
    //----------------------------
    //  Funciones para validar
    //-----------------------------
    //Método para validar un texto (nombre y apellidos)
    function validarTexto($texto){
        if($texto == ''){
            return false;
        } else {
            return true;
        }
    }
    //Método para validar dni
    function validarDni($texto){

        if(preg_match("|\d{8}[A-Z]$|", $texto)){
            return true;
        } else {
            return false;
        }
    }
    //Método para validar email
    function validarEmail($texto){
        if(filter_var($texto, FILTER_VALIDATE_EMAIL) == false) {
            return false;
        } else {
            return true;
        }
    }
    //Método para validar URL
    function validarURL($texto){
        if(filter_var($texto, FILTER_VALIDATE_URL) == false){
            return false;
        } else {
            return true;
        }
    }

    /*function urlExiste($texto){
        $partes = parse_url($_POST['url']);
        /*if(gethostbyname(partes['host'])){
            return true;
        }
        var_dump($partes);

    }
    var_dump($_POST);
    */

?>

</html>