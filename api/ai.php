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
    require_once(__DIR__ . '/../utils/book_utils.php');
    require_once(__DIR__ . '/../gemini/parser.php');
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
        // Get show thinking flag (default: true/enabled)
        $show_thinking = isset($_REQUEST['show_thinking']) && $_REQUEST['show_thinking'] !== '' && $_REQUEST['show_thinking'] !== '0';
        
        // Use Gemini to parse the query
        $parsed = GeminiBibleParser::parsePrompt($query, $show_thinking);
        
        if (isset($parsed['error'])) {
            // Gemini parsing failed, return error
            $results = [
                [
                    'reference' => 'AI Parse Error',
                    'text' => 'Failed to parse query: ' . $parsed['error']
                ]
            ];
        } elseif (!empty($parsed['book']) && !empty($parsed['chapter'])) {
            // Verse reference case: book + chapter (and optionally verse)
            global $book_index, $book_short;
            require_once(__DIR__ . '/../utils/book_utils.php');
            
            // Find book ID from book name
            $book_name = trim($parsed['book']);
            $book_id = getBookId($book_name); // Use utility function
            
            // If not found, try fuzzy matching
            if (!$book_id) {
                $book_name_lower = strtolower($book_name);
                // Try exact match in book_index
                foreach ($book_index as $book_key => $id) {
                    if (strtolower($book_key) === $book_name_lower || 
                        strtolower(str_replace(' ', '', $book_key)) === str_replace(' ', '', $book_name_lower)) {
                        $book_id = $id;
                        break;
                    }
                }
                
                // Try book_short array
                if (!$book_id) {
                    global $book_short;
                    for ($i = 1; $i <= 66; $i++) {
                        if (isset($book_short[$i]) && strtolower($book_short[$i]) === $book_name_lower) {
                            $book_id = $i;
                            break;
                        }
                    }
                }
                
                // Try book_english array
                if (!$book_id) {
                    global $book_english;
                    for ($i = 1; $i <= 66; $i++) {
                        if (isset($book_english[$i]) && strtolower($book_english[$i]) === $book_name_lower) {
                            $book_id = $i;
                            break;
                        }
                    }
                }
            }
            
            if ($book_id > 0) {
                // Build query string: "booknamechapter:verse" (e.g., "john3:16")
                $book_short_name = strtolower($book_short[$book_id] ?? '');
                $chapter = (int)$parsed['chapter'];
                $verse = !empty($parsed['verse']) ? (int)$parsed['verse'] : 0;
                
                if ($verse > 0) {
                    $generated_query = $book_short_name . $chapter . ':' . $verse;
                } else {
                    $generated_query = $book_short_name . $chapter;
                }
                
                // Use the generated query for search
                $query = $generated_query;
                $results = [
                    [
                        'reference' => 'AI Parsed',
                        'text' => 'Parsed query: ' . htmlspecialchars($generated_query) . ' (from: ' . htmlspecialchars($query) . ')',
                        'parsed' => $parsed,
                        'generated_query' => $generated_query
                    ]
                ];
            } else {
                $results = [
                    [
                        'reference' => 'AI Parse Error',
                        'text' => 'Could not find book: ' . htmlspecialchars($parsed['book'])
                    ]
                ];
            }
        } elseif (!empty($parsed['keyword'])) {
            // Keyword search case
            $generated_query = trim($parsed['keyword']);
            $query = $generated_query;
            $results = [
                [
                    'reference' => 'AI Parsed',
                    'text' => 'Parsed keyword: ' . htmlspecialchars($generated_query),
                    'parsed' => $parsed,
                    'generated_query' => $generated_query
                ]
            ];
        } else {
            // Empty or invalid parse result
            $results = [
                [
                    'reference' => 'AI Parse',
                    'text' => 'Could not parse query. Please try a verse reference (e.g., "John 3:16") or a keyword.',
                    'parsed' => $parsed
                ]
            ];
        }
    } else {
        // No query provided
        $results = [];
    }
    
    // Get thinking from parsed result if available
    $thinking = null;
    if (isset($parsed['thinking'])) {
        $thinking = $parsed['thinking'];
    }
    
    // Format response based on API format
    switch ($api_format) {
        case 'json':
            $response = [
                'success' => true,
                'data' => $results,
                'count' => count($results),
                'query' => $query
            ];
            if ($thinking !== null) {
                $response['thinking'] = $thinking;
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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

