<?php

namespace Models\CommentsManagement;

use App\Database;

// Class responsible for handling the update of comment
class UpdateCommentModel
{
    protected $db;

    // Initializes the database connection
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to retrieve a comment entry by its ID
    public function getCommentById($commentId)
    {
        $request = "SELECT * FROM comment WHERE id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$commentId]);
        return $pdo->fetch(\PDO::FETCH_ASSOC);
    }

    // Method to update a comment entry
    public function updateComment($commentId, $content, $userId)
    {
        // Sql request to update data
        $request = "UPDATE comment SET content = ? WHERE id = ? AND user_id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$content, $commentId, $userId]);

        return $pdo->rowCount(); // Return the number of affected rows
    }
}
