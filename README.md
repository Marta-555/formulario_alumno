# FORMULARIO
## Autor: Marta García Ortega
### Asignatura: Desarrollo en entorno servidor

Este proyecto consiste en la elaboración de un formulario en el que introducimos los datos de un alumno: nombre, apellidos, fecha de nacimiento, dni, correo electrónico y módulos que cursa el alumno. 

El formulario tiene que ser validado antes de enviar los datos al servidor, por lo que, si alguno de los campos está vacío o el formato utilizado no es el correcto, se volverá a cargar el formulario. Cuando sucede esto, los datos que estaban correctos se mantendrán en el mismo, mientras que los que eran erróneos, se eliminarán y dejarán el espacio vacío para volver a introducirlos. 

También mostraremos todos los errores que se han detectado en el formulario, para que el usuario sepa dónde se ha equivocado. 

El resultado sería el siguiente: 

![image-20211010222639914](C:\Users\marti\AppData\Roaming\Typora\typora-user-images\image-20211010222639914.png)



Respecto al código que hemos elaborado, primeramente comprobamos si se ha pulsado la tecla enviar, por lo que preguntamos si existe en POST ese elemento. Tras esto, declaramos las distintas variables que van a almacenar el valor de cada uno de los campos y les asignamos lo que esté contenido en POST (en caso de que no exista, dejamos el espacio vacío): 



```php
<?php
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
            $modulos = isset($_POST['modulos'])? $_POST['modulos']:"";
            
```



Validamos los datos del formulario y mostramos los errores que hay:

```php+HTML
     //--------------------------
            //  Validamos el formulario
            //--------------------------
            //Nombre
            if(!validarTexto($nombre)){
                $errores[] = "El nombre no puede estar vacío";
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


```



Para validar utilizaremos las siguientes funciones:

```php
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
?>

```



Por último, la estructura del formulario sería la siguiente:

```php+HTML
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
```

