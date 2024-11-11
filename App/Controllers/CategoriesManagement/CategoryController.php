<?php

namespace Controllers\CategoriesManagement;

use Models\CategoriesManagement\CategoryModel;

class CategoryController
{
    protected $model;

    // Constructor to initialize the CategoryModel
    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    // Method to handle the retrieval of all categories
    public function getCategories()
    {
        try {
            // Fetch the categories from the model
            $categories = $this->model->getCategories();

            // Set HTTP response code to 200 OK indicating a successful request
            http_response_code(200);

            // Return the list of categories with a success response
            return ["success" => true, "category" => $categories];
        } catch (\Exception) {
            // Set HTTP response code to 500 Internal Server Error in case of a database error
            http_response_code(500);

            // Return an error response with a message indicating a database error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
