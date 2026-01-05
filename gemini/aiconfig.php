<?php
require_once __DIR__ . '/../config/apikeys.php';
// Gemini API configuration file - Set permissions to 600, only allow www-data to read
// Model used (gemini-2.0-flash for v1beta API)
define('GEMINI_MODEL', 'gemini-2.0-flash');

// API Endpoint (using v1beta for gemini-2.0-flash)
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/' . GEMINI_MODEL . ':generateContent');

// Optional: Temperature (0.0-0.3 for more stable output)
define('GEMINI_TEMPERATURE', 0.2);
?>