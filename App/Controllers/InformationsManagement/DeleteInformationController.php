<?php

namespace Controllers\InformationsManagement;

use Models\InformationsManagement\DeleteInformationModel;

class DeleteInformationController
{
    protected $model;

    // Initializes the model
    public function __construct()
    {
        $this->model = new DeleteInformationModel();
    }

    // Method to handle the deletion of information
    public function deleteInformation()
    {
        // Sanitize and get the social network ID from the HTTP request
        $informationId = isset($_GET['informationId']) ? strip_tags($_GET['informationId']) : null;

        // Check if the ID is missing
        if (empty($informationId)) {
            http_response_code(400); // Bad request
            return ["success" => false, "message" => "Information ID missing"];
        }

        try {
            // Calls the model to delete the information by its ID
            $rowCount = $this->model->deleteInformationById($informationId);

            // Returns a response based on the success or failure of the deletion
            if ($rowCount > 0) {
                return ["success" => true, "message" => "Information deleted successfully."];
                // No rows affected means the information was not found
            } else {
                http_response_code(404); // Not found
                return ["success" => false, "message" => "Information not found"];
            }
        } catch (\Exception) {
            // Handles errors and returns a failure response
            http_response_code(500);
            return ["success" => false, "message" => "Database error"];
        }
    }
}
