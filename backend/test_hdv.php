<?php
// Function to make HTTP requests
function make_request($url, $method = 'GET', $data = null, $headers = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if ($data) {
        $jsonData = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Content-Length: ' . strlen($jsonData);
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status' => $statusCode,
        'body' => $response
    ];
}

// 1. Login
echo "Logging in via HTTP to http://localhost:8080 ...\n";
$loginRes = make_request('http://localhost:8080/api/auth/dang-nhap', 'POST', [
    'tenDangNhap' => 'hdv02',
    'matKhau' => 'password'
]);

echo "Login status: " . $loginRes['status'] . "\n";
echo "Login body: " . $loginRes['body'] . "\n";

$data = json_decode($loginRes['body'], true);
$token = $data['data']['accessToken'] ?? null;

if (!$token) {
    echo "Could not obtain token.\n";
    exit;
}

// 2. Fetch tour schedule
echo "\nFetching schedule from http://localhost:8080 ...\n";
$schedRes = make_request('http://localhost:8080/api/huong-dan-vien/tour/TTT001/lich-trinh', 'GET', null, [
    'Authorization: Bearer ' . $token,
    'Accept: application/json'
]);
echo "Schedule status: " . $schedRes['status'] . "\n";
echo "Schedule body: " . $schedRes['body'] . "\n";

// 3. Fetch tour group
echo "\nFetching group from http://localhost:8080 ...\n";
$groupRes = make_request('http://localhost:8080/api/huong-dan-vien/tour/TTT001/doan', 'GET', null, [
    'Authorization: Bearer ' . $token,
    'Accept: application/json'
]);
echo "Group status: " . $groupRes['status'] . "\n";
echo "Group body: " . $groupRes['body'] . "\n";
