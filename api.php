<?php


use Repository\ConfigDB;
use Repository\Database;

require('Repository/Database.php');

function get_lista_autores()
{
    $db = new Database();
    $result_set = $db->getConnection()->query(ConfigDB::LIST_AUTHORS);
    return $result_set->fetch_assoc();
}

function get_lista_libros($id)
{
    $db = new Database();
    if ($result_set = $db->getConnection()->query("SELECT * FROM libros.libro WHERE id_autor = $id")) {
        $result_set->fetch_all(MYSQLI_ASSOC);
        $db->getConnection()->close();
    } else {
        echo 'Errorcito';
    }
    return $result_set;
}

function get_datos_autor($id)
{
    $db = new Database();
    if ($result_set = $db->getConnection()->query("SELECT * FROM libros.autor WHERE id = $id")) {
        $result_set->fetch_all(MYSQLI_ASSOC);
        $result_set_two = get_lista_libros($id);
        $db->getConnection()->close();
    } else {
        echo 'Errorcito';
    }
    return array($result_set, $result_set_two);
}

function get_datos_libros($id)
{

    $db = new Database();
    if ($result_set = $db->getConnection()->query("SELECT l.*, CONCAT (a.nombre , ' ' , a.apellidos) AS nombre FROM 
                                                                 libros.libro l 
                                                                     JOIN libros.autor a
                                                                         ON (l.id_autor=a.id) 
    WHERE a.id= $id")) {
        $result_set->fetch_all(MYSQLI_ASSOC);
        $db->getConnection()->close();
    } else {
        echo 'Errorcito';
    }
    return $result_set[0];
}

$posibles_URL = array("get_lista_autores", "get_datos_autor", "get_datos_libros");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL)) {
    switch ($_GET["action"]) {
        case "get_lista_autores":
            $valor = get_lista_autores();
            break;
        case "get_datos_autor":
            if (isset($_GET["id"]))
                $valor = get_datos_autor($_GET["id"]);
            else
                $valor = "Argumento no encontrado";
            break;
        case "get_datos_libros":
            if (isset($_GET["id"]))
                $valor = get_datos_libros($_GET["id"]);
            else
                $valor = "Argumento no encontrado";
    }
}


exit(json_encode($valor));
