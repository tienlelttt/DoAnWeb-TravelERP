# Tổng quan Hệ thống Digital Travel ERP

## 1. Giới thiệu & Mục tiêu cốt lõi
Hệ thống **Digital Travel ERP** là giải pháp số hóa toàn diện dành cho các doanh nghiệp lữ hành, quản lý xuyên suốt vòng đời sản phẩm từ khâu thiậ¿t lập tour, phân phối, vận hành thực địa đậ¿n quyậ¿t toán tài chính. 

Mục tiêu cốt lõi của hệ thống:
- **Tối ưu hóa lợi nhuận** qua cơ chậ¿ "Định giá động" theo thời gian thực dựa trên tỷ lệ lấp đầy và thời gian cận ngày khởi hành.
- **Cá nhân hóa trải nghiệm** với "Hộ chiếu số" lưu trữ thông tin y tậ¿, sở thích và lịch sử du lịch của khách hàng.
- **Thúc đẩy du lịch bền vững** thông qua chương trình tích lũy "Điểm thưởng xanh" cho các hành động bảo vệ môi trường.
- **Quản trị vận hành thời gian thực** kậ¿t nối xuyên suốt giữa văn phòng điều hành và hướng dẫn viên (HDV) tại hiện trường.
- **Minh bạch tài chính** tự động hóa đối soát và quyậ¿t toán ngay sau khi tour kậ¿t thúc.

## 2. Các Quy trình Nghiệp vụ Chính

Hệ thống được tổ chức chặt chậ½ dựa trên 3 luồng nghiệp vụ cốt lõi:

### 2.1. Quản trị tài nguyên và Định giá sản phẩm
- **Thiậ¿t lập tour mẫu & dịch vụ:** Nhân viên khởi tạo tour mẫu, lịch trình, danh mục dịch vụ đi kèm và cấu hình hành động xanh.
- **Định giá động:** Hệ thống tự động tính toán giá bán dựa trên công thức nhân hệ số với giá sàn, tùy thuộc vào số chỗ trống và thời gian mở bán.
- **Quản lý quỹ chỗ:** Đối soát liên tục giữa sức chứa tối đa và số chỗ đÝgiữ/thanh toán để điều chỉnh chiậ¿n lược kinh doanh.

### 2.2. Giao dịch Khách hàng & Hộ chiếu số
- **Quản lý Hộ chiếu số:** Khách hàng chủ động cập nhật dữ liệu cá nhân, thông tin y tậ¿, dị ứng. Hệ thống tự động tạo hồ sơ khi khách hàng mới được đặt tour.
- **Đặt tour & Thanh toán:** Khách hàng chọn tour, dịch vụ thêm, áp dụng voucher và thanh toán. Hệ thống hỗ trợ cơ chậ¿ "giữ chỗ tạm thời" (đậ¿m ngược thời gian).
- **Quy đổi ưu đÃi:** Khách hàng sử dụng điểm thưởng từ các "hành động xanh" để quy đổi voucher cho các chuyậ¿n đi tiậ¿p theo.

### 2.3. Điều hành, Vận hành và Quyậ¿t toán
- **Điều phối nguồn lực:** Hệ thống tự động gợi ý và phân bổ HDV dựa trên năng lực, lịch rảnh và yêu cầu đặc thù của đoàn.
- **Vận hành thực địa (Mobile):** HDV sử dụng ứng dụng để xem lịch trình, điểm danh, xác nhận hành động xanh, báo cáo sự cố và cập nhật chi phí thực tậ¿ kèm hóa đơn.
- **Quyậ¿t toán tự động:** Kậ¿ toán đối soát doanh thu và chi phí thực tậ¿ (được HDV báo cáo), từ đó tính toán biên lợi nhuận gộp và quyậ¿t toán đóng tour.

## 3. Cấu trúc Tài liệu Đặc tả
Toàn bộ hệ thống được phân rÝthành **68 Use-case** với sự tham gia của **10 Actor**. 

Chi tiậ¿t danh sách và đặc tả, vui lòng xem tại các tài liệu sau:
- [Danh mục hệ thống, Actor & Use-case](00-danh-muc-he-thong.md)
- [Quản lý sản phẩm & Tour](01-quan-ly-san-pham-tour.md)
- [Quản lý Hộ chiếu số](02-quan-ly-ho-chieu-so.md)
- [Đặt tour & Thanh toán](03-dat-tour-va-thanh-toan.md)
- [Quản lý Điều phối & CSKH](04-quan-ly-dieu-phoi.md)
- [Quản lý Vận hành Mobile (HDV)](05-quan-ly-van-hanh-mobile.md)
- [Quản lý Tài chính - Kậ¿ toán](06-quan-ly-tai-chinh.md)
- [Quản lý Voucher & Khuyậ¿n mÃi](07-quan-ly-voucher-khuyen-mai.md)
- [Quản trị Hệ thống](08-quan-tri-he-thong.md)