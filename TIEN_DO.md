# TIẾN ĐỘ CHUYỂN ĐỔI BACKEND JAVA -> PHP (LARAVEL)

Tài liệu này dùng để theo dõi toàn bộ lộ trình và tiến độ đập đi xây lại Backend từ Spring Boot (Java) sang Laravel (PHP).

---

## 🟢 GIAI ĐOẠN 1: KHỞI TẠO HẠ TẦNG (Hoàn thành 100%)
- [x] Tạo project Laravel 11 (`be-php`).
- [x] Cấu hình kết nối MySQL (`travel_erp`).
- [x] Sinh toàn bộ 35 file Migration tự động dựa trên cấu trúc Oracle.
- [x] Sinh 35 file Eloquent Models kế thừa `BaseModel` (có relationships).
- [x] Thiết lập `SpringBootHasher` để mật khẩu Bcrypt băm ra giống hệt Java (Cost=10).

## ⚪ GIAI ĐOẠN 2: CORE API & AUTHENTICATION (Có cập nhật)
- [x] Khởi tạo `ApiResponse` trait và `AppException` để bắt lỗi, chuẩn hóa JSON trả về khớp 100% với Spring Boot.
- [x] Cấu hình Exception Handler toàn cục tại `bootstrap/app.php`.
- [x] Cài đặt `tymon/jwt-auth` và cấu hình guard API.
- [x] Chuyển đổi logic sinh mã tự động `MaTuDongService` (Sử dụng Transaction Lock thay thế cho Oracle LOCK TABLE).
- [x] Viết Controller `AuthController` (Đăng ký, Đăng nhập).
- [x] Khởi tạo Seeder bơm dữ liệu mẫu cho bảng `VAITRO`.
- [x] Bổ sung: Khởi tạo NhanVienController cơ bản (Lấy hồ sơ nhân viên).

## ⚪ GIAI ĐOẠN 3: PHÂN HỆ SẢN PHẨM & TOUR (Có cập nhật)
- [x] Chuyển đổi API Quản lý Tour Mẫu, Lịch Trình Tour (CRUD Tour).
- [x] Chuyển đổi API Quản lý Tour Thực Tế (Khởi tạo, mở bán).
- [x] Viết API lấy danh sách Tour ra trang chủ cho Khách Hàng (Tìm kiếm, phân trang, lọc).
- [x] Chuyển đổi API Dịch vụ thêm & Hành động xanh (Bổ trợ Tour).
- [x] API Đánh giá & Bình luận (Rating).
- [x] Bổ sung: Cụm API mở rộng cho Tour Công Khai (Đánh giá, Hành động xanh, Dịch vụ thêm).

## ⚪ GIAI ĐOẠN 4: PHÂN HỆ BOOKING & THANH TOÁN (Có cập nhật)
- [x] Chuyển đổi quy trình Đặt Tour (Giữ chỗ, khóa luồng chống quá tải).
- [x] Quản lý Voucher / Mã giảm giá. (Hoàn thành - Mô hình Controller-Service-Repository-Model)
- [x] Chuyển đổi logic Thanh Toán (Mock Payment). (Hoàn thành - Mô hình Controller-Service-Repository-Model)
- [x] API duyệt đơn, hủy đơn, hoàn tiền. (Hoàn thành - Quy trình Khách hàng - Sales - Kế toán)
- [x] Bổ sung: API Khách Hàng tự phục vụ (Hồ sơ, Lịch sử Tour, Yêu cầu hỗ trợ).
- [x] Bổ sung: Tích hợp Payment Gateway (VNPAY Sandbox).

## 🟢 GIAI ĐOẠN 5: PHÂN HỆ ĐIỀU HÀNH & HDV (Hoàn thành 100%)
- [x] Phân công Hướng Dẫn Viên.
- [x] API cho App HDV (Xem lịch, điểm danh, báo cáo chi phí).
- [x] Quản lý duyệt chi phí Tour.

## ⏳ Giai đoạn 6: ADMIN & BÁO CÁO (Chưa bắt đầu)
- [ ] Quản lý người dùng, phân quyền RBAC.
- [ ] API Thống kê doanh thu, số lượng khách (Dashboard).
- [ ] Ghi nhật ký hệ thống (Audit Logs).

## ⏳ Giai đoạn 7: THUẦN HÓA LARAVEL & XÓA BỎ DI SẢN JAVA (Giai đoạn cuối)
- [ ] Refactor toàn bộ 35 bảng Database và cột sang chuẩn `snake_case` của Laravel.
- [ ] Cập nhật toàn bộ Eloquent Models, loại bỏ `$table` và `$primaryKey` cấu hình tay.
- [ ] Xóa bỏ toàn bộ các bình luận, tài liệu nhắc đến "Java", "Spring Boot", "Oracle".
- [ ] Áp dụng `CamelCaseJsonResponse` Middleware để map JSON trả về Frontend thay vì ép tại `BaseModel`.
- [ ] Refactor toàn bộ truy vấn `where('PascalCase')` sang `where('snake_case')` ở tất cả Controller và Service.

---

## 🔴 RÀNG BUỘC BẮT BUỘC (MANDATORY RULES)

Đây là hợp đồng nguyên tắc không thể bị phá vỡ trong quá trình làm việc giữa Lập trình viên AI và Người Dùng:

1. **Ngôn ngữ code:**
   - Hàm (Functions), Biến (Variables) viết bằng **Tiếng Việt không dấu** (vd: `dangKy`, `layDanhSachTour`).
   - Chú thích (Comments) và **các thông báo lỗi trả về cho Frontend (message)** bắt buộc phải là **Tiếng Việt có dấu** rõ ràng, chuẩn ngữ pháp.
   - Code phải chuẩn form, dễ đọc, cấu trúc thư mục rõ ràng.
2. **Kiến trúc & Tương thích:**
   - Chuyển đổi toàn diện từ Java sang PHP, **xóa sạch mọi tàn dư của Java ở Giai đoạn 7**.
   - **JSON Response phải khớp 100% với phiên bản cũ** để Frontend React không bị lỗi.
   - Chấp nhận giữ cấu trúc PascalCase ở Database tạm thời cho đến Giai đoạn 7.
3. **Quy trình làm việc (Step-by-Step):**
   - Làm từng tính năng một, **làm tới đâu phải chạy test thử (Postman/Frontend) tới đó**.
   - Cấm code nhảy cóc, cấm làm nhiều tính năng cùng lúc khi chưa được xác nhận.
4. **Cập nhật Tiến độ:**
   - **[BẮT BUỘC]** Bất cứ khi nào hoàn thành xong một tính năng nhỏ hoặc một Giai đoạn, Lập trình viên AI **phải tự động cập nhật đánh dấu `[x]` vào file `TIEN_DO.md` này** trước khi thông báo cho Người Dùng.
