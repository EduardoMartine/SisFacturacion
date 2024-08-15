<?php

function retornarConexion() {
    $server="localhost";
    $usuario="root";
    $clave="";
    $base="base1";
    return new PDO("mysql:dbname=$base;host=$server", "$usuario","$clave", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
}

?>