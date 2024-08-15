<?php

require("conexion.php");

$pdo = retornarConexion();
$sql = $pdo->prepare("delete from facturas where codigo=:codigofactura");
$sql->execute(array("codigofactura" => $_GET['codigofactura']));
$sql = $pdo->prepare("delete from detallefactura where codigofactura=:codigofactura");
$resultado = $sql->execute(array("codigofactura" => $_GET['codigofactura']));

header('location:index.php');