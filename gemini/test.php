<?php
/**
 * Gemini Bible Parser Test Script
 * Tests the GeminiBibleParser class with various Bible query inputs
 */

require_once 'parser.php';

// Test cases array
$testCases = [
    // Verse references
    "詩篇 23篇",
    "Psalm 23",
    "John 3:16",
    "約翰福音 3:16",
    "Romans 10:17",
    "羅馬書 10:17",
    
    // Keywords
    "耶穌愛你",
    "Jesus loves you",
    "faith",
    "信心",
    
    // Complex queries
    "馬太福音 5:3-10",
    "Matthew 5:3-10",
    "創世記 1:1",
    "Genesis 1:1",
];

// Output header
echo "<!DOCTYPE html>\n";
echo "<html><head><title>Gemini Bible Parser Test</title>\n";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h1 { color: #333; }
    .test-case { margin: 20px 0; padding: 15px; background: #f5f5f5; border-left: 4px solid #007bff; }
    .input { font-weight: bold; color: #007bff; margin-bottom: 10px; }
    .output { background: #fff; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
    .error { color: #dc3545; }
    .success { color: #28a745; }
    pre { margin: 0; white-space: pre-wrap; word-wrap: break-word; }
</style></head><body>\n";
echo "<h1>Gemini Bible Parser Test Results</h1>\n";
echo "<p>Total test cases: " . count($testCases) . "</p>\n";

// Run tests
$passed = 0;
$failed = 0;

foreach ($testCases as $index => $testInput) {
    echo "<div class='test-case'>\n";
    echo "<div class='input'>Test " . ($index + 1) . ": " . htmlspecialchars($testInput) . "</div>\n";
    
    try {
        $startTime = microtime(true);
        $result = GeminiBibleParser::parsePrompt($testInput);
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2); // milliseconds
        
        echo "<div class='output'>\n";
        echo "<strong>Result:</strong> ";
        
        if (isset($result['error'])) {
            echo "<span class='error'>✗ Error: " . htmlspecialchars($result['error']) . "</span>\n";
            $failed++;
        } elseif (empty($result) || (count($result) == 1 && isset($result['error']))) {
            echo "<span class='error'>Empty result (no parsing possible)</span>\n";
            $failed++;
        } else {
            echo "<span class='success'>✓ Parsed successfully</span>\n";
            $passed++;
        }
        
        echo "<br><strong>Duration:</strong> {$duration}ms\n";
        echo "<br><strong>Output:</strong>\n";
        echo "<pre>" . htmlspecialchars(print_r($result, true)) . "</pre>\n";
        
        // Show raw response if error
        if (isset($result['raw'])) {
            echo "<br><strong>Raw API Response:</strong>\n";
            echo "<pre>" . htmlspecialchars($result['raw']) . "</pre>\n";
        }
        if (isset($result['response'])) {
            echo "<br><strong>Full API Response:</strong>\n";
            echo "<pre>" . htmlspecialchars(print_r($result['response'], true)) . "</pre>\n";
        }
        
        echo "</div>\n";
        
    } catch (Exception $e) {
        echo "<div class='output error'>\n";
        echo "<strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "\n";
        echo "</div>\n";
        $failed++;
    }
    
    echo "</div>\n";
}

// Summary
echo "<div class='test-case' style='background: #e7f3ff; border-left-color: #007bff;'>\n";
echo "<h2>Test Summary</h2>\n";
echo "<p><span class='success'>Passed: {$passed}</span> | <span class='error'>Failed/Empty: {$failed}</span> | Total: " . count($testCases) . "</p>\n";
echo "</div>\n";

echo "</body></html>\n";
?>