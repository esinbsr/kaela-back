<?php

require_once 'vendor/autoload.php'; // Load Composer's autoloader for dependencies

use Dotenv\Dotenv;

// Initialize and load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Include route files for different resources
require_once 'routes/productRoutes.php';
require_once 'routes/categoryRoutes.php';
require_once 'routes/informationRoutes.php';
require_once 'routes/socialNetworkRoutes.php';
require_once 'routes/sectionRoutes.php';

use Controllers\CommentsManagement\AddCommentController;
use Controllers\CommentsManagement\CommentController;
use Controllers\CommentsManagement\DeleteCommentController;
use Controllers\CommentsManagement\UpdateCommentController;
use Controllers\ContactController;
use Controllers\LoginController;
use Controllers\SignupController;
use Utils\AuthUtils;

// Initialize the authentication middleware
$authMiddleware = new AuthUtils();

// Instantiate controllers for handling different user actions
$signup = new SignupController();
$login = new LoginController();
$contact = new ContactController();
$comment = new CommentController();
$addComment = new AddCommentController();
$updateComment = new UpdateCommentController();
$deleteComment = new DeleteCommentController();
$action = $_REQUEST['action'] ?? null; // Get the action from request parameters
$response = ["success" => false, "message" => "Action not found"]; // Default response for unrecognized actions

// Management of non-admin actions based on the provided action parameter
switch ($action) {
    case "signup":
        $response = $signup->signup();
        break;

    case "login":
        $response = $login->login();
        break;

    case "contact":
        $response = $contact->sendEmail();
        break;

    case "getCommentsByProduct":
        $productId = $_REQUEST['productDetailId'] ?? null;
        if ($productId) {
            $response = $comment->getCommentsByProduct($productId);
        } else {
            $response = ["success" => false, "message" => "Product ID not provided"];
        }
        break;

    case "addComment":
        $response = $addComment->addComment();
        break;

    case "updateComment":
        $userId = $authMiddleware->getUserIdFromToken();
        $response = $updateComment->updateComment($userId);
        break;

    case "deleteComment":
        $userId = $authMiddleware->getUserIdFromToken();
        $response = $deleteComment->deleteComment($userId);
        break;

        // Handling admin actions if a specific admin action is requested
    default:
        $adminAction = $_REQUEST['adminAction'] ?? null;

        if ($adminAction) {
            // Use the first matching route's response or `null` if no match
            $response = productRoutes($adminAction, $authMiddleware) ??
                categoryRoutes($adminAction, $authMiddleware) ??
                informationRoutes($adminAction, $authMiddleware) ??
                socialNetworkRoutes($adminAction, $authMiddleware) ??
                sectionRoutes($adminAction);
        }
        break;
}

// Return the response as JSON to the client
echo json_encode($response);
