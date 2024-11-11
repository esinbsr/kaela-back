<?php

namespace Controllers\CommentsManagement;

use Models\CommentsManagement\DeleteCommentModel;

class DeleteCommentController
{
    protected $model;

    // Constructor to initialize the DeleteCommentModel
    public function __construct()
    {
        $this->model = new DeleteCommentModel();
    }

    // Method to handle the deletion of a comment by a specific user
    public function deleteComment($userId)
    {
        // Retrieve the comment ID from the GET request, sanitizing the input
        $commentId = isset($_GET['commentId']) ? strip_tags($_GET['commentId']) : null;

        // If the comment ID is missing, return a 400 Bad Request response
        if (empty($commentId)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Comment ID is missing"];
        }

        try {
            // Attempt to archive the comment through the model, passing the comment ID and user ID
            $archived = $this->model->archiveComment($commentId, $userId);

            // If archiving is successful, return a 200 OK response
            if ($archived) {
                http_response_code(200); // OK
                return ["success" => true, "message" => "Comment deleted successfully"];
            } else {
                // If the user is unauthorized to archive this comment, return a 404 Not Found response
                http_response_code(404); // Not Found
                return ["success" => false, "message" => "Unauthorized to archive this comment"];
            }
        } catch (\Exception) {
            // If a database error occurs, set the response code to 500 Internal Server Error
            http_response_code(500);
            return ["success" => false, "message" => "Database error"];
        }
    }
}
