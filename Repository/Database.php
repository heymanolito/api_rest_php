<?php

namespace Repository;

use mysqli;

require_once ('ConfigDB.php');


/**
 * @author: Manuel Gallardo Fuentes
 */
class Database
{
    /**
     * @var mysqli|null
     */
    private ?mysqli $connection;

    /**
     * Función constructora
     */
    public function __construct()
    {
        $this->connection = $this->connect();
    }

    /**
     * Devuelve una instancia del conector Mysqli. Si ocurre un error, devuelve null.
     * @return mysqli|null
     */
    private function connect()
    {

        if ($mysqli = new mysqli(ConfigDB::HOST, ConfigDB::USERNAME, ConfigDB::PASSWORD)) {
            echo '<script>console.log("Conexión establecida con la base de datos.")</script>';
            return $mysqli;
        }
        echo '<script>console.log("No se ha podido establecer una conexión.")</script>';
        return null;
    }


    /**
     * @return mysqli|null
     */
    public function getConnection(): ?mysqli
    {
        return $this->connection;
    }




}