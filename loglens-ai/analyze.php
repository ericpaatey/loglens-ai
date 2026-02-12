<?php


/* =====================================================
   Code responsible for Analyzing (analyze.php) (SECURE VERSION)
   ===================================================== */

require_once 'includes/ai.php';

header('Content-Type: application/json');

if (!isset($_FILES['logfile'])) {
    echo json_encode(['error' => 'No file uploaded']);
    exit;
}

$file = $_FILES['logfile'];

/* ---------------- SECURITY CONTROLS ---------------- */

// 1. size limit (50MB)
if ($file['size'] > 50 * 1024 * 1024) {
    echo json_encode(['error' => 'File too large']);
    exit;
}

// 2. extension whitelist
$allowedExt = ['log', 'txt', 'csv','xls'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowedExt)) {
    echo json_encode(['error' => 'Invalid file type']);
    exit;
}

// 3. mime type validation
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);

//$allowedMime = ['text/plain', 'text/x-log', 'application/octet-stream'];
$allowedMime = [
    'text/csv',
    'text/plain',
    'application/csv',
    'text/x-log',
    'text/x-csv',
    'application/vnd.ms-excel',
    'application/octet-stream'
];

if (!in_array($mime, $allowedMime)) {
    echo json_encode(['error' => 'Invalid MIME type']);
    exit;
}

// 4. NEVER execute or store uploads in webroot
$content = file_get_contents($file['tmp_name']);

// sanitize binary data
$content = preg_replace('/[^\x20-\x7E\n\r\t]/', '', $content);

/* --------------------------------------------------- */

$env = $_POST['env'] ?? 'Apache';

// trim to last lines only (AI token efficiency)
$content = substr($content, -15000);

$lines = explode("\n", $content);
$errorCounts = [];

foreach ($lines as $line) {
    if (stripos($line, 'error') !== false || stripos($line, 'warn') !== false) {
        $key = substr($line, 0, 120);
        $errorCounts[$key] = ($errorCounts[$key] ?? 0) + 1;
    }
}

arsort($errorCounts);

$summary = "Top issues:\n";
foreach (array_slice($errorCounts, 0, 12) as $k => $v) {
    $summary .= "[$v] $k\n";
}

$analysis = analyzeWithAI($env, $summary);

echo json_encode(['result' => $analysis]);
exit;
?>