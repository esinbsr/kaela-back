<?php

namespace Utils;

use Firebase\JWT\JWT;
use Dotenv\Dotenv;

// This class generates a JWT token
class Token
{
    // Generates a JWT with username, role, and user_id
    public function generateToken($userId, $userRole)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + (7 * 86400); // The token expires after 7 days

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'user_id' => $userId,
            'role' => $userRole,
        ];
        // Generate the JWT token using the secret key
        return JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], 'HS256');
    }
}
