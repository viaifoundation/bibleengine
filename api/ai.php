<?php
/**
 * Bible Engine API
 * Clean, modular API endpoint for Bible search and retrieval
 */

declare(strict_types=1);

// Set up error handling early
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Set response headers early
header('Content-Type: application/json; charset=utf-8');

// Wrap everything in try-catch to catch require errors
try {
    // Load dependencies
    require_once(__DIR__ . '/../lang.php');
    require_once(__DIR__ . '/../utils/env_config.php');
    require_once(__DIR__ . '/../utils/db_utils.php');
    require_once(__DIR__ . '/../utils/text_utils.php');
    require_once(__DIR__ . '/../config.php');
    require_once(__DIR__ . '/../common.php');
} catch (Throwable $e) {
    // Catch any errors during require/include
    http_response_code(500);
    error_log("API AI Load Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    echo json_encode([
        'success' => false,
        'error' => 'Failed to load dependencies: ' . $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine(),
        'type' => 'Load Error'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Get request parameters
$query = trim($_REQUEST['q'] ?? '');
$index = trim($_REQUEST['i'] ?? '');
$api_format = strtolower($_REQUEST['api'] ?? 'json'); // json, text, plain, html
$language = strtolower($_REQUEST['l'] ?? 'cn');
$books = $_REQUEST['b'] ?? '';
$multi_verse = (int)($_REQUEST['m'] ?? 0);
$context = (int)($_REQUEST['e'] ?? 0);

// Translation selection
$cuvs = isset($_REQUEST['cuvs']) && $_REQUEST['cuvs'] !== '' && $_REQUEST['cuvs'] !== '0' ? 'cuvs' : '';
$cuvt = isset($_REQUEST['cuvt']) && $_REQUEST['cuvt'] !== '' && $_REQUEST['cuvt'] !== '0' ? 'cuvt' : '';
$kjv = isset($_REQUEST['kjv']) && $_REQUEST['kjv'] !== '' && $_REQUEST['kjv'] !== '0' ? 'kjv' : '';
$nasb = isset($_REQUEST['nasb']) ? 'nasb' : '';
$esv = isset($_REQUEST['esv']) ? 'esv' : '';
$strongs = isset($_REQUEST['strongs']) ? true : false;

$bible_books = array_filter([$cuvs, $cuvt, $kjv, $nasb, $esv]);

try {
    // Get database connection
    $db = getDbConnection();
    
    // Process query or index
    $results = [];
    
    if ($index) {
        // Process index (verse references)
        $verses = explode(',', $index);
        foreach ($verses as $verse_ref) {
            [$book_id, $chapter, $verse] = array_pad(explode(':', $verse_ref), 3, 0);
            // TODO: Build SQL query to fetch verses
            // This is a simplified version - full implementation needed
        }
    } elseif ($query) {
        // Process search query
        // TODO: Implement AI search logic
        // For now, return a placeholder response
        $results = [
            [
                'reference' => 'AI Search',
                'text' => 'AI search functionality is under development. Your query: ' . htmlspecialchars($query)
            ]
        ];
    } else {
        // No query provided
        $results = [];
    }
    
    // Format response based on API format
    switch ($api_format) {
        case 'json':
            echo json_encode([
                'success' => true,
                'data' => $results,
                'count' => count($results),
                'query' => $query
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
            
        case 'text':
        case 'plain':
            foreach ($results as $result) {
                echo ($result['reference'] ?? '') . ': ' . ($result['text'] ?? '') . "\n";
            }
            break;
            
        case 'html':
            foreach ($results as $result) {
                echo "<p><strong>" . htmlspecialchars($result['reference'] ?? '') . "</strong>: " . htmlspecialchars($result['text'] ?? '') . "</p>\n";
            }
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'error' => 'Invalid API format. Use: json, text, plain, or html'
            ], JSON_UNESCAPED_UNICODE);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    // Log the error
    error_log("API AI Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ], JSON_UNESCAPED_UNICODE);
} catch (Error $e) {
    // Catch fatal errors (PHP 7+)
    http_response_code(500);
    error_log("API AI Fatal Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine(),
        'type' => 'Fatal Error'
    ], JSON_UNESCAPED_UNICODE);
}

