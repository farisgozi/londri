<?php
// Vercel PHP configuration
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Set timezone
date_default_timezone_set('Asia/Jakarta');

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Set content type
header('Content-Type: application/json');

// Load database configuration
require_once __DIR__ . '/config/database.php';

// Function to handle database errors
function handleDatabaseError($conn) {
    return [
        'error' => true,
        'message' => mysqli_error($conn)
    ];
}

// Function to handle successful responses
function handleSuccess($data) {
    return [
        'error' => false,
        'data' => $data
    ];
}

// Function to handle errors
function handleError($message) {
    return [
        'error' => true,
        'message' => $message
    ];
}