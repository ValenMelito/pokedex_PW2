<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Pokemon</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php 

include 'includes/header.php'; 


$conexion = mysqli_connect("localhost", "root", "", "pokemones", 3307)
            or die ("No se puede conectar con el servidor");

// Revisar si recibimos un id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir a número para seguridad

    $query = "SELECT *, GROUP_CONCAT(t.nombre SEPARATOR ', ') AS tipos
    FROM pokemone2 p
    JOIN pokemon_tipos pt ON p.id = pt.pokemon_id
    JOIN tipos t ON pt.tipo_id = t.id
    WHERE p.id = $id
    GROUP BY p.id";
    
    $consulta = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($consulta)) {
        echo "<h1>{$row['nombre']}</h1>";
        echo "<img src='{$row['foto']}' alt='{$row['nombre']}' width='200'>";
        echo "<p><b>Número:</b> {$row['numero']}</p>";
           
        echo "<div class='tipos'>";
        $tiposArray = explode(", ", $row['tipos']);
            foreach ($tiposArray as $tipo) {
                echo "<div class='tipo'>$tipo</div>";
            }
        echo        "</div>";


        echo "<p><b>Descripción:</b> {$row['descripcion']}</p>";
    } else {
        echo "Pokémon no encontrado.";
    }
} else {
    echo "No se especificó ningún Pokémon.";
}
?>    

<!--
    <form action="index.php"
    method="POST"
    enctype="multipart/form-data"
    >
    <input type="file" name="retrato" id="">
    <button class="w3-button w3-deep-purple w3-round-large w3-margin-bottom" type="submit">Crear Héroe</button>

</form>-->

</body>
</html>