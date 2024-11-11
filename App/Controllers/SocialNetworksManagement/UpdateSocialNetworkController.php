<?php

namespace Controllers\SocialNetworksManagement;

use Models\SocialNetworksManagement\UpdateSocialNetworkModel;

class UpdateSocialNetworkController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpdateSocialNetworkModel();
    }

    // Method to retrieve a social network by ID
    public function getSocialNetworkById()
    {
        // Check if id is present in the GET request parameters
        $socialNetworkId = isset($_GET['socialNetworkId']) ? strip_tags($_GET['socialNetworkId']) : null;

        // Validate input
        if (empty($socialNetworkId)) {
            http_response_code(400); // Bad request
            return ["success" => false, "message" => "Social network ID is missing"];
        }

        try {
            // Call the model to retrieve the id
            $socialNetwork = $this->model->getSocialNetworkById($socialNetworkId);

            if ($socialNetwork) {
                return ["success" => true, "socialNetwork" => $socialNetwork];
            } else {
                return ["success" => false, "message" => "Social network not found"];
            }
        } catch (\PDOException) {
            // Return a failure response 
            http_response_code(500); // Internal server error
            return ["success" => false, "message" => "Database error"];
        }
    }

    // Method to handle the update of a social network
    public function updateSocialNetwork()
    {
        // Get the input data from the request body (JSON format)
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Sanitize and validate the input fields
        $socialNetworkId = isset($data['id']) ? trim(strip_tags($data['id'])) : null;
        $platform = isset($data['platform']) ? trim(strip_tags($data['platform'])) : null;
        $url = isset($data['url']) ? trim(strip_tags($data['url'])) : null;

        // Validate input
        if (empty($socialNetworkId) || empty($platform) || empty($url)) {
            http_response_code(400); // Bad request
            return ["success" => false, "message" => "All fields must be filled"];
        }

        // Check if the URL is valid
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            http_response_code(400); // Bad request
            return ["success" => false, "message" => "Invalid URL"];
        }

        // Fetch the existing social network data
        $existingSocialNetwork = $this->model->getSocialNetworkById($socialNetworkId);

        // Check if the social network exists
        if (!$existingSocialNetwork) {
            http_response_code(404); // Not Found
            return ["success" => false, "message" => "Social network not found"];
        }

        if (
            $platform == $existingSocialNetwork['platform'] &&
            $url == $existingSocialNetwork['url']
        ) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "No changes detected"];
        }

        try {
            // Update the social network using the model
            $rowCount = $this->model->updateSocialNetwork($socialNetworkId, $platform, $url);

            // Send updated data back if a row was affected
            if ($rowCount > 0) {
                http_response_code(200); // OK
                return [
                    "success" => true,
                    "message" => "Social network updated successfully",
                ];
            } else {
                http_response_code(400); // Bad Request 
                return ["success" => false, "message" => "No updates made"];
            }
        } catch (\PDOException) {
            // Return a failure response 
            http_response_code(500); // Internal server error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
