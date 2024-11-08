<?php

namespace Models\CommentsManagement;

use App\Database;

class UpdateCommentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getCommentById($commentId)
    {
        $request = "SELECT * FROM comment WHERE id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$commentId]);
        return $pdo->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateComment($commentId, $content, $userId)
    {
        $request = "UPDATE comment SET content = ? WHERE id = ? AND user_id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$content, $commentId, $userId]);

        return $pdo->rowCount();
    }
}
