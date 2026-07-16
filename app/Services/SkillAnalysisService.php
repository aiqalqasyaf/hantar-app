<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SkillAnalysisService
{
    public function analyze(string $jobDescription, string $resumeText): array
    {
        $prompt = <<<PROMPT
You are a technical recruiter. Compare the resume against the job description and respond ONLY with valid JSON, no markdown fences, no preamble.

Job Description:
{$jobDescription}

Resume:
{$resumeText}

Return JSON in this exact shape:
{
"score": <integer 0-100>,
"matched_skills": ["skill1", "skill2"],
"missing_skills": ["skill1", "skill2"],
"recommendations": ["actionable recommendation 1", "actionable recommendation 2", "actionable recommendation 3"],
"summary": "one or two sentence overview"
}
PROMPT;

        $response = Http::withHeaders([
            'x-api-key' => config('services.anthropic.key'),
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model' => 'claude-haiku-4-5',
            'max_tokens' => 512,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $text = $response->json('content.0.text');
        $clean = trim(preg_replace('/```json|```/', '', $text));

        $result = json_decode($clean, true);

        if (!$result) {
            throw new \Exception('Invalid AI response: '.$text);
        }

        return $result;
    }
}