<?php

// Set headers to allow cross-origin requests and define which headers and methods are permitted
header("Access-Control-Allow-Origin: http://localhost:5173"); // Allows requests from any origin
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specifies which headers are allowed in requests
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE"); // Lists the HTTP methods allowed
header("Content-Type: application/json"); // Sets the content type of the response to JSON
header("X-Content-Type-Options: nosniff"); // Prevents browsers from MIME-sniffing a response away from the declared content type
header("X-Frame-Options: DENY"); // Blocks the page from being displayed in an iframe
header("Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'none'; frame-ancestors 'none'; base-uri 'self';"); // CSP to control resources loaded by the page

// If the request is an OPTIONS preflight request (for CORS), send a 200 response and exit
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Define a constant for the image directory path
const IMG = "assets/img/";

// Route requests to the router if the request method is allowed (GET, POST, PUT, DELETE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    require_once "router.php";
} else {
    // If the request method is not allowed, send a 405 Method Not Allowed response
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit();
}
