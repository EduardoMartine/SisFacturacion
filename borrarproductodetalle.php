<?php
header('Content-Type: application/json');
require("conexion.php");


$pdo = retornarConexion();
$sql = $pdo->prepare("delete from detallefactura where codigo=:codigo");
$resultado = $sql->execute(array("codigo" => $_GET['codigo']));
echo json_encode($resultado);

?>