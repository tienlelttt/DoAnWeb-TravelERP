# ðŸ“± Digital Travel ERP - Tour Guide Mobile Portal (HDV)

Ứng dụng di động tối ưu dành riêng cho **Hướng dẫn viên (HDV) thực địa**, được xây dựng dưới dạng Progressive Web App (PWA) giúp theo dõi hành trình, điểm danh du khách, quyậ¿t toán chi phí và báo cáo sự cố thời gian thực.

---

## ðŸš€ Tính năng chính của Cổng Hướng dẫn viên

1. **ðŸ”‘ Đăng nhậ­p Nghiệp vụ (Security Login):** Đăng nhậ­p nhanh bằng mÝsố HDV được cấp phép để đồng bộ dữ liệu tour thực tậ¿ từ văn phòng điều hành.
2. **ðŸ“Š Trang chủ & Chỉ số đoàn (Dashboard):** Xem chi tiậ¿t Tour đang diễn ra, tiậ¿n độ điểm danh nhanh, tổng hợp ngân sách chi tiêu và các lịch trình sắp khởi hành.
3. **ðŸ“… Lịch trình Tour & Thực đơn (Schedule):** Tra cứu hoạt động chi tiậ¿t theo thời gian thực (Giờ giấc, Hoạt động, Địa điểm) kèm theo thực đơn ẩm thực bữa trưa/tối đặc sắc.
4. **ðŸ‘¥ Điểm danh du khách thông minh (Attendance Check):**
   * Quét mÝQR hoặc check-in thủ công.
   * Hiển thị cảnh báo đỏ y tậ¿ đối với các hành khách có tiểu sử dị ứng/sức khỏe đặc biệt (bắt buộc HDV xác nhậ­n).
   * Ghi nhậ­n vắng mặt kèm lý do chi tiậ¿t cậ­p nhậ­t ngay lậ­p tức lên ERP chính.
5. **ðŸ€ Ghi nhậ­n Hành động Xanh (Eco Green Passport):** Đồng hành cùng du lịch bền vững bằng việc xác nhậ­n các hành động bảo vệ môi trường của du khách để cộng điểm tích lũy Hộ chiậ¿u số.
6. **ðŸ’µ Quyậ¿t toán chi phí thực địa (Expense Tracker):** Nhậ­p khoản chi, chụp ảnh hóa đơn chứng từ và tự động trừ vào hạn mức tạm ứng của tour.
7. **ðŸš¨ Báo cáo sự cố khẩn cấp (Incident Report & SOS):** Báo cáo nhanh các sự cố (y tậ¿, thời tiậ¿t, phương tiện) kèm ảnh chụp thực tậ¿ và kích hoạt trạng thái SOS khẩn cấp gửi về trung tâm điều hành.

---

## ðŸ“ Cấu trúc Thư mục Chuẩn hóa (Modular Structure)

MÝnguồn được tổ chức sạch sậ½, chuẩn hóa theo mô hình mô-đun hóa các trang nghiệp vụ:

* **[src/App.tsx](src/App.tsx):** Page Shell trung tâm, quản lý trạng thái phiên làm việc, lưu trữ cơ sở dữ liệu ảo và thanh Footer điều hướng.
* **[src/types.ts](src/types.ts):** Định nghĩa chặt chậ½ các thực thể TypeScript (Tour, Passenger, Expense, IncidentReport).
* **[src/mockData.ts](src/mockData.ts):** Cơ sở dữ liệu giả lậ­p cho khách hàng, lịch trình, hành động xanh và chi phí.
* **`src/pages/` (NEW âœ¨):** Thư mục chứa các trang nghiệp vụ độc lậ­p:
  * [Login.tsx](src/pages/Login.tsx): Trang xác thực tài khoản HDV.
  * [Profile.tsx](src/pages/Profile.tsx): Hồ sơ chi tiậ¿t HDV và năng lực thực địa.
  * [Dashboard.tsx](src/pages/Dashboard.tsx): Trang chủ quản lý tổng quan.
  * [Schedule.tsx](src/pages/Schedule.tsx): Quản lý chi tiậ¿t lịch trình và thực đơn ăn uống.
  * [Attendance.tsx](src/pages/Attendance.tsx): Hệ thống điểm danh và cảnh báo sức khỏe y tậ¿.
  * [GreenPoints.tsx](src/pages/GreenPoints.tsx): Tích điểm hành động xanh cho du khách.
  * [ExpenseTracker.tsx](src/pages/ExpenseTracker.tsx): Quản lý chi phí và quyậ¿t toán tạm ứng thực địa.
  * [IncidentReport.tsx](src/pages/IncidentReport.tsx): Báo cáo sự cố và kích hoạt tín hiệu SOS khẩn cấp.

---

## ðŸ› ï¸ Công nghệ Sử dụng & Thiậ¿t kậ¿ Premium

* **Core & Routing:** React 19 + TypeScript + Vite.
* **CSS & Style:** Tailwind CSS v4 với các lớp tiện ích được tùy biậ¿n sâu.
* **Aesthetics:** Thiậ¿t kậ¿ Glassmorphism hiện đại, màu sắc Tailored HSL dịu mắt, bóng mờ mịn màng và các vi hiệu ứng chuyển động tương tác mượt mà.
* **Typography:** Tích hợp phông chữ **Outfit** bo tròn hiện đại mang lại cảm giác cao cấp và chuyên nghiệp.

---

## ðŸ§‘â€ðŸ’» Hướng dẫn Phát triển & Biên dịch

### 1. Cài đặt thư viện:
```bash
npm install
```

### 2. Khởi chạy môi trường Dev:
```bash
npm run dev
```

### 3. Kiểm tra kiểu dữ liệu TypeScript (Compile Check):
```bash
npx tsc --noEmit
```

### 4. Biên dịch dự án (Production Build):
```bash
npm run build
```
