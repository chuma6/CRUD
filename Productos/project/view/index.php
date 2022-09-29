<?php
    require_once("../controller/controlador.php");
    
    $conn = $conexion->conectar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script type="text/javascript" src="../../js/main.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>


</head>
<body>

    <section class="container pt-5">
        
        <h1> <?php echo !empty($_GET['id']) ? 'Modificar' : 'Añadir nuevo'; ?><span class="<?php echo !empty($_GET['id']) ? 'text-warning' : 'text-success'; ?>"> PRODUCTO</span> </h1>

        <form method="post">

            <div class="form-group mt-3">
                <label for="Nombre">Nombre </label>
                <input type="text" required name="nombre" class="form-control" placeholder="Nombre" value="<?php echo !empty($_GET['id']) ? $_GET['nombre'] : ""; ?>">
            </div>
    
            <div class="form-group mt-3">
                <label for="Caducidad">Caducidad </label>
                <input type="date" required name="caducidad" class="form-control" placeholder="Caducidad" value="<?php echo !empty($_GET['id']) ? $_GET['caducidad'] : ""; ?>">
            </div>
    
            <div class="form-group mt-3">
                <label for="pais">País de orígen </label>
                <input type="text" required name="pais" class="form-control" placeholder="País de orígen" value="<?php echo !empty($_GET['id']) ? $_GET['pais'] : ""; ?>">
            </div>
    
            <div class="form-group mt-3">
                <label for="precio">Precio: </label>
                <input type="number" required step="any" name="precio" class="form-control" value="<?php echo !empty($_GET['id']) ? $_GET['precio'] : ""; ?>">      
            </div>
      
            <?php
                if(!(empty($_GET['id']))){
                    echo '<input class="btn btn-success mt-3" type="submit" value="Modificar">';
                    echo '<a class="btn btn-warning mt-3 ms-3" href="products.php">Volver</a>';
                }else{
                    echo '<input class="btn btn-success mt-3" type="submit" value="Guardar">';
                    echo '<a class="btn btn-warning mt-3 ms-3" href="products.php">Ver Productos</a>';
                }
            ?>
            
        </form>
        
    </section>

</body>
</html>

<?php

    $nombre ="000xxx";
    if(!empty($_POST['nombre']) && !empty($_POST['caducidad']) && !empty($_POST['pais']) && !empty($_POST['precio'])){
        
        $nombre = $_POST['nombre'];
        $caducidad = $_POST['caducidad'];
        $pais = $_POST['pais'];
        $precio = $_POST['precio'];   

        if(!(empty($_GET['id']))){
            $sql = "UPDATE `producto` SET `Nombre`= '".$nombre."', `Caducidad`= '".$caducidad."',`Pais`= '".$pais."',`Precio`= '".$precio."' WHERE `id`= ".($_GET['id']).";";
        }else if(empty($_GET['id'])){
            $sql = "INSERT INTO `producto` (`Nombre`, `Caducidad`, `Pais`, `Precio`) VALUES ('$nombre', '$caducidad', '$pais', $precio)";
        }
        
        if (mysqli_query($conn, $sql)) {
            echo "<div class='container alert alert-success mt-3'>Se ha guardado el producto</div>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }   
        
        if(!empty($_GET['id'])){
            header("Location: products.php");
        }
    }

    $conexion->desconectar($conn);
?>
