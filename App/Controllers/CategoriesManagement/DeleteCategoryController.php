<?php

namespace Controllers\CategoriesManagement;

use Models\CategoriesManagement\DeleteCategoryModel;

class DeleteCategoryController
{
    protected $model;

    // Constructor to initialize the DeleteCategoryModel
    public function __construct()
    {
        $this->model = new DeleteCategoryModel();
    }

    // Method to handle the deletion of a category
    public function deleteCategory()
    {
        // Sanitize and retrieve the category ID from the HTTP request
        $categoryId = isset($_GET['categoryId']) ? strip_tags($_GET['categoryId']) : null;

        // Check if the category ID is missing
        if (empty($categoryId)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Category ID missing"];
        }

        try {
            // Attempt to delete the category by ID using the model
            $isDeleted = $this->model->deleteCategoryById($categoryId);

            // Check if the deletion was successful
            if ($isDeleted > 0) {
                http_response_code(200); // OK
                return ["success" => true, "message" => "Category deleted successfully"];
            } else {
                http_response_code(404); // Not Found
                return ["success" => false, "message" => "Category not found"];
            }
        } catch (\Exception) {
            // If a database error occurs, set the response code to 500 Internal Server Error
            http_response_code(500);
            return ["success" => false, "message" => "Database error"];
        }
    }
}
