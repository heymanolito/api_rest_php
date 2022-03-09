<html>

<body>

    <?php
    if (isset($_GET["action"]) && isset($_GET["id"])) {
        switch ($_GET["action"]) {
            case "get_datos_autor":


                $app_info = file_get_contents('http://localhost/tarea7rest/api.php?action=get_datos_autor&id=' . $_GET["id"]);

                $app_info = json_decode($app_info, true);
                //var_dump($app_info);
                //echo $app_info;
    ?>
                <p>
                    <td>Nombre: </td>
                    <td> <?php echo $app_info[0]["nombre"] ?></td>
                </p>
                <p>
                    <td>Apellidos: </td>
                    <td> <?php echo $app_info[0]["apellidos"] ?></td>
                </p>

                <ul>

                    <?php foreach ($app_info[1] as $libro) : ?>
                        <li>
                            <?php echo "<a href=\"/tarea7rest/cliente.php?action=get_datos_libros&id={$libro["id"]}\">{$libro["titulo"]}</a>";?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <br />

                <a href="/tarea7rest/cliente.php?action=get_lista_autores" alt="Lista de autores">Volver a la lista de autores</a>
        <?php
                break;
                case"get_datos_libros":
                    $app_info = file_get_contents('http://localhost/tarea7/api.php?action=get_datos_libros&id=' . $_GET["id"]);
                    $app_info = json_decode($app_info, true);
?>              
                    <p>
                    <td>Titulo: </td>
                    <td> <?php echo $app_info[0]["titulo"] ?></td>
                </p>
                <p>
                    <td>Fecha de publicación: </td>
                    <td> <?php echo $app_info[0]["f_publicacion"] ?></td>
                </p>
                <a href="/tarea7rest/cliente.php?action=get_datos_autor&id=<?= $app_info[0]["id_autor"]?>"><?= $app_info[0]["nombre"]?></a>
                <a href="/tarea7rest/cliente.php?action=get_lista_autores" alt="Lista de autores">Volver a la lista de autores</a>
<?php
                    break;
        }
    } else //sino muestra la lista de autores
    {

        $lista_autores = file_get_contents('http://localhost/dwes/tarea7rest/api.php?action=get_lista_autores');
        //var_dump($lista_autores);
        //$lista_autores = json_decode($lista_autores, true);
        var_dump(json_decode($lista_autores)); // <- NULL
        var_dump(json_last_error()); //
        var_dump(json_last_error_msg()); //<-- SYNTAX ERROR
        //var_dump($lista_autores);
        ?>
        <ul>

            <?php
            //var_dump($lista_autores);
            foreach ($lista_autores as $autores) : ?>
                <li>

                    <a href="<?php echo "/dwes/tarea7rest/cliente.php?action=get_datos_autor&id=" . $autores["id"]  ?>">
                        <?php echo $autores["nombre"] . " " . $autores["apellidos"] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php
    } ?>
</body>

</html>