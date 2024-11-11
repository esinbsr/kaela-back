<?php

namespace Controllers\CommentsManagement;

use Models\CommentsManagement\UpdateCommentModel;

class UpdateCommentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpdateCommentModel();
    }

    public function updateComment($userId)
    {
        // Retrieve data from the HTTP request body (JSON format)
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Sanitize and validate the input fields
        $commentId = isset($data['id']) ? trim(strip_tags($data['id'])) : null;
        $content = isset($data['content']) ? trim(strip_tags($data['content'])) : null;

        // Check if any required fields are missing
        if (empty($commentId) || empty($content)) {
            return ["success" => false, "message" => "All fields must be filled"];
        }
        // Fetch the existing comment data
        $existingComment = $this->model->getCommentById($commentId);

        if (!$existingComment) {
            http_response_code(404); // Not Found
            return ["success" => false, "message" => "Comment not found"];
        }

        if ($content === $existingComment['content']) {
            return ["success" => false, "message" => "No changes detected"];
        }
        if ($existingComment['user_id'] != $userId) {
            return ["success" => false, "message" => "Unauthorized to modify this comment"];
        }

        try {
            // Update the comment in the model
            $rowCount = $this->model->updateComment($commentId, $content, $userId);

            // Check if the update was successful
            if ($rowCount > 0) {
                http_response_code(200); // OK
                return [
                    "success" => true,
                    "message" => "Comment updated successfully.",
                    "comment" => [
                        'id' => $commentId,
                        'content' => $content
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
