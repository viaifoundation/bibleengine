<?php
require_once __DIR__ . '/aiconfig.php';
//require_once 'dbconfig.php'; // If database is needed

class GeminiBibleParser {
    public static function parsePrompt($userPrompt) {
        $url = GEMINI_API_URL . '?key=' . GEMINI_API_KEY;

        // Build system instruction as part of contents
        $systemInstruction = 'You are a Bible query parser. Please analyze user input and output only pure JSON format: {"book":"","chapter":"","verse":"","keyword":""}. If unable to parse, return empty JSON {}. Do not output any explanations or thinking process.';
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $systemInstruction . "\n\nUser query: " . $userPrompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => GEMINI_TEMPERATURE,
            ]
        ];

        // Use cURL for better error handling and HTTP support
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
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
            
            // Try to extract JSON from the response (may contain markdown code blocks or plain text)
            // Remove markdown code blocks if present
            $jsonText = preg_replace('/```json\s*/', '', $responseText);
            $jsonText = preg_replace('/```\s*/', '', $jsonText);
            $jsonText = trim($jsonText);
            
            // Try to find JSON object in the text
            if (preg_match('/\{[^}]+\}/', $jsonText, $matches)) {
                $jsonText = $matches[0];
            }
            
            $parsed = json_decode($jsonText, true);
            if ($parsed !== null && is_array($parsed)) {
                return $parsed;
            } else {
                error_log("Gemini API: Failed to parse JSON from response: " . $responseText);
                return ['error' => 'Failed to parse JSON', 'raw' => $responseText];
            }
        }
        
        // Log unexpected response structure
        error_log("Gemini API: Unexpected response structure: " . json_encode($response));
        return ['error' => 'Unexpected response format', 'response' => $response];
    }
}
?>