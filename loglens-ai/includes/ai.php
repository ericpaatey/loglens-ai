<?php 

/* =====================================================
   Code responsible for connecting to relevant AI endpoints
   ===================================================== */

function analyzeWithAI($env, $summary) {

    $apiKey = getenv('OPENAI_API_KEY');

    
    
    $prompt = "You are a senior DevOps, SRE, and infrastructure engineer.

Analyze the {$env} / server logs below and perform professional root cause analysis.

Your task is to:
1. Identify recurring errors and patterns
2. Determine the most likely root causes (not just symptoms)
3. Rank issues by severity and impact
4. Provide clear, actionable remediation steps
5. Provide commands/config fixes where applicable
6. Explain in plain English

IMPORTANT:
- Focus on root causes, not repeating the log lines
- Be concise but thorough
- Group similar errors together
- Avoid speculation
- Provide practical fixes only

Return your answer in this exact structure:

========================
SUMMARY
- High-level overview of system health
- Total issues detected
- Most critical problem

CRITICAL ISSUES (Production breaking)
For each:
- Error
- Root Cause
- Why it happens
- Fix steps
- Commands/config examples

WARNINGS (Performance or reliability risks)
Same structure

INFO (Minor or noise)

RECOMMENDED ACTION PLAN (Prioritized steps)
1.
2.
3.
4.

PREVENTION TIPS
Best practices to avoid recurrence

========================".$summary;

    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ]
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    return $json['choices'][0]['message']['content'] ?? 'No response';
}

?>