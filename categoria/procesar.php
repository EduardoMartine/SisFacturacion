<?php
header('Content-Type: application/json');
require("../conexion.php");

$pdo = retornarConexion();

switch ($_GET['accion']) {
    case 'listar':
        $sql = $pdo->prepare("select codigo, descripcion from categorias");
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
        break;

    case 'agregar':
        $sql = $pdo->prepare("insert into categorias(descripcion) values (:descripcion)");
        $respuesta = $sql->execute(array("descripcion" => $_POST['descripcion']));
        echo json_encode($respuesta);
        break;

    case 'recuperar':
        $sql = $pdo->prepare("select codigo,descripcion from categorias where codigo=:codigo");
        $sql->execute(array("codigo" => $_POST['codigo']));
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
        break;

    case 'borrar':
        $sql = $pdo->prepare("delete from categorias where codigo=:codigo");
        $sql->execute(array("codigo" => $_POST['codigo']));
        $sql = $pdo->prepare("delete from productos where codigocategoria=:codigo");
        $resultado = $sql->execute(array("codigo" => $_POST['codigo']));
        echo json_encode($resultado);
        break;

    case 'modificar':
        $sql = $pdo->prepare("update categorias set descripcion=:descripcion where codigo=:codigo");
        $respuesta = $sql->execute(array(
            "descripcion" => $_POST['descripcion'],
            "codigo" => $_POST['codigo']
        ));
        echo json_encode($respuesta);
        break;
}