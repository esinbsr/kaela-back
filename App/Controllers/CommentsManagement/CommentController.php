<?php

namespace Controllers\CommentsManagement;

use Models\CommentsManagement\CommentModel;

class CommentController
{
    protected $model;

    // Initializes the model
    public function __construct()
    {
        $this->model = new CommentModel();
    }

    // Method to handle the retrieval of comments for a specific product
    public function getCommentsByProduct($productId)
    {
        // Validate the product ID
        if (empty($productId)) {
            return ["success" => false, "message" => "Product ID is missing"];
        }

        try {
            // Fetch the comments using the model
            $comments = $this->model->getCommentsByProduct($productId);

            // Set HTTP response code to 200 OK to indicate a successful request
            http_response_code(200);
            // Return a success response with the comments
            return ["success" => true, "comments" => $comments];
        } catch (\PDOException) {
            // Return a failure response
            http_response_code(500);

            // Return an error response with a message indicating a database error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
