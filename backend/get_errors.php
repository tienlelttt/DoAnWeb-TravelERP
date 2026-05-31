<?php
$logPath = __DIR__ . '/storage/logs/laravel.log';
if (!file_exists($logPath)) {
    echo "Log file does not exist.\n";
    exit;
}
$content = file_get_contents($logPath);
preg_match_all('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] local\.ERROR: (.*?)(?=\n\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|$)/s', $content, $matches);
if (empty($matches[0])) {
    echo "No errors found.\n";
    exit;
}
// Show the last 15 errors in chronological order
$last_errors = array_slice($matches[0], -15);
foreach ($last_errors as $err) {
    $lines = explode("\n", $err);
    echo implode("\n", array_slice($lines, 0, 8)) . "\n----------------------------------------\n";
}
