<?php
require_once __DIR__ . '/aiconfig.php';
//require_once 'dbconfig.php'; // If database is needed

class GeminiBibleParser {
    public static function parsePrompt($userPrompt, $showThinking = true) {
        $url = GEMINI_API_URL;

        // Build system instruction as part of contents (matching official portal format)
        // Check both parameter and config constant (parameter takes precedence)
        $noThinking = !$showThinking || (defined('GEMINI_SHOW_THINKING') && !GEMINI_SHOW_THINKING);
        $systemInstruction = '你是一個聖經查詢解析器。請分析以下用戶輸入，只輸出純 JSON 格式：{"book":"","chapter":"","verse":"","keyword":""}。如果無法解析，返回空 JSON {}。用戶輸入的可能為簡體中文可能為繁體中文也可能是英文甚至可能是三種語言的混合，需要全部都能夠解析。';
        
        if ($noThinking) {
            $systemInstruction .= '絕對不要輸出任何解釋或思考過程。';
        }
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $systemInstruction . "\n用戶輸入：" . $userPrompt]
                    ]
                ]
            ]
        ];

        // Use cURL for better error handling and HTTP support
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-goog-api-key: ' . GEMINI_API_KEY,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($result === false || $httpCode !== 200) {
            $errorMsg = $curlError ?: "HTTP {$httpCode}";
            error_log("Gemini API Error: {$errorMsg}. Response: " . substr($result, 0, 500));
            return [
                'error' => "API request failed: {$errorMsg}",
                'http_code' => $httpCode,
                'response' => $result ? substr($result, 0, 500) : 'No response'
            ];
        }

        $response = json_decode($result, true);
        
        // Check for API errors
        if (isset($response['error'])) {
            error_log("Gemini API Error: " . json_encode($response['error']));
            return ['error' => $response['error']['message'] ?? 'API error'];
        }
        
        // Check if response has expected structure
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            $responseText = $response['candidates'][0]['content']['parts'][0]['text'];
            
            // If thinking is enabled, try to extract thinking and JSON separately
            $thinking = '';
            $jsonText = $responseText;
            
            if ($showThinking) {
                // First, try to find JSON object (may be nested, so use balanced braces)
                // Look for the first { and find its matching }
                $jsonStart = strpos($responseText, '{');
                if ($jsonStart !== false) {
                    // Extract thinking (everything before the JSON)
                    $thinking = trim(substr($responseText, 0, $jsonStart));
                    
                    // Extract JSON (from first { to matching })
                    $braceCount = 0;
                    $jsonEnd = $jsonStart;
                    for ($i = $jsonStart; $i < strlen($responseText); $i++) {
                        if ($responseText[$i] === '{') {
                            $braceCount++;
                        } elseif ($responseText[$i] === '}') {
                            $braceCount--;
                            if ($braceCount === 0) {
                                $jsonEnd = $i + 1;
                                break;
                            }
                        }
                    }
                    $jsonText = substr($responseText, $jsonStart, $jsonEnd - $jsonStart);
                } else {
                    // No JSON found, treat entire response as thinking
                    $thinking = $responseText;
                    $jsonText = '';
                }
                
                // Clean up thinking: remove markdown code block markers if present
                $thinking = preg_replace('/^```json\s*/', '', $thinking);
                $thinking = preg_replace('/^```\s*/', '', $thinking);
                $thinking = trim($thinking);
                
                // Clean up JSON: remove markdown code block markers if present
                $jsonText = preg_replace('/^```json\s*/', '', $jsonText);
                $jsonText = preg_replace('/^```\s*/', '', $jsonText);
                $jsonText = trim($jsonText);
            } else {
                // No thinking: just extract JSON
                // Remove markdown code blocks if present
                $jsonText = preg_replace('/```json\s*/', '', $responseText);
                $jsonText = preg_replace('/```\s*/', '', $jsonText);
                $jsonText = trim($jsonText);
                
                // Try to find JSON object in the text (handle nested braces)
                if (preg_match('/\{[^{}]*(?:\{[^{}]*\}[^{}]*)*\}/', $jsonText, $matches)) {
                    $jsonText = $matches[0];
                }
            }
            
            $parsed = json_decode($jsonText, true);
            if ($parsed !== null && is_array($parsed)) {
                // Add thinking to result if present
                if ($showThinking && !empty($thinking)) {
                    $parsed['thinking'] = $thinking;
                }
                return $parsed;
            } else {
                error_log("Gemini API: Failed to parse JSON from response. JSON text: " . substr($jsonText, 0, 200) . "... Full response: " . substr($responseText, 0, 500));
                return ['error' => 'Failed to parse JSON', 'raw' => $responseText];
            }
        }
        
        // Log unexpected response structure
        error_log("Gemini API: Unexpected response structure: " . json_encode($response));
        return ['error' => 'Unexpected response format', 'response' => $response];
    }
}
?>