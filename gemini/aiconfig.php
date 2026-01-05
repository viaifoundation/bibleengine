<?php
require_once __DIR__ . '/apikeys.php';
// Gemini API configuration file - Set permissions to 600, only allow www-data to read
// Model used (recommended Flash, free and fast)
define('GEMINI_MODEL', 'gemini-1.5-flash');

// API Endpoint
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1/models/' . GEMINI_MODEL . ':generateContent');

// Optional: Temperature (0.0-0.3 for more stable output)
define('GEMINI_TEMPERATURE', 0.2);
?>