<?php

namespace Controllers\CommentsManagement;

use Models\CommentsManagement\DeleteCommentModel;

class DeleteCommentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeleteCommentModel();
    }

    public function deleteComment($userId)
    {
        $commentId = isset($_GET['commentId']) ? strip_tags($_GET['commentId']) : null;

        if (empty($commentId)) {
            return ["success" => false, "message" => "Comment ID is missing"];
        }

        try {
            $archived = $this->model->archiveComment($commentId, $userId);

            if ($archived) {
                return ["success" => true, "message" => "Comment deleted successfully"];
            } else {
                return ["success" => false, "message" => "Unauthorized to archive this comment"];
            }
        } catch (\Exception $e) {
            return ["success" => false, "message" => "An error occurred: " . $e->getMessage()];
        }
    }
}
