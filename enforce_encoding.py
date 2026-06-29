#!/usr/bin/env python3
import os
import sys
import codecs
import re

# Các thư mục và file cần bỏ qua
EXCLUDE_DIRS = {'.git', 'node_modules', 'vendor', 'dist', 'build'}
# Các định dạng file cần kiểm tra
INCLUDE_EXTS = {'.php', '.ts', '.tsx', '.js', '.jsx', '.vue', '.md', '.json', '.html', '.css'}

# Các chuỗi mojibake phổ biến do sai encoding
MOJIBAKE_PATTERNS = [
    'Ã', 'Ä', 'áº', '', 'mÝ', 'đÝ', 'ĐÝ', 'ậ¿', 'ậ½'
]

def check_and_fix_file(filepath, auto_fix=False):
    errors = []
    
    # 1. Đọc file dưới dạng binary để kiểm tra BOM và line endings
    with open(filepath, 'rb') as f:
        raw_data = f.read()

    # Kiểm tra BOM
    has_bom = raw_data.startswith(codecs.BOM_UTF8)
    if has_bom:
        errors.append("Chứa cờ UTF-8 BOM")
        if auto_fix:
            raw_data = raw_data[len(codecs.BOM_UTF8):]

    # 2. Thử giải mã bằng UTF-8
    try:
        content = raw_data.decode('utf-8')
    except UnicodeDecodeError:
        errors.append("Không phải chuẩn UTF-8 hợp lệ (chứa byte hỏng)")
        # Cố gắng cứu dữ liệu nếu auto_fix
        if auto_fix:
            content = raw_data.decode('utf-8', errors='replace')
        else:
            return errors, False

    # 3. Kiểm tra CRLF (\r\n) hoặc CR (\r) lẻ loi
    if '\r' in content:
        errors.append("Sử dụng sai chuẩn xuống dòng (chứa CRLF hoặc CR thay vì LF)")
        if auto_fix:
            content = content.replace('\r\n', '\n').replace('\r', '\n')

    # 4. Kiểm tra các ký tự lỗi (Mojibake)
    found_mojibake = []
    for pattern in MOJIBAKE_PATTERNS:
        if pattern in content:
            found_mojibake.append(pattern)
    
    if found_mojibake:
        errors.append(f"Phát hiện ký tự lỗi Mojibake: {', '.join(found_mojibake)}")

    # Ghi lại file nếu có bật auto_fix và có lỗi
    if auto_fix and errors:
        with open(filepath, 'w', encoding='utf-8', newline='\n') as f:
            f.write(content)

    return errors, (auto_fix and bool(errors))

def main():
    auto_fix = '--fix' in sys.argv
    has_error_overall = False
    fixed_count = 0
    scanned_count = 0

    print("=== BẮT ĐẦU KIỂM TRA ENCODING ===")
    
    for root, dirs, files in os.walk('.'):
        # Bỏ qua các thư mục không cần thiết
        dirs[:] = [d for d in dirs if d not in EXCLUDE_DIRS]

        for file in files:
            ext = os.path.splitext(file)[1].lower()
            if ext in INCLUDE_EXTS:
                filepath = os.path.join(root, file)
                scanned_count += 1
                
                errors, fixed = check_and_fix_file(filepath, auto_fix)
                
                if errors:
                    has_error_overall = True
                    print(f"[CẢNH BÁO] {filepath}")
                    for err in errors:
                        print(f"  - {err}")
                    if fixed:
                        print(f"  => Đã tự động sửa (Fixed).")
                        fixed_count += 1
                    print("-" * 40)

    print(f"\nĐã quét {scanned_count} files.")
    if has_error_overall:
        if auto_fix:
            print(f"Đã tự động sửa lỗi cho {fixed_count} files.")
        else:
            print("Vui lòng chạy lệnh: python enforce_encoding.py --fix để tự động sửa.")
            sys.exit(1)
    else:
        print("Tất cả files đều đạt chuẩn UTF-8 (without BOM) & LF!")
        sys.exit(0)

if __name__ == '__main__':
    main()
