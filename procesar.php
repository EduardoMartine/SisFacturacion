<?php


header('Content-Type: application/json');
require("conexion.php");

$pdo = retornarConexion();

switch ($_GET['accion']) {
    case 'agregar':
        //Recuperamos el precio del producto
        $sql = $pdo->prepare("select precio from productos where codigo=:codigoproducto");
        $sql->execute(array("codigoproducto"=>$_POST['codigoproducto']));
        $reg = $sql->fetch(PDO::FETCH_ASSOC);

        $sql = $pdo->prepare("insert into detallefactura(codigofactura,codigoproducto,cantidad,precio) values (:codigofactura,:codigoproducto,:cantidad,:precio)");
        $respuesta = $sql->execute(array("codigofactura" => $_GET['codigofactura'],
                                         "codigoproducto"=> $_POST['codigoproducto'],
                                         "cantidad"=> $_POST['cantidad'],
                                         "precio"=> $reg['precio']
                                        ));
        echo json_encode($respuesta);
        break;

    case 'confirmarfactura':
        $sql = $pdo->prepare("update facturas set
                                     fecha=:fecha,
                                     codigocliente=:codigocliente
                                     where codigo=:codigofactura");
        $respuesta = $sql->execute(array(
            "fecha" => $_POST['fecha'],
            "codigocliente" => $_POST['codigocliente'],
            "codigofactura" => $_GET['codigofactura']
        ));
        echo json_encode($respuesta);
        
        break;
    case 'confirmardescartarfactura':
        $sql = $pdo->prepare("delete from facturas where codigo=:codigofactura");
        $sql->execute(array("codigofactura" => $_GET['codigofactura']));
        $sql = $pdo->prepare("delete from detallefactura where codigofactura=:codigofactura");
        $respuesta = $sql->execute(array("codigofactura" => $_GET['codigofactura']));
        echo json_encode($respuesta);        

}