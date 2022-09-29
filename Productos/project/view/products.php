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
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script type="text/javascript" src="../../js/main.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</head>
<body>
    <section class="container pt-5" id="listaProductos">

        <header>
            <h1>Lista de <span class="text-warning">PRODUCTOS</span></h1>
    
            <button id="btnFiltrar" type="button" class="btn btn-primary">Filtrar <img src="../../img/filtrar.png" class="ms-2" width="20px"></button>
        </header>

        
        <div id="filtrar">
            <div>
                <h2>Filtrar los <span class="text-primary">PRODUCTOS</span></h2>
            
                <form class="mt-5" method="get">
                    <div class="form-group mt-3">
                        <label for="nombreFiltrar">Buscar por Nombre</label><br>
                        <input class="mt-1" type="text" name="nombreFiltrar" placeholder="nombre del producto" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="caducidadFiltrar">Fecha de caducación</label><br>
                        <span>Desde:</span>
                        <input class="mt-1" type="date" name="desdeCaducidadFiltrar" placeholder="desde" required>
                        <span>Hasta:</span>
                        <input class="mt-1" type="date" name="hastaCaducidadFiltrar" placeholder="hasta" required>
                    </div> 
                    <div class="form-group mt-3">
                        <label for="paisFiltrar">País del producto</label>
                        <select name="paisFiltrar" required>
                            <option value="Todos">Todos</option>
                            <?php 
                                $sql = "SELECT `pais` FROM `producto`";
                                
                                $result = $conn->query($sql); 
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="'.$row['pais'].'">'.$row['pais'].'</option>';
                                    }
                                } else {
                                    echo "0 results";
                                }                   
                            ?>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="precioFiltrar">¿Cuánto quieres pagar?</label><br>
                        <input class="mt-1" type="number" name="desdePrecioFiltrar" placeholder="desde" required>
                        <input class="mt-1" type="number" name="hastaPrecioFiltrar" placeholder="hasta" required>
                    </div>
                    <button class="btn btn-success mt-4">Filtrar</button>
                    <button id="btnCancelarFiltro"class="btn btn-warning mt-4">Cancelar</button>
                </form>
            </div>
        </div>

        <table class="table table-striped mt-5">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Fecha de caducidad</th>
                    <th scope="col">País de orígen</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Editar</th>
                    <th scopr="col">Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    //PARA HACER UN SELECT A NUESTRA BASE DE DATOS
                    $sql = null;
    
                    if(!empty($_GET['nombreFiltrar']) && !empty($_GET['desdeCaducidadFiltrar']) && !empty($_GET['hastaCaducidadFiltrar']) && ($_GET['paisFiltrar'] != 'Todos') && (!empty($_GET['desdePrecioFiltrar']) || $_GET['desdePrecioFiltrar'] == 0) && !empty($_GET['hastaPrecioFiltrar'])){
                        $nombre = $_GET['nombreFiltrar'];
                        $hastaCaducidad = $_GET['desdeCaducidadFiltrar'];
                        $desdeCaducidad = $_GET['hastaCaducidadFiltrar'];
                        $pais = $_GET['paisFiltrar'];
                        $desdePrecio = $_GET['hastaPrecioFiltrar'];
                        $hastaPrecio = $_GET['desdePrecioFiltrar']; 
                        
                        $sql = "SELECT * FROM `producto` WHERE `nombre`= '". $nombre."' AND `caducidad` < '".$desdeCaducidad."'AND `caducidad` > '".$hastaCaducidad."'AND `pais` LIKE '".$pais."' AND `precio` < ".$desdePrecio." "." AND `precio` > ".$hastaPrecio."";
                    
                    }else{
                        $sql = "SELECT * FROM `producto`";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<tr scope="row">';
                            echo "<td>" . $row['Nombre'] . "</td>";
                            echo "<td>" . $row['Caducidad'] . "</td>";
                            echo "<td>" . $row['Pais'] . "</td>";
                            echo "<td>" . $row['Precio'] . "</td>";
                            
                            echo '<td class="btn-td"><a href="index.php?id='.$row["id"].'&nombre='.$row['Nombre'].'&caducidad='.$row['Caducidad'].'&pais='.$row['Pais'].'&precio='.$row['Precio'].'"><img src="../../img/editar.png" width="30px"></a></td>';
                            echo '<td class="btn-td"><a href="products.php?id='.$row["id"].'&nombre='.$row['Nombre'].'"><img src="../../img/borrar.png" width="30px"><a></td>';
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                ?>
            </tbody>
        </table>
        <a class="btn btn-success mt-3" href="index.php">Añadir producto</a>
        <?php
            if(!empty($_GET['id'])){
            $idDelete = $_GET['id'];
        ?>
            <div class="alert alert-danger mt-3" role="alert">
                <div id="confirmation">
                    <span>¿Seguro que quieres borrar el elemento <?php echo $_GET['nombre'];?>?</span>
                    <div class="btns">
                        <?php
                            echo '<a href="products.php?idDelete='.$idDelete.'" class="btn btn-danger">Borrar</a>';
                        ?>
                        <a href="products.php" class="btn btn-success">Cancelar</a>
                    <div>
                </div>
            </div>
        <?php
            }
            
            if(!empty($_GET['idDelete'])){
                $delete = $_GET['idDelete'];
                $sql = "DELETE FROM `producto` WHERE `id`=".$delete;
                if (mysqli_query($conn, $sql)) {
                    echo "<div class='container alert alert-success mt-3'>Se ha borrado el producto con éxito</div>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                header("Location: products.php");
            }
        ?>
    </section>


</body>
</html>

<?php
    $conexion->desconectar($conn);
?>