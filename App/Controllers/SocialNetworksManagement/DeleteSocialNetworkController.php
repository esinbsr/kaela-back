<?php

namespace Controllers\SocialNetworksManagement;

use Models\SocialNetworksManagement\DeleteSocialNetworkModel;

class DeleteSocialNetworkController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeleteSocialNetworkModel();
    }

    // Method to handle the deletion of a social network
    public function deleteSocialNetwork()
    {
        // Sanitize and get the social network ID from the HTTP request
        $socialNetworkId = isset($_GET['socialNetworkId']) ? strip_tags($_GET['socialNetworkId']) : null;

        // Check if the ID is missing
        if (empty($socialNetworkId)) {
            http_response_code(400); // Bad request
            return ["success" => false, "message" => "Social network ID is missing"];
        }

        try {
            // Call the model to delete a social network by ID 
            $isDeleted = $this->model->deleteSocialNetwork($socialNetworkId);
            // Check if any row was affected (social network deleted successfully)
            if ($isDeleted > 0) {
                http_response_code(200); // OK
                return ["success" => true, "message" => "Social network deleted successfully."];
                // No rows affected means the social network was not found
            } else {
                http_response_code(404); // Not found
                return ["success" => false, "message" => "Social network not found"];
            }
        } catch (\PDOException) {
            // Catch any database error, set HTTP response code to 500, and return an error message
            http_response_code(500); // Internal server error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
