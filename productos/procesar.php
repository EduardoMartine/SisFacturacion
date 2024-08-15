<?php
header('Content-Type: application/json');
require("../conexion.php");

$pdo = retornarConexion();

switch ($_GET['accion']) {
    case 'listar':
        $sql = $pdo->prepare("select 
                                pro.codigo as codigo,
                                pro.descripcion descripcion,
                                cat.descripcion descripcioncategoria,
                                precio
                              from productos as pro
                              join categorias as cat on cat.codigo=pro.codigocategoria");
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
        break;

    case 'agregar':
        $sql = $pdo->prepare("insert into productos(descripcion,precio,codigocategoria) values (:descripcion,:precio,:codigocategoria)");
        $respuesta = $sql->execute(array(
            "descripcion" => $_POST['descripcion'],
            "precio" => $_POST['precio'],
            "codigocategoria" => $_POST['codigocategoria']
        ));
        echo json_encode($respuesta);
        break;

    case 'recuperar':
        $sql = $pdo->prepare("select codigo, descripcion, precio, codigocategoria from productos where codigo=:codigo");
        $sql->execute(array("codigo" => $_POST['codigo']));
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
        break;

    case 'borrar':
        $sql = $pdo->prepare("delete from productos where codigo=:codigo");
        $resultado = $sql->execute(array("codigo" => $_POST['codigo']));
        echo json_encode($resultado);
        break;

    case 'modificar':
        $sql = $pdo->prepare("update productos set descripcion=:descripcion,
                                                   precio=:precio,
                                                   codigocategoria=:codigocategoria
                                               where codigo=:codigo");
        $respuesta = $sql->execute(array(
            "descripcion" => $_POST['descripcion'],
            "precio" => $_POST['precio'],
            "codigocategoria" => $_POST['codigocategoria'],
            "codigo" => $_POST['codigo']
        ));
        echo json_encode($respuesta);
        break;

    case 'listarcategorias':
        $sql = $pdo->prepare("select codigo, descripcion from categorias");
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
        break;
}