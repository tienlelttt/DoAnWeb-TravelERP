# TIậ¾N ĐỘ PHÁT TRIỂN BACKEND PHP (LARAVEL)

Tài liệu này dùng để theo dõi toàn bộ lộ trình và tiậ¿n độ phát triển Backend Laravel cho hệ thống Digital Travel ERP.

---

## ðŸŸ¢ GIAI ĐOậ N 1: KHỞI Tậ O Hậ  Tậ¦NG (Hoàn thành 100%)
- [x] Tạo project Laravel 11 (`be-php`).
- [x] Cấu hình kậ¿t nối MySQL (`travel_erp`).
- [x] Sinh toàn bộ 35 file Migration dựa trên mô hình dữ liệu nghiệp vụ.
- [x] Sinh 35 file Eloquent Models kậ¿ thừa `BaseModel` (có relationships).
- [x] Thiậ¿t lậ­p hasher Bcrypt ổn định với cost=10.

## âšª GIAI ĐOậ N 2: CORE API & AUTHENTICATION (Có cậ­p nhậ­t)
- [x] Khởi tạo `ApiResponse` trait và `AppException` để bắt lỗi, chuẩn hóa JSON trả về cho frontend.
- [x] Cấu hình Exception Handler toàn cục tại `bootstrap/app.php`.
- [x] Cài đặt `tymon/jwt-auth` và cấu hình guard API.
- [x] Hoàn thiện logic sinh mÝtự động `MaTuDongService` bằng Transaction Lock.
- [x] Viậ¿t Controller `AuthController` (Đăng ký, Đăng nhậ­p).
- [x] Khởi tạo Seeder bơm dữ liệu mẫu cho bảng `VAITRO`.
- [x] Bổ sung: Khởi tạo NhanVienController cơ bản (Lấy hồ sơ nhân viên).

## âšª GIAI ĐOậ N 3: PHÂN HỆ Sậ¢N PHậ¨M & TOUR (Có cậ­p nhậ­t)
- [x] Chuyển đổi API Quản lý Tour Mẫu, Lịch Trình Tour (CRUD Tour).
- [x] Chuyển đổi API Quản lý Tour Thực Tậ¿ (Khởi tạo, mở bán).
- [x] Viậ¿t API lấy danh sách Tour ra trang chủ cho Khách Hàng (Tìm kiậ¿m, phân trang, lọc).
- [x] Chuyển đổi API Dịch vụ thêm & Hành động xanh (Bổ trợ Tour).
- [x] API Đánh giá & Bình luậ­n (Rating).
- [x] Bổ sung: Cụm API mở rộng cho Tour Công Khai (Đánh giá, Hành động xanh, Dịch vụ thêm).

## âšª GIAI ĐOậ N 4: PHÂN HỆ BOOKING & THANH TOÁN (Có cậ­p nhậ­t)
- [x] Chuyển đổi quy trình Đặt Tour (Giữ chỗ, khóa luồng chống quá tải).
- [x] Quản lý Voucher / MÝgiảm giá. (Hoàn thành - Mô hình Controller-Service-Repository-Model)
- [x] Chuyển đổi logic Thanh Toán (Mock Payment). (Hoàn thành - Mô hình Controller-Service-Repository-Model)
- [x] API duyệt đơn, hủy đơn, hoàn tiền. (Hoàn thành - Quy trình Khách hàng - Sales - Kậ¿ toán)
- [x] Bổ sung: API Khách Hàng tự phục vụ (Hồ sơ, Lịch sử Tour, Yêu cầu hỗ trợ).
- [x] Bổ sung: Tích hợp Payment Gateway (VNPAY Sandbox).

## ðŸŸ¢ GIAI ĐOậ N 5: PHÂN HỆ ĐIỀU HÀNH & HDV (Hoàn thành 100%)
- [x] Phân công Hướng Dẫn Viên.
- [x] API cho App HDV (Xem lịch, điểm danh, báo cáo chi phí).
- [x] Quản lý duyệt chi phí Tour.

## ðŸŸ¢ Giai đoạn 6: ADMIN & BÁO CÁO (Hoàn thành 100%)
- [x] Quản lý người dùng, phân quyền RBAC.
- [x] API Thống kê doanh thu, số lượng khách (Dashboard).
- [x] Ghi nhậ­t ký hệ thống (Audit Logs).

## âœ… Giai đoạn 6.5: BỔ SUNG NGHIỆP VỤ RÒ RỈ (ĐÝhoàn thành)
- [x] Kậ¿ toán - Quyậ¿t toán Tour (Tính toán, chốt sổ, yêu cầu bổ sung chứng từ).
- [x] Kậ¿ toán - Quản lý Giao dịch hoàn tiền (Duyệt/Từ chối hoàn tiền).
- [x] Kinh doanh/Admin - Quản lý Voucher (Tạo mới, vô hiệu hóa, phân bổ cho khách hàng).
- [x] Kậ¿ toán - Tích hợp Power BI (Cấp credential kậ¿t nối Database, Xuất file Excel/CSV).
- [x] Cron Jobs (Schedule hủy đơn đặt tour quá hạn, cậ­p nhậ­t giá động).

## âœ… Giai đoạn 7.1: ĐỒNG BỘ API CONTRACT & GIỮ NGUYÊN FRONTEND (Hoàn thành 100%)
- [x] Lậ­p baseline API contract cho frontend hiện tại.
- [x] Bổ sung alias API Khách hàng, Thanh toán và Quản trị.
- [x] Bổ sung nghiệp vụ Voucher khách hàng theo contract hiện tại.
- [x] Bổ sung nghiệp vụ đăng ký nhân viên Quản trị.
- [x] Làm mỏng `VoucherController`, chuyển logic áp voucher về Service.
- [x] Bổ sung alias API Kinh doanh và Điều hành.
- [x] Bổ sung API Điều hành xem đoàn, sự cố và chi phí theo tour.
- [x] Bổ sung test contract cho các alias API.
- [x] Chuẩn hóa README, AGENTS, CODING_GUIDELINES và comment runtime để backend PHP đọc như một hệ thống độc lậ­p.
- [x] Kiểm thử contract: `ApiContractCompatibilityTest` pass 4 tests / 15 assertions âœ…
- [x] Kiểm thử toàn bộ: `php artisan test` pass **64 tests / 258 assertions** âœ…
- [x] Fix SSL/TLS: Export Windows Trusted Root CA vào cacert.pem cho PHP curl OpenSSL.

## âœ… Giai đoạn 7.2: CHUậ¨N HÓA KIậ¾N TRÚC LARAVEL (Hoàn thành 100%)
- [x] Refactor toàn bộ 35 bảng Database và cột sang chuẩn `snake_case` của Laravel.
- [x] Cậ­p nhậ­t toàn bộ Eloquent Models, chuyển các thuộc tính và quan hệ sang snake_case, đồng thời giữ nguyên các quan hệ nghiệp vụ.
- [x] Chuẩn hóa toàn bộ bình luậ­n, tài liệu và tên kỹ thuậ­t theo ngữ cảnh Laravel độc lậ­p.
- [x] Áp dụng `CamelCaseJsonResponse` Middleware để map JSON trả về Frontend tự động làm lớp bảo vệ tối ưu.
- [x] Refactor toàn bộ truy vấn `where('PascalCase')` sang `where('snake_case')` ở tất cả Controller và Service sử dụng Tokenizer an toàn.
- [x] Chuẩn hóa toàn bộ các file SQL Oracle sang MySQL thuần (`snake_case`) lưu tại `database/raw-sql/`.
- [x] Xóa sạch thư mục legacy `database-scripts` và script parser cũ để loại bỏ hoàn toàn dấu vậ¿t công nghệ cũ.
- [x] Phân tách kiậ¿n trúc Seeder chuyên nghiệp: `CoreSystemSeeder` cho cấu hình Production và `DatabaseDemoSeeder` cho môi trường Test.

## âœ… TÁI Cậ¤U TRÚC MONOREPO (Hoàn thành 100%)
- [x] Phân chia cấu trúc monorepo chuẩn: `backend/`, `frontend/`, `database-scripts/`, `docs/`.
- [x] Gom và gộp 3 ứng dụng frontend React (`admin`, `hdv`, `kh`) vào `frontend/` và loại bỏ thư mục `.git` để Monorepo theo dõi.
- [x] Dọn dậ¹p và bỏ qua các thư mục dependencies (`vendor/`, `node_modules/`) và cấu hình môi trường cục bộ (`.env`).
- [x] Thiậ¿t lậ­p file `.gitignore` chuẩn ở thư mục gốc Monorepo bảo vệ và loại trừ các file tự sinh/nhạy cảm.
- [x] Di chuyển toàn bộ file tài liệu vào `docs/` để cấu trúc thư mục gốc Monorepo sạch đậ¹p.
- [x] Bảo toàn 100% nội dung code và kiểm tra trạng thái Git (`git status`) sạch sậ½, chỉ chứa hoạt động di chuyển và cấu trúc mới.

## âœ… XUậ¤T BÁO CÁO PDF KÈM BIỂU ĐỒ (Hoàn thành 100%)
- [x] Cài đặt `barryvdh/laravel-dompdf` cho backend Laravel.
- [x] Xây dựng `SvgChartHelper` vậ½ 4 loại biểu đồ SVG thuần PHP (cột nhóm, đường, tròn, thanh ngang).
- [x] Phát triển `ReportPdfService`: lấy dữ liệu, giới hạn 5000 dòng, lọc Top 15 biểu đồ, render PDF.
- [x] Phát triển `ReportPdfController`: phân quyền ADMIN/KETOAN, validate ngày, đặt tên file chuẩn.
- [x] Thiậ¿t kậ¿ 5 Blade templates in ấn (font DejaVu Sans, thead lặp trang, page-break-inside: avoid).
- [x] Đăng ký route API `POST /api/admin/report/pdf/{type}` bảo mậ­t phân quyền.
- [x] Tích hợp nút **"Xuất PDF báo cáo"** vào `PowerBIConnectionModal.tsx` với xử lý Blob và thông báo lỗi rõ ràng.
- [x] Kiểm thử tự động: `ReportPdfTest.php` â€” **6 tests / 20 assertions đều pass âœ…**.

---

## ðŸ”´ RÀNG BUỘC Bậ®T BUỘC (MANDATORY RULES)

Đây là hợp đồng nguyên tắc không thể bị phá vỡ trong quá trình làm việc giữa Lậ­p trình viên AI và Người Dùng:

1. **Ngôn ngữ code:**
   - Hàm (Functions), Biậ¿n (Variables) viậ¿t bằng **Tiậ¿ng Việt không dấu** (vd: `dangKy`, `layDanhSachTour`).
   - Chú thích (Comments) và **các thông báo lỗi trả về cho Frontend (message)** bắt buộc phải là **Tiậ¿ng Việt có dấu** rõ ràng, chuẩn ngữ pháp.
   - Code phải chuẩn form, dễ đọc, cấu trúc thư mục rõ ràng.
2. **Kiậ¿n trúc & Tương thích:**
   - Backend Laravel phải đứng độc lậ­p, tài liệu và code không phụ thuộc vào lịch sử công nghệ trước đó.
   - **JSON Response phải khớp 100% với API contract đÝcông bố** để Frontend React không bị lỗi.
   - Chấp nhậ­n giữ cấu trúc PascalCase ở Database tạm thời cho đậ¿n Giai đoạn 7.
3. **Quy trình làm việc (Step-by-Step):**
   - Làm từng tính năng một, **làm tới đâu phải chạy test thử (Postman/Frontend) tới đó**.
   - Cấm code nhảy cóc, cấm làm nhiều tính năng cùng lúc khi chưa được xác nhậ­n.
4. **Cậ­p nhậ­t Tiậ¿n độ:**
   - **[Bậ®T BUỘC]** Bất cứ khi nào hoàn thành xong một tính năng nhỏ hoặc một Giai đoạn, Lậ­p trình viên AI **phải tự động cậ­p nhậ­t đánh dấu `[x]` vào file `TIEN_DO.md` này** trước khi thông báo cho Người Dùng.
5. **Dọn dậ¹p code tạm:**
   - **[Bậ®T BUỘC]** Khi tạo ra các file tạm thời (ví dụ: file log, file dump, file test_models.php, file remove_bom.php...) để fix lỗi hoặc kiểm tra dữ liệu, nậ¿u file đó không còn dùng thì **PHậ¢I XÓA ĐI** ngay lậ­p tức để giữ workspace sạch sậ½.
