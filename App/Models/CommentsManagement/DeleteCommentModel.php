<?php

namespace Models\CommentsManagement;

use App\Database;

class DeleteCommentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Méthode pour archiver un commentaire
    public function archiveComment($commentId, $userId)
    {
        try {
            $request = "UPDATE comment SET is_archived = 1 WHERE id = ? AND user_id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$commentId, $userId]);
            
            return $pdo->rowCount() > 0;
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
}
