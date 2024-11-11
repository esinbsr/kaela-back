<?php

namespace Controllers\CommentsManagement;

use Models\CommentsManagement\AddCommentModel;

class AddCommentController
{
    protected $model;

    // Initializes the model
    public function __construct()
    {
        $this->model = new AddCommentModel();
    }

    // Method to handle the logic for adding a new comment
    public function addComment()
    {
        // Get the input data from the HTTP request and decode the JSON
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Sanitize and validate the input data
        $content = isset($data['content']) ? strip_tags($data['content']) : null;
        $userId = isset($data['userId']) ? strip_tags($data['userId']) : null;
        $productId = isset($data['productId']) ? strip_tags($data['productId']) : null;

        // Check if any required fields are missing
        if (!$content || !$userId || !$productId) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Missing required fields"];
        }

        try {
            // Save the comment using the model
            $commentId = $this->model->addComment($content, $userId, $productId);

            // Fetch the username of the user who added the comment
            $user = $this->model->getUsernameById($userId);
            if (!$user) {
                http_response_code(404); // Not Found
                return ["success" => false, "message" => "User not found"];
            }

            // Return a success response with the comment data
            http_response_code(201); // Created
            return [
                "success" => true,
                "message" => "Comment added successfully.",
                "comment" => [
                    "id" => $commentId,
                    "content" => $content,
                    "user_id" => $userId,
                    "username" => $user['username'],
                    "product_id" => $productId
                ]
            ];
        } catch (\Exception) {
            // Return a failure response
            http_response_code(500); // Internal Server Error
            return ["success" => false, "message" => "Database error"];
        }
    }
}
