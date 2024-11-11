<?php

namespace Models\SectionsManagement;

use App\Database;

// Class to handle the retrieval of sections in the admin panel
class SectionModel
{
    protected $db;

    // Initializes the database connection
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to retrieve all sections from the database
    public function getSection()
    {
        // SQL query to select all sections
        $request = "SELECT * FROM section";
        $pdo = $this->db->query($request);
        return $pdo->fetchAll(\PDO::FETCH_ASSOC);
    }
}
