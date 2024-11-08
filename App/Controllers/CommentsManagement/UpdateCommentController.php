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

    public function getCommentById()
    {
        $commentId = isset($_GET['commentId']) ? strip_tags($_GET['commentId']) : null;

        if (empty($commentId)) {
            return ["success" => false, "message" => "Comment ID is missing"];
        }

        $comment = $this->model->getCommentById($commentId);

        if ($comment) {
            return ["success" => true, "comment" => $comment];
        } else {
            return ["success" => false, "message" => "Comment not found"];
        }
    }

    public function updateComment($userId)
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $commentId = isset($data['id']) ? trim(strip_tags($data['id'])) : null;
        $content = isset($data['content']) ? trim(strip_tags($data['content'])) : null;

        if (empty($commentId) || empty($content)) {
            return ["success" => false, "message" => "All fields must be filled"];
        }

        $existingComment = $this->model->getCommentById($commentId);

        if ($existingComment['content'] === $content) {
            return ["success" => false, "message" => "No changes detected"];
        }
        if ($existingComment['user_id'] != $userId) {
            return ["success" => false, "message" => "Unauthorized to modify this comment"];
        }

        $rowCount = $this->model->updateComment($commentId, $content, $userId);

        if ($rowCount > 0) {
            return [
                "success" => true,
                "message" => "Comment updated successfully",
                "comment" => [
                    'id' => $commentId,
                    'content' => $content
                ]
            ];
        } else {
            return ["success" => false, "message" => "No updates made"];
        }
    }
}
