<?php

namespace Models\SocialNetworksManagement;

use App\Database;

// Class to handle the retrieval of social network in the admin panel
class SocialNetworkModel
{
    protected $db;

    // Initializes the database connection
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to retrieve all social network from the database
    public function getSocialNetwork()
    {
        // SQL query to select all social network
        $request = "SELECT * FROM social_network";
        $pdo = $this->db->query($request);
        return $pdo->fetchAll(\PDO::FETCH_ASSOC);
    }
}
