<?php

namespace Controllers\InformationsManagement;

use Models\InformationsManagement\UpdateInformationModel;

class UpdateInformationController
{
    protected $model;

    // Initializes the UpdateInformationModel
    public function __construct()
    {
        $this->model = new UpdateInformationModel();
    }

    // Method to get information by ID
    public function getInformationById()
    {
        // Retrieve and sanitize information ID
        $informationId = isset($_GET['informationId']) ? strip_tags($_GET['informationId']) : null;

        if (empty($informationId)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Information ID missing"];
        }

        try {
            // Fetch the information by ID using the model
            $information = $this->model->getInformationById($informationId);

            if ($information) {
                http_response_code(200); // OK
                return ["success" => true, "information" => $information];
            } else {
                http_response_code(404); // Not Found
                return ["success" => false, "message" => "Information not found"];
            }
        } catch (\PDOException $e) {
            http_response_code(500); // Internal Server Error
            return ["success" => false, "message" => "Database error"];
        }
    }

    // Method to handle updating information
    public function updateInformation()
    {
        // Retrieve and decode input data from JSON
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Sanitize and retrieve the information details from input data
        $informationId = isset($data['id']) ? strip_tags($data['id']) : null;
        $description = isset($data['description']) ? trim(strip_tags($data['description'])) : null;
        $mobile = isset($data['mobile']) ? trim(strip_tags($data['mobile'])) : null;
        $email = isset($data['email']) ? filter_var($data['email'], FILTER_SANITIZE_EMAIL) : null;
        $address = isset($data['address']) ? trim(strip_tags($data['address'])) : null;

        // Ensure information ID and at least one other field is provided
        if (empty($informationId) || (empty($description) && empty($mobile) && empty($email) && empty($address))) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Information ID and at least one field must be filled"];
        }

        // Validate email format if provided
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Invalid email format"];
        }

        // Validate mobile number format if provided
        if (!empty($mobile) && !preg_match('/^\+?[0-9]*$/', $mobile)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Invalid mobile number format"];
        }

        // Check if information exists in the database
        $existingInformation = $this->model->getInformationById($informationId);

        if (!$existingInformation) {
            http_response_code(404); // Not Found
            return ["success" => false, "message" => "Information not found"];
        }

        // Check if any updates are needed
        if (
            $description === $existingInformation['description'] &&
            $mobile === $existingInformation['mobile'] &&
            $email === $existingInformation['email'] &&
            $address === $existingInformation['address']
        ) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "No changes detected"];
        }

        try {
            // Update the information in the model
            $rowCount = $this->model->updateInformation($informationId, $description, $mobile, $email, $address);

            if ($rowCount > 0) {
                http_response_code(200); // OK
                return [
                    "success" => true,
                    "message" => "Information updated successfully",
                ];
            } else {
                http_response_code(400); // No updates made
                return ["success" => false, "message" => "No updates made"];
            }
        } catch (\PDOException) {
            http_response_code(500); // Internal Server Error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
