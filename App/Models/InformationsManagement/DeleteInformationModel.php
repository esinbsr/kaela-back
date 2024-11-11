<?php

namespace Models\InformationsManagement;

use App\Database;

class DeleteInformationModel
{
    protected $db;

    // Initializes the database connection
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    // Method to delete information by its ID
    public function deleteInformationById($informationId)
    {
        // SQL query to delete the information by its ID
        $request = "DELETE FROM information WHERE id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$informationId]);

        return $pdo->rowCount(); // Return the number of affected rows
    }
}
