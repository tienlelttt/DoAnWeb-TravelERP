# Baseline API Contract

Tài liệu này là mốc đối chiậ¿u để bảo đảm backend Laravel phục vụ đúng các giao diện hiện tại mà không yêu cầu frontend đổi URL, payload hoặc cấu trúc JSON response.

## Nguyên tắc

- Public API là hợp đồng ổn định giữa backend và các ứng dụng frontend.
- Backend được phép thêm route alias để giữ tương thích ngược, nhưng không xóa route hiện có nậ¿u frontend đang sử dụng.
- Các endpoint có phân trang phải trả cùng định dạng phân trang đÝđược frontend tích hợp.
- Các endpoint ghi nhiều bảng hoặc có nguy cơ race condition phải nằm trong `DB::transaction` và dùng `lockForUpdate` khi cần.

## Chênh lệch ưu tiên đÝđồng bộ

| Nhóm | API cần hỗ trợ | Tình trạng trước task | Hướng xử lý |
| --- | --- | --- | --- |
| Voucher khách hàng | `GET /api/khach-hang/vi-voucher` | Có `GET /api/khach-hang/voucher` | Thêm alias về ví voucher |
| Voucher khách hàng | `GET /api/khach-hang/voucher-co-the-doi` | Chưa có route tương ứng | Thêm route + service lọc voucher đang đổi được |
| Voucher khách hàng | `POST /api/khach-hang/ap-voucher` | Có `POST /api/khach-hang/don-dat-tour/ap-dung-voucher` | Thêm alias giữ payload `maDatTour`, `maVoucher` |
| Voucher khách hàng | `POST /api/khach-hang/doi-diem` | Tiậ¿n độ ghi có nhưng route chưa có | Thêm route + service đổi điểm |
| Thanh toán | `POST /api/thanh-toan/khoi-tao` | Có `mock`, `bao-chuyen-khoan`, `vnpay/tao-url` | Thêm alias khởi tạo thanh toán |
| Thanh toán | `POST /api/thanh-toan/{maDatTour}/het-han-qr` | Chưa có alias | Thêm endpoint hậ¿t hạn QR |
| Thanh toán | `POST /api/thanh-toan/{maDatTour}/xac-nhan-chuyen-khoan` | Có `bao-chuyen-khoan` body-based | Thêm alias path-param |
| Thanh toán | `GET /api/thanh-toan/{maDatTour}/ket-qua` | Chưa có alias | Thêm endpoint polling kậ¿t quả |
| Quản trị | `GET /api/quan-tri/nhat-ky-he-thong` | Có `GET /api/admin/nhat-ky-he-thong` | Thêm alias `/quan-tri` |
| Quản trị | `POST /api/quan-tri/dang-ky-nhan-vien` | Có `POST /api/admin/users` nhưng chưa tạo `NHANVIEN` | Thêm endpoint tạo cả tài khoản và nhân viên |

## Endpoint đÝghi nhậ­n

### Auth

- `POST /api/auth/dang-ky`
- `POST /api/auth/dang-nhap`
- `POST /api/auth/doi-mat-khau`
- `POST /api/auth/kiem-tra-mat-khau`
- `POST /api/auth/quen-mat-khau`
- `POST /api/auth/dat-lai-mat-khau`
- `POST /api/auth/dang-xuat`

### Public tour

- `GET /api/public/tour`
- `GET /api/public/tour/{maTourThucTe}`
- `GET /api/public/tour/{maTourThucTe}/danh-gia`
- `GET /api/public/tour/{maTourThucTe}/hanh-dong-xanh`
- `GET /api/public/tour/{maTourThucTe}/dich-vu-them`

### Khách hàng

- `GET /api/khach-hang/ho-so`
- `PUT /api/khach-hang/ho-so`
- `POST /api/khach-hang/dat-tour`
- `GET /api/khach-hang/dat-tour`
- `GET /api/khach-hang/dat-tour/{maDatTour}`
- `DELETE /api/khach-hang/dat-tour/{maDatTour}`
- `POST /api/khach-hang/dat-tour/{maDatTour}/huy`
- `GET /api/khach-hang/lich-su-tour`
- `POST /api/khach-hang/yeu-cau-ho-tro`
- `GET /api/khach-hang/yeu-cau-ho-tro`
- `GET /api/khach-hang/yeu-cau-ho-tro/can-bo-sung`
- `PUT /api/khach-hang/yeu-cau-ho-tro/{maYeuCau}/bo-sung`
- `GET /api/khach-hang/dich-vu-them`
- `GET /api/khach-hang/hanh-dong-xanh`
- `GET /api/khach-hang/vi-voucher`
- `GET /api/khach-hang/voucher-co-the-doi`
- `POST /api/khach-hang/ap-voucher`
- `POST /api/khach-hang/doi-diem`

### Thanh toán

- `POST /api/thanh-toan/khoi-tao`
- `POST /api/thanh-toan/{maDatTour}/het-han-qr`
- `POST /api/thanh-toan/{maDatTour}/xac-nhan-chuyen-khoan`
- `GET /api/thanh-toan/{maDatTour}/ket-qua`

### Quản trị, kinh doanh, kậ¿ toán, điều hành, HDV

Nhóm này tiậ¿p tục được rà theo khả năng dùng lại controller/service hiện có. Ưu tiên route có thể bổ sung alias mà không đổi hành vi frontend.
