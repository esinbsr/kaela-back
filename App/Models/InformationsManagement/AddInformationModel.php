<?php

namespace Models\InformationsManagement;

use App\Database;

class AddInformationModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to add information to the database
    public function addInformation($description, $mobile, $email, $address)
    {
        // SQL query to insert new information
        $request = "INSERT INTO information (description, mobile, email, address) VALUES (?, ?, ?, ?)";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$description, $mobile, $email, $address]);

        /// Return the newly inserted sinformation
        return $this->db->lastInsertId();
    }
}
