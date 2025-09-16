<?php include 'includes/header.php'; ?>
    
    <form action="buscar" id="buscador">
        <input id="barraBusqueda" type="text" name="pokemon" placeholder="ingrese nombre, tipo o numero de pokemon">
        <input type="button" value="BUSCAR">
        
    </form>
    <main>

        <?php
$directorioDestino = "imagen/";

    // 1. Validar que la superglobal $_FILES existe
    if (isset($_FILES['retrato'])) {

        // Almacenar la información del archivo en variables para mayor legibilidad
        $nombreArchivo = $_FILES['retrato']['name'];
        $tipoArchivo   = $_FILES['retrato']['type'];
        $tamanoArchivo = $_FILES['retrato']['size'];
        $nombreTemporal = $_FILES['retrato']['tmp_name'];
        $errorArchivo = $_FILES['retrato']['error'];

        // Array de errores para ir acumulando los mensajes
        $errores = [];

        // 2. Validar que no haya errores de subida
        if ($errorArchivo !== UPLOAD_ERR_OK) {
            $errores[] = "Error al subir el archivo. Código de error: " . $errorArchivo;
        }

        // Si no hay errores iniciales, continuar con el resto de las validaciones
        if (empty($errores)) {

            // 3. Validar el tamaño del archivo (por ejemplo, máximo 2MB)
            $tamanoMaximo = 2 * 1024 * 1024; // 2 MB en bytes
            if ($tamanoArchivo > $tamanoMaximo) {
                $errores[] = "El tamaño del archivo excede el límite de 2MB.";
            }

            // 4. Validar el tipo de archivo (solo imágenes JPG, PNG, GIF)
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
            // Usar la función getimagesize() para una validación más segura del tipo MIME real
            $tipoMimeReal = mime_content_type($nombreTemporal);
            if (!in_array($tipoMimeReal, $tiposPermitidos)) {
                $errores[] = "Tipo de archivo no permitido. Solo se aceptan JPG, PNG y GIF.";
            }

            // 5. Validar que no exista un archivo con el mismo nombre en el destino
            $rutaCompleta = $directorioDestino . basename($nombreArchivo);
            if (file_exists($rutaCompleta)) {
                $errores[] = "Ya existe un archivo con el mismo nombre.";
            }
        }

        // 6. Verificar si se encontraron errores
        if (!empty($errores)) {
            echo "<h2>Errores en la subida:</h2>";
            echo "<ul>";
            foreach ($errores as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        } else {
            // 7. Si todo es correcto, mover el archivo temporal al destino final
            if (move_uploaded_file($nombreTemporal, $rutaCompleta)) {
                echo "<h2>¡Éxito!</h2>";
                echo "La imagen " . htmlspecialchars($nombreArchivo) . " ha sido subida correctamente.";
                echo "<br><img src='$rutaCompleta' alt='Imagen subida' style='max-width:300px;'>";
            } else {
                // Este error puede ocurrir por permisos en la carpeta, etc.
                echo "Error al mover el archivo a su directorio final.";
            }
        }

    } else {
        echo "No se recibió ninguna imagen.";
    } 
       // $imagen= $_FILES['retrato'];
        //echo "<img src='$imagen' alt="">";

           $conexion = mysqli_connect("localhost", "root", "", "pokemones", 3307)
            or die ("No se puede conectar con el servidor");
            
            $sql= "SELECT * FROM pokemones";
            $consulta = mysqli_query($conexion, $sql); 

            $nroFilas=  mysqli_num_rows($consulta);

            $row = mysqli_fetch_assoc($consulta);
            for($nroEjercicio=1;$nroEjercicio<15;$nroEjercicio++){
                //for($i=0;$i <$nroFilas;$i++){

                echo "<div class='cartaPokemon'>";
                echo   "<div class='numero'>".$row['id']."</div>";
                echo   "<div class='tipo'>".$row['tipo']."</div>";
                echo    "<img src=".$row['foto']." alt='Foto' class='foto'>";
                echo    "<div class='nombre'>".$row['nombre']."</div>";       
                
                echo"</div>";
            }
        ?> 
        </main>
    
</body>
</html>

<?php
/*
$directorioDestino = "images/";

    // 1. Validar que la superglobal $_FILES existe
    if (isset($_FILES['retrato'])) {

        // Almacenar la información del archivo en variables para mayor legibilidad
        $nombreArchivo = $_FILES['retrato']['name'];
        $tipoArchivo   = $_FILES['retrato']['type'];
        $tamanoArchivo = $_FILES['retrato']['size'];
        $nombreTemporal = $_FILES['retrato']['tmp_name'];
        $errorArchivo = $_FILES['retrato']['error'];

        // Array de errores para ir acumulando los mensajes
        $errores = [];

        // 2. Validar que no haya errores de subida
        if ($errorArchivo !== UPLOAD_ERR_OK) {
            $errores[] = "Error al subir el archivo. Código de error: " . $errorArchivo;
        }

        // Si no hay errores iniciales, continuar con el resto de las validaciones
        if (empty($errores)) {

            // 3. Validar el tamaño del archivo (por ejemplo, máximo 2MB)
            $tamanoMaximo = 2 * 1024 * 1024; // 2 MB en bytes
            if ($tamanoArchivo > $tamanoMaximo) {
                $errores[] = "El tamaño del archivo excede el límite de 2MB.";
            }

            // 4. Validar el tipo de archivo (solo imágenes JPG, PNG, GIF)
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
            // Usar la función getimagesize() para una validación más segura del tipo MIME real
            $tipoMimeReal = mime_content_type($nombreTemporal);
            if (!in_array($tipoMimeReal, $tiposPermitidos)) {
                $errores[] = "Tipo de archivo no permitido. Solo se aceptan JPG, PNG y GIF.";
            }

            // 5. Validar que no exista un archivo con el mismo nombre en el destino
            $rutaCompleta = $directorioDestino . basename($nombreArchivo);
            if (file_exists($rutaCompleta)) {
                $errores[] = "Ya existe un archivo con el mismo nombre.";
            }
        }

        // 6. Verificar si se encontraron errores
        if (!empty($errores)) {
            echo "<h2>Errores en la subida:</h2>";
            echo "<ul>";
            foreach ($errores as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        } else {
            // 7. Si todo es correcto, mover el archivo temporal al destino final
            if (move_uploaded_file($nombreTemporal, $rutaCompleta)) {
                echo "<h2>¡Éxito!</h2>";
                echo "La imagen " . htmlspecialchars($nombreArchivo) . " ha sido subida correctamente.";
                echo "<br><img src='$rutaCompleta' alt='Imagen subida' style='max-width:300px;'>";
            } else {
                // Este error puede ocurrir por permisos en la carpeta, etc.
                echo "Error al mover el archivo a su directorio final.";
            }
        }

    } else {
        echo "No se recibió ninguna imagen.";
    }*/
    ?>