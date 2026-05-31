# CODING_GUIDELINES.md

## 1. Mục tiêu dự án

Dự án:

Digital Travel ERP

Mục tiêu:

* Phát triển Backend Digital Travel ERP trên Laravel + MySQL.
* Giữ nguyên nghiệp vụ hệ thống.
* Giữ nguyên API Contract đã công bố.
* Giữ nguyên cấu trúc JSON Response đang được frontend sử dụng.
* Frontend React hoạt động mà không cần chỉnh sửa code.

---

## 2. Nguyên tắc bắt buộc

### KHÔNG ĐƯỢC

* Không sửa code Frontend React.
* Không đổi tên bảng.
* Không đổi tên cột.
* Không đổi khóa ngoại.
* Không thay đổi API Contract.
* Không tự ý tối ưu làm thay đổi hành vi hệ thống.
* Không tạo endpoint mới nếu chưa được yêu cầu.

### BẮT BUỘC

* Giữ tương thích 100% với API Contract, schema dữ liệu và hành vi nghiệp vụ đã công bố.
* Ưu tiên tính đúng đắn hơn tốc độ phát triển.
* Mọi thay đổi phải có test.
* Mọi thay đổi phải cập nhật TIEN_DO.md.
* Không để code, comment runtime hoặc cấu hình public phụ thuộc vào backend khác.

---

## 3. Quy trình làm việc

Bắt buộc theo trình tự:

1. Phân tích yêu cầu.
2. Thiết kế giải pháp.
3. Được xác nhận.
4. Viết code.
5. Review code.
6. Viết test.
7. Chạy test.
8. Cập nhật TIEN_DO.md.

Không được bỏ qua bước nào.

---

## 4. Kiến trúc Laravel

Bắt buộc sử dụng:

Controller
→ Service
→ Repository
→ Model

Không viết business logic trong Controller.

Controller chỉ:

* Validate Request
* Gọi Service
* Trả Response

Service:

* Chứa toàn bộ nghiệp vụ

Repository:

* Truy vấn dữ liệu

Model:

* Mapping Database

---

## 5. Quy tắc đặt tên

### Class

PascalCase

Ví dụ:

TourController
DatTourService
VoucherRepository

### Hàm

camelCase tiếng Việt không dấu

Ví dụ:

layDanhSachTour()
taoDonDatTour()
capNhatTrangThai()

### Biến

camelCase tiếng Việt không dấu

Ví dụ:

soLuongKhach
tongTien
maDatTour

---

## 6. Comment

Comment phải là tiếng Việt có dấu.

Ví dụ:

// Kiểm tra số chỗ còn lại của tour

// Tạo đơn đặt tour mới

Không sử dụng comment tiếng Anh.

---

## 7. Message trả về Frontend

Toàn bộ message phải là tiếng Việt có dấu.

Ví dụ:

"Dữ liệu không hợp lệ"

"Không tìm thấy tour"

"Đặt tour thành công"

Không sử dụng message tiếng Anh.

---

## 8. Response JSON

Bắt buộc giữ đúng hợp đồng API đã công bố.

Không được tự ý thay đổi:

* field name
* structure
* pagination format
* error format

Mọi API mới phải kiểm tra tương thích với frontend và tài liệu hợp đồng API.

---

## 9. Transaction

Bắt buộc dùng DB::transaction khi:

* Ghi nhiều bảng
* Thanh toán
* Đặt tour
* Hoàn tiền
* Duyệt đơn

Nếu có khả năng race condition:

* Sử dụng lockForUpdate()

---

## 10. Validation

Sử dụng FormRequest.

Không validate trực tiếp trong Controller.

Ví dụ:

DatTourRequest
DangNhapRequest
CapNhatTourRequest

---

## 11. Resource

Mọi API trả dữ liệu phải dùng Resource.

Không return Model trực tiếp.

Ví dụ:

TourResource
BookingResource
VoucherResource

---

## 12. Security

Bắt buộc:

* JWT Authentication
* Authorization theo vai trò
* Validate toàn bộ input
* Không hardcode secret
* Không commit file .env

---

## 13. Testing

Mỗi chức năng phải có:

* Unit Test
* Feature Test

Kiểm tra:

* Happy Path
* Validation Error
* Unauthorized
* Exception

---

## 14. Pull Request Checklist

Trước khi hoàn thành task:

* Build thành công
* Test pass
* Không còn TODO
* Không còn code debug
* Không còn dd()
* Không còn dump()
* Đã cập nhật TIEN_DO.md

Nếu bất kỳ mục nào chưa đạt:
KHÔNG ĐƯỢC đánh dấu task hoàn thành.

---

## 15. Quy tắc làm việc với Codex

Khi nhận task:

1. Đọc README.md
2. Đọc TIEN_DO.md
3. Đọc AGENTS.md
4. Đọc CODING_GUIDELINES.md

Sau đó:

* Phân tích
* Đề xuất giải pháp
* Mới được code

Không code ngay khi chưa hiểu yêu cầu.
