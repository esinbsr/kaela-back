<?php

namespace Controllers;

use Models\LoginModel;
use Utils\Token;

class LoginController
{
    protected $model;
    protected $token;

    public function __construct()
    {
        $this->model = new LoginModel();
        $this->token = new Token();
    }

    // Method to handle the user login process
    public function login()
    {
        // Retrieve input data (JSON format)
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Sanitize and validate the email and password fields
        $email = isset($data['email']) ? filter_var($data['email'], FILTER_SANITIZE_EMAIL) : null;
        $password = isset($data['password']) ? strip_tags($data['password']) : null;

        // Check if email or password is missing
        if (empty($email) || empty($password)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "All fields are required."];
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Invalid email format."];
        }

        try {
            // Retrieve the user via the model
            $user = $this->model->getUserByEmail($email);

            // Verify password and check if the user exists
            if ($user && password_verify($password, $user['password'])) {
                // If credentials are valid, generate a JWT token with only user_id and role
                $token = $this->token->generateToken($user['id'], $user['role']);

                // Return a success response with the JWT token and minimal info
                http_response_code(200); // OK
                return [
                    "success" => true,
                    "message" => "Login successful.",
                    "role" => $user['role'],
                    "user_id" => $user['id'],
                    "token" => $token
                ];
            } else {
                // Return an error if credentials are invalid
                http_response_code(401); // Unauthorized
                return ["success" => false, "message" => "Invalid credentials."];
            }
        } catch (\PDOException) {
            // Handle database errors
            http_response_code(500); // Internal Server Error
            return ["success" => false, "message" => "Database error."];
        }
    }
}
