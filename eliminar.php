<style>
    body {
        background-image: url("img/perritoz.jpg");
        background-repeat: no-repeat;
        background-position: center center;
        background-attachment: fixed;
        background-size: cover;
    }
</style>
<?php
require_once "model/conexion.php"; // Incluimos el archivo de conexión a la base de datos

// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos el ID de la mascota a eliminar
    $id = $_POST["id"];

    // Preparamos la consulta SQL para eliminar la mascota
    $stmt = $bd->prepare("DELETE FROM promociones WHERE id_mascota = :id ; DELETE FROM mascota WHERE id = :id");

    // Asignamos el valor del parámetro de la consulta
    $stmt->bindParam(":id", $id);

    // Ejecutamos la consulta SQL
    $stmt->execute();

    // Redirigimos al usuario a la página principal
    header("Location: index.php");
    exit();
}

// Obtenemos el ID de la mascota a eliminar
$id = $_GET["id"];

// Obtenemos los datos de la mascota a partir de su ID
$stmt = $bd->prepare("SELECT * FROM mascota WHERE id = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$mascota = $stmt->fetch(PDO::FETCH_ASSOC);

// Si la mascota no existe, redirigimos al usuario a la página principal
if (!$mascota) {
    header("Location: index.php");
    exit();
}

require_once "template/header.php"; // Incluimos el archivo del encabezado
?>

<div class="container">
    <h1 class="my-4">Eliminar cliente</h1>

    <p>¿Está seguro que desea eliminar a "<?php echo $mascota["nombre"]; ?>"?</p>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $mascota["id"]; ?>">
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once "template/footer.php"; // Incluimos el archivo del pie de página ?>