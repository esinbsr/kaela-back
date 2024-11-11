<?php

namespace Controllers\SocialNetworksManagement;

use Models\SocialNetworksManagement\SocialNetworkModel;

class SocialNetworkController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SocialNetworkModel();
    }

    // Method to retrieve all social networks
    public function getSocialNetworks()
    {
        try {
            // Retrieve social network data from the model
            $socialNetworks = $this->model->getSocialNetwork();
            // Set HTTP response code to 200 OK to indicate a successful request
            http_response_code(200);
            // Return a success response with the retrieved social network data
            return ["success" => true, "socialNetworks" => $socialNetworks];
        } catch (\PDOException) {
            // Return a failure response
            http_response_code(500);

            // Return an error response with a message indicating a database error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
