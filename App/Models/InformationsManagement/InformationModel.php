<?php

namespace Models\InformationsManagement;

use App\Database;

class InformationModel
{
    protected $db;

    // Initializes the database connection
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to retrieve all information from the database
    public function getInformations()
    { // SQL query to select all informations
        $request = "SELECT * FROM information";
        $pdo = $this->db->query($request);
        return $pdo->fetchAll(\PDO::FETCH_ASSOC);
    }
}
