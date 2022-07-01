<?php
include "BaseDatos.php";
include "Empresa.php";


function mostrar($arreglo) {
    $cadena = "";
    foreach ($arreglo as $elemento) {
        $cadena .= $elemento."\n";
    }
    return $cadena;
}

$empresa = new Empresa();
echo mostrar($empresa->listar());
