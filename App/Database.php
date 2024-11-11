<?php

namespace App;

class Database
{
    // Identifier to connect to the database
    private $cnx; // Will hold the PDO connection instance
    private $host = 'localhost';
    private $db = 'kaela_couture';
    private $login = 'root';
    private $pw = 'root';

    public function __construct()
    {
        // Initialize the PDO connection with the provided credentials
        $this->cnx = new \PDO("mysql:host=$this->host;dbname=$this->db", $this->login, $this->pw);

        // Configure PDO to throw an exception in case of an error
        $this->cnx->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    // Public method to retrieve the PDO connection instance
    public function getConnection()
    {
        return $this->cnx; // Returns the PDO connection for use elsewhere in the code
    }
}
