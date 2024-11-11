<?php

namespace Models\CommentsManagement;

use App\Database;

class DeleteCommentModel
{
    protected $db;

    // Initializes the database connection
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to archive comment
    public function archiveComment($commentId, $userId)
    {
        $request = "UPDATE comment SET is_archived = 1 WHERE id = ? AND user_id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$commentId, $userId]);

        return $pdo->rowCount() > 0;
    }
}
