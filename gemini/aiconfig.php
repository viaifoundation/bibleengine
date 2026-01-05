<?php
require_once __DIR__ . '/../config/apikeys.php';
// Gemini API configuration file - Set permissions to 600, only allow www-data to read
// Model used (gemini-pro for v1 API, or gemini-1.5-pro/gemini-1.5-flash for v1beta)
// For v1 API, use: gemini-pro
// For v1beta API, use: gemini-1.5-pro or gemini-1.5-flash
define('GEMINI_MODEL', 'gemini-pro');

// API Endpoint
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1/models/' . GEMINI_MODEL . ':generateContent');

// Optional: Temperature (0.0-0.3 for more stable output)
define('GEMINI_TEMPERATURE', 0.2);
?>