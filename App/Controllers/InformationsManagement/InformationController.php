<?php

namespace Controllers\InformationsManagement;

use Models\InformationsManagement\InformationModel;

class InformationController
{
    protected $model;

    // Initializes the Information model
    public function __construct()
    {
        $this->model = new InformationModel();
    }

    // Method to get information data
    public function getInformations()
    {
        try {
            // Fetch the informations from the model
            $information = $this->model->getInformations();
            // Set HTTP response code to 200 OK to indicate a successful request
            http_response_code(200);
            // Return the list of informations with a success response
            return ["success" => true, "information" => $information];
        } catch (\PDOException) {
            // Return a failure response
            http_response_code(500);

            // Return an error response with a message indicating a database error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
