<?php
$exclude_dirs = ['.git', 'node_modules', 'vendor', 'dist', 'build'];
$include_exts = ['php', 'ts', 'tsx', 'js', 'jsx', 'vue', 'md', 'json', 'html', 'css'];
$mojibake = ['mÝ', 'đÝ', 'ĐÝ', 'ậ¿', 'ậ½'];

$auto_fix = in_array('--fix', $argv);
$has_error_overall = false;
$scanned = 0;
$fixed = 0;

echo "=== BẮT ĐẦU KIỂM TRA ENCODING ===\n";

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.'));
foreach ($it as $file) {
    if ($file->isDir()) continue;
    $ext = strtolower($file->getExtension());
    if (!in_array($ext, $include_exts)) continue;
    if (basename($file->getPathname()) === 'enforce_encoding.php') continue;

    $path = $file->getPathname();
    $skip = false;
    foreach ($exclude_dirs as $dir) {
        if (strpos($path, DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR) !== false || 
            strpos($path, '.\\' . $dir . '\\') !== false || 
            strpos($path, './' . $dir . '/') !== false) {
            $skip = true;
            break;
        }
    }
    if ($skip) continue;

    $scanned++;
    $content = file_get_contents($path);
    if ($content === false) continue;
    
    $errors = [];
    $is_fixed = false;
    $original = $content;

    // 1. Check BOM
    if (strncmp($content, "\xEF\xBB\xBF", 3) === 0) {
        $errors[] = "Chứa cờ UTF-8 BOM";
        if ($auto_fix) $content = substr($content, 3);
    }

    // 2. Check UTF-8 validity
    if (!mb_check_encoding($content, 'UTF-8')) {
        $errors[] = "Không phải chuẩn UTF-8 hợp lệ (chứa byte hỏng)";
        if ($auto_fix) $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
    }

    // 3. Check CRLF
    if (strpos($content, "\r") !== false) {
        $errors[] = "Sử dụng sai chuẩn xuống dòng (chứa CRLF hoặc CR thay vì LF)";
        if ($auto_fix) $content = str_replace(["\r\n", "\r"], "\n", $content);
    }

    // 4. Check Mojibake
    $found_mojibake = [];
    foreach ($mojibake as $pattern) {
        if (strpos($content, $pattern) !== false) {
            $found_mojibake[] = $pattern;
        }
    }
    if (!empty($found_mojibake)) {
        $errors[] = "Phát hiện ký tự lỗi Mojibake: " . implode(', ', $found_mojibake);
    }

    if (!empty($errors)) {
        $has_error_overall = true;
        echo "[CẢNH BÁO] $path\n";
        foreach ($errors as $err) echo "  - $err\n";
        
        if ($auto_fix && $content !== $original) {
            file_put_contents($path, $content);
            echo "  => Đã tự động sửa (Fixed).\n";
            $fixed++;
            $is_fixed = true;
        }
        echo str_repeat("-", 40) . "\n";
    }
}

echo "\nĐã quét $scanned files.\n";
if ($has_error_overall) {
    if ($auto_fix) {
        echo "Đã tự động sửa lỗi cho $fixed files.\n";
        exit(0);
    } else {
        echo "Vui lòng chạy lệnh: php enforce_encoding.php --fix để tự động sửa.\n";
        exit(1);
    }
} else {
    echo "Tất cả files đều đạt chuẩn UTF-8 (without BOM) & LF!\n";
    exit(0);
}
