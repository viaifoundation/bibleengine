<?php
require_once 'aiconfig.php';
//require_once 'dbconfig.php'; // If database is needed

class GeminiBibleParser {
    public static function parsePrompt($userPrompt) {
        $url = GEMINI_API_URL . '?key=' . GEMINI_API_KEY;

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $userPrompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',  // Force JSON output
                'temperature' => GEMINI_TEMPERATURE,
            ],
            'systemInstruction' => [
                'parts' => [
                    ['text' => 'You are a Bible query parser. Please analyze user input and output only pure JSON format: {"book":"","chapter":"","verse":"","keyword":""}. If unable to parse, return empty JSON {}. Do not output any explanations or thinking process.']
                ]
            ]
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
                'timeout' => 15,
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            return []; // Return empty on error
        }

        $response = json_decode($result, true);
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            $jsonText = $response['candidates'][0]['content']['parts'][0]['text'];
            return json_decode($jsonText, true) ?: [];
        }

        return [];
    }
}
?>