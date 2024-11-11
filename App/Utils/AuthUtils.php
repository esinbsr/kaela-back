<?php

namespace Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// This class handles user authentication and role-based access control using JWT tokens
// Cette classe gère l'authentification des utilisateurs et le contrôle d'accès basé sur les rôles en utilisant des tokens JWT
class AuthUtils
{
    // Extracts the JWT token from the 'Authorization' header of the HTTP request
    // Returns the token without the 'Bearer' prefix or null if the token is not present
    // Extrait le token JWT de l'en-tête 'Authorization' de la requête HTTP
    // Retourne le token sans le préfixe 'Bearer' ou null si le token n'est pas présent
    public function extractTokenFromHeaders()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            return str_replace('Bearer ', '', $headers['Authorization']);
        }
        return null;
    }

    // Retrieves the user ID from the JWT token if it's valid and not expired
    // Récupère l'ID de l'utilisateur depuis le token JWT s'il est valide et non expiré
    public function getUserIdFromToken()
    {
        $token = $this->extractTokenFromHeaders();

        // If no token is found, return a 401 Unauthorized response
        // Si aucun token n'est trouvé, retourne une réponse 401 Unauthorized
        if (!$token) {
            http_response_code(401);
            throw new \Exception("Unauthorised access: No token provided.");
        }

        try {
            // Decodes the JWT token using the secret key from the environment variables
            // Décode le token JWT en utilisant la clé secrète des variables d'environnement
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET_KEY'], 'HS256'));

            // Checks if the token has expired. If expired, return a 401 Unauthorized response
            // Vérifie si le token a expiré. Si expiré, retourne une réponse 401 Unauthorized
            if ($decoded->exp < time()) {
                http_response_code(401);
                throw new \Exception("Token expired.");
            }

            // Returns the user ID from the token
            // Retourne l'ID utilisateur depuis le token
            return $decoded->user_id;
        } catch (\Exception) {
            // If any error occurs during token decoding, return a 401 Unauthorized response
            // Si une erreur survient lors du décodage du token, retourne une réponse 401 Unauthorized
            http_response_code(401);
            throw new \Exception("Invalid or unauthorised token.");
        }
    }

    // Checks the user's access to a specific route according to their role and validates the JWT token
    // Vérifie l'accès de l'utilisateur à une route spécifique selon son rôle et valide le token JWT
    public function verifyAccess($requiredRole = 'admin')
    {
        $token = $this->extractTokenFromHeaders();

        // If no token is found, return a 401 Unauthorized response
        // Si aucun token n'est trouvé, retourne une réponse 401 Unauthorized
        if (!$token) {
            http_response_code(401);
            return ["success" => false, "message" => "Unauthorised access."];
        }

        try {
            // Decodes the JWT token using the secret key from the environment variables
            // Décode le token JWT en utilisant la clé secrète des variables d'environnement
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET_KEY'], 'HS256'));

            // Checks if the token has expired. If expired, return a 401 Unauthorized response
            // Vérifie si le token a expiré. Si expiré, retourne une réponse 401 Unauthorized
            if ($decoded->exp < time()) {
                http_response_code(401);
                return ["success" => false, "message" => "Token expired."];
            }

            // Retrieves the user role from the token and checks if it matches the required role
            // Récupère le rôle utilisateur depuis le token et vérifie s'il correspond au rôle requis
            if (strtolower($decoded->role) !== strtolower($requiredRole)) {
                http_response_code(403);
                return ["success" => false, "message" => "Insufficient rights."];
            }

            return null; // Access granted, no error returned
            // Accès accordé, aucune erreur retournée
        } catch (\Exception) {
            // If any error occurs during token decoding, return a 401 Unauthorized response
            // Si une erreur survient lors du décodage du token, retourne une réponse 401 Unauthorized
            http_response_code(401);
            return ["success" => false, "message" => "Invalid or unauthorised token."];
        }
    }
}
