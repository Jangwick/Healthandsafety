<?php

declare(strict_types=1);

namespace App\Services;

use Exception;

class GeminiService
{
    private string $apiKey;
    private string $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent";

    public function __construct()
    {
        $this->apiKey = $_ENV['GEMINI_API_KEY'] ?? '';
    }

    public function predictRisk(array $establishmentData, array $history): string
    {
        if (empty($this->apiKey)) return "Predictive scoring unavailable (API Key missing)";

        $prompt = "Analyze the following business for Health & Safety risk. 
                  Business Info: " . json_encode($establishmentData) . "
                  History: " . json_encode($history) . "
                  Provide a risk score from 1-100 and a short reason.";

        return $this->callGemini($prompt);
    }

    public function analyzeHazard(string $imagePath): string
    {
        if (empty($this->apiKey)) return "Hazard detection unavailable (API Key missing)";

        // For actual implementation, image would be base64 encoded and sent in the payload
        // This is a placeholder for the logic structure
        $prompt = "Analyze this inspection photo for safety hazards. [Image attached]";
        
        return "AI analysis would go here. (Integration requires base64 image payload)";
    }

    private function callGemini(string $prompt): string
    {
        $data = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($this->apiUrl . "?key=" . $this->apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return "API Error: " . $err;
        }

        $result = json_decode($response, true);
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? "Unable to get AI response";
    }
}
