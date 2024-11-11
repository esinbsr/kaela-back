<?php

namespace Controllers\SectionsManagement;

use Models\SectionsManagement\SectionModel;

class SectionController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SectionModel();
    }

    public function getSections()
    {
        try {
            // Retrieve section data from the model
            $section =  $this->model->getSection();
            // Set HTTP response code to 200 OK to indicate a successful request
            http_response_code(200);
            return ["success" => true, "section" => $section];
        } catch (\PDOException) {
            // Return a failure response
            http_response_code(500);

            // Return an error response with a message indicating a database error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
