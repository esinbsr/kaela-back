<?php

namespace Controllers\CategoriesManagement;

use Models\CategoriesManagement\UpdateCategoryModel;

class UpdateCategoryController
{
    protected $model;

    // Initializes the model
    public function __construct()
    {
        $this->model = new UpdateCategoryModel();
    }

    // Method to retrieve a category by ID
    public function getCategoryById()
    {
        // Check if ID is present in the GET request parameters
        $categoryId = isset($_GET['categoryId']) ? strip_tags($_GET['categoryId']) : null;

        // Validate input
        if (empty($categoryId)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Category ID is missing"];
        }

        try {
            // Fetch category data from the model
            $category = $this->model->getCategoryById($categoryId);

            if ($category) {
                http_response_code(200); // OK
                return ["success" => true, "category" => $category];
            } else {
                http_response_code(404); // Not Found
                return ["success" => false, "message" => "Category not found"];
            }
        } catch (\PDOException) {
            // Return a failure response for database errors
            http_response_code(500); // Internal Server Error
            return ["success" => false, "message" => "Database error"];
        }
    }

    // Method to handle the update of a category
    public function updateCategory()
    {
        // Retrieve data from the HTTP request body (JSON format)
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Sanitize and validate the input fields
        $categoryId = isset($data['id']) ? trim(strip_tags($data['id'])) : null;
        $categoryName = isset($data['name']) ? trim(strip_tags($data['name'])) : null;
        $categoryDescription = isset($data['description']) ? trim(strip_tags($data['description'])) : null;
        $categoryPageTitle = isset($data['page_title']) ? trim(strip_tags($data['page_title'])) : null;
        $categoryPageDescription = isset($data['page_description']) ? trim(strip_tags($data['page_description'])) : null;

        // Check if any required fields are missing
        if (empty($categoryId) || empty($categoryName) || empty($categoryDescription) || empty($categoryPageTitle) || empty($categoryPageDescription)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "All fields must be filled"];
        }

        // Fetch the existing category data
        $existingCategory = $this->model->getCategoryById($categoryId);

        // Check if the category exists
        if (!$existingCategory) {
            http_response_code(404); // Not Found
            return ["success" => false, "message" => "Category not found"];
        }

        // Check if any changes were made
        if (
            $categoryName === $existingCategory['name'] &&
            $categoryDescription === $existingCategory['description'] &&
            $categoryPageTitle === $existingCategory['page_title'] &&
            $categoryPageDescription === $existingCategory['page_description']
        ) {
            return ["success" => false, "message" => "No changes detected"];
        }

        // Check if the new category name already exists
        if ($this->model->nameExist($categoryName, $categoryId)) {
            http_response_code(409); // Conflict
            return ["success" => false, "message" => "This name is already used"];
        }

        try {
            // Update the category in the model
            $rowCount = $this->model->updateCategory($categoryId, $categoryName, $categoryDescription, $categoryPageTitle, $categoryPageDescription);

            // Check if the update was successful
            if ($rowCount > 0) {
                http_response_code(200); // OK
                return [
                    "success" => true,
                    "message" => "Category updated successfully.",
                    "categoryUpdate" => [
                        'id' => $categoryId,
                        'name' => $categoryName,
                        'description' => $categoryDescription,
                        'page_title' => $categoryPageTitle,
                        'page_description' => $categoryPageDescription,
                    ]
                ];
            } else {
                http_response_code(400); // Bad Request for no changes or update 
                return ["success" => false, "message" => "No updates made"];
            }
        } catch (\PDOException) {
            // Return a failure response for database errors
            http_response_code(500); // Internal Server Error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
