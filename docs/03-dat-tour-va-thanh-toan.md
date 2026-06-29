# Phân hệ Đặt tour & Thanh toán

## 3.2.9. Tra cứu tour
**Bảng 3.27: Đặc tả Use-case Tra cứu tour**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC25 |
| Tên Use-case | Tra cứu tour |
| Tác nhân | Khách hàng |
| Mô tả | Cho phép khách hàng tìm kiậ¿m, lọc và xem danh sách các chuyậ¿n đi phù hợp với nhu cầu. |
| Tiền điều kiện | - Người dùng đang ở trang chủ hoặc trang tìm kiậ¿m của hệ thống. |
| Hậu điều kiện | - Danh sách các chuyậ¿n đi khả dụng kèm giá ưu đÃi được hiển thị. |
| Luồng sự kiện chính | 1. Khách hàng nhấn chọn chức năng "Tìm kiậ¿m tour" trên thanh menu của hệ thống.<br>2. Hệ thống hiển thị các trường dữ liệu: Điểm đậ¿n, Ngày khởi hành, Mức giá tối đa.<br>3. Khách hàng nhập thông tin tìm kiậ¿m.<br>4. Khách hàng nhấn nút "Tìm kiậ¿m".<br>5. Hệ thống kiểm tra dữ liệu.<br>6. Hệ thống tính toán giá động theo thời gian thực.<br>7. Hệ thống hiển thị danh sách kậ¿t quả (Card view) gồm: ậ¢nh, Lịch trình, Giá động, Số chỗ còn nhận.<br>8. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 5a. Nậ¿u không có tour nào thỏa mÃn, hệ thống hiển thị thông báo không tìm thấy và đề xuất các tour điểm đậ¿n gần nhất hoặc đang thu hút nhiều sự quan tâm nhất. Hệ thống quay lại bước 3 để khách hàng điều chỉnh tiêu chí. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Khách hàng thoát khỏi màn hình tìm kiậ¿m. Use case kậ¿t thúc. |

## 3.2.9.1. Xem chi tiậ¿t tour
**Bảng 3.28: Đặc tả Use-case Xem chi tiậ¿t tour**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC26 |
| Tên Use-case | Xem chi tiậ¿t tour |
| Tác nhân | Khách hàng |
| Mô tả | Cho phép khách hàng xem toàn bộ thông tin về một chuyậ¿n đi cụ thể. |
| Tiền điều kiện | - Khách hàng đang ở màn hình kậ¿t quả tra cứu (UC23). |
| Hậu điều kiện | - Trang chi tiậ¿t tour được hiển thị. |
| Luồng sự kiện chính | 1. Khách hàng nhấn "Xem chi tiậ¿t" của một tour.<br>2. Hệ thống truy xuất dữ liệu tour và hiển thị trang chi tiậ¿t: tổng quan, lịch trình, bảng giá, lịch khởi hành, đánh giá, chính sách.<br>3. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 2a. Nậ¿u xảy ra lỗi khi truy xuất dữ liệu, hệ thống hiển thị thông báo lỗi và yêu cầu thử lại.<br>Khách hàng thoát khỏi màn hình xem chi tiậ¿t của tour. Use case kậ¿t thúc. |

## 3.2.10. Đặt tour
**Bảng 3.29: Đặc tả Use-case Đặt tour**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC27 |
| Tên Use-case | Đặt tour |
| Tác nhân | Khách hàng |
| Mô tả | Khách hàng thực hiện đăng ký giữ chỗ, cung cấp thông tin các thành viên tham gia và lựa chọn dịch vụ đi kèm để khởi tạo đơn hàng. |
| Tiền điều kiện | - Khách hàng đÝđăng nhập thành công và đang xem chi tiậ¿t một chuyậ¿n đi cụ thể còn nhận khách. |
| Hậu điều kiện | - Đơn hàng được tạo ở trạng thái "Chờ thanh toán", quỹ chỗ được tạm khóa và hồ sơ hành khách được liên kậ¿t hoặc khởi tạo mới. |
| Luồng sự kiện chính | 1. Khách hàng nhấn nút "Đặt ngay" tại trang thông tin chi tiậ¿t của chuyậ¿n đi.<br>2. Hệ thống hiển thị màn hình chọn: [Cá nhân] hoặc [Theo nhóm].<br>3. Trường hợp đi theo nhóm, khách hàng nhập tổng số lượng người.<br>4. Hệ thống kiểm tra quỹ chỗ trống, nậ¿u đáp ứng đủ sậ½ thực hiện lệnh "Tạm giữ chỗ" và kích hoạt đồng hồ đậ¿m ngược thời gian hoàn tất thủ tục.<br>5. Cung cấp thông tin hành khách:<br>   - Thông tin của chính khách hàng (người đặt) được tự động lấy từ "Hộ chiếu số".<br>   - Nậ¿u đặt cho nhiều người, nhập thông tin cơ bản của những người đó.<br>6. Khách hàng tùy chọn các dịch vụ thêm (nậ¿u có) và hạng phòng.<br>7. Khách hàng lựa chọn các cam kậ¿t bảo vệ môi trường (hành động xanh).<br>8. Khách hàng có thể thực hiện áp dụng mÝgiảm giá (UC28).<br>9. Hệ thống tổng hợp chi tiậ¿t đơn hàng (giá gốc, phụ thu, mức giảm) và hiển thị tổng số tiền cần thanh toán.<br>10. Khách hàng nhấn "Tiậ¿n hành thanh toán" để chuyển sang UC29.<br>11. Hệ thống lưu trữ thông tin đơn hàng vào CSDL.<br>12. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 4a. Nậ¿u số người đăng ký > số chỗ thực tậ¿, thông báo lỗi và gợi ý số chỗ tối đa còn lại. Quay lại bước 2.<br>4b. Nậ¿u không hoàn tất trước thời gian đậ¿m ngược, giao dịch hậ¿t hạn, tự động hủy dữ liệu tạm và giải phóng quỹ chỗ.<br>Khách hàng thoát khỏi màn hình đặt tour. Use case kậ¿t thúc. |

## 3.2.10.1. Áp dụng voucher
**Bảng 3.30: Đặc tả Use-case Áp dụng Voucher**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC28 |
| Tên Use-case | Áp dụng Voucher |
| Tác nhân | Khách hàng |
| Mô tả | Khách hàng lựa chọn mÝgiảm giá phù hợp từ ví để áp dụng cho đơn hàng đang thực hiện. |
| Tiền điều kiện | - Đang ở bước xác nhận đơn hàng (UC27).<br> - Có ít nhất một Voucher còn hạn và thỏa mÃn điều kiện. |
| Hậu điều kiện | - Tổng số tiền của đơn hàng được cập nhật lại.<br> - Trạng thái Voucher chuyển sang "Tạm giữ". |
| Luồng sự kiện chính | 1. Tại bước tổng kậ¿t đơn hàng, nhấn "Chọn/Nhập mÝgiảm giá".<br>2. Hệ thống truy xuất và ưu tiên hiển thị danh sách các mÝphù hợp.<br>3. Khách hàng chọn mÝmuốn sử dụng.<br>4. Hệ thống kiểm tra tính hợp lệ của mÃ.<br>5. Hệ thống "Tạm khóa" voucher này, tính toán lại và cập nhật tổng số tiền cuối cùng.<br>6. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có |
| Luồng sự kiện lỗi hoặc ngoại lệ | 4a. Nậ¿u voucher không hợp lệ, hệ thống từ chối áp dụng và hiển thị thông báo. |

## 3.2.10.2. Thanh toán đơn hàng
**Bảng 3.31: Đặc tả Use-case Thanh toán đơn hàng**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC29 |
| Tên Use-case | Thanh toán đơn hàng |
| Tác nhân | Khách hàng, Cổng thanh toán điện tử |
| Mô tả | Khách hàng chuyển tiền thanh toán để xác nhận chính thức đơn đặt tour. |
| Tiền điều kiện | - Hoàn tất các bước đặt tour, đơn hàng ở trạng thái "Chờ thanh toán".<br> - Thời gian tạm giữ chỗ vẫn còn hiệu lực. |
| Hậu điều kiện | - Trạng thái đơn hàng cập nhật thành "ĐÝxác nhận".<br> - Vé điện tử phát hành, gửi cho khách hàng.<br> - Số chỗ trống được trừ chính thức. |
| Luồng sự kiện chính | 1. Chọn phương thức thanh toán khả dụng.<br>2. Khách hàng nhấn "Thanh toán".<br>3. Hệ thống thiậ¿t lập kậ¿t nối an toàn với cổng thanh toán.<br>4. Chuyển hướng đậ¿n giao diện thanh toán.<br>5. Thực hiện thanh toán với cổng thanh toán tương ứng.<br>6. Hệ thống nhận phản hồi thành công, cập nhật trạng thái đơn hàng sang "ĐÝxác nhận".<br>7. Ghi nhận đơn hàng vào CSDL.<br>8. Phát hành vé điện tử (mÝQR).<br>9. Gửi thông báo xác nhận kèm vé điện tử.<br>10. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 1a. Nậ¿u khách hàng chọn sử dụng điểm xanh, hệ thống khấu trừ điểm và hiển thị lại số tiền thanh toán cuối cùng. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 5a. Thanh toán trễ sau khi đơn hàng bị hủy -> Ghi nhận vào danh sách "Chờ hoàn tiền". |

## 3.2.11. Quy đổi voucher
**Bảng 3.32: Đặc tả Use-case Quy đổi Voucher**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC30 |
| Tên Use-case | Quy đổi Voucher |
| Tác nhân | Khách hàng |
| Mô tả | Quy đổi điểm tích lũy từ hành động xanh để lấy ưu đÃi mới. |
| Tiền điều kiện | - ĐÝđăng nhập tài khoản. |
| Hậu điều kiện | - Voucher mới được thêm vào ví cá nhân và điểm thưởng được khấu trừ. |
| Luồng sự kiện chính | 1. Nhấn chọn "Ví ưu đÃi".<br>2. Hệ thống hiển thị Ví Voucher ("Voucher của tôi" và "Kho ưu đÃi").<br>3. Chuyển sang "Kho ưu đÃi" để xem voucher có sẵn.<br>4. Chọn Voucher và nhấn "Đổi điểm".<br>5. Hiển thị cửa sổ xác nhận.<br>6. Xác nhận đổi.<br>7. Truy vấn số dư điểm xanh.<br>8. Trừ điểm thưởng xanh trong CSDL.<br>9. Cập nhật Voucher vào "Voucher của tôi".<br>10. Hiển thị thông báo thành công.<br>11. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 7a. Nậ¿u số dư điểm xanh thấp hơn mức yêu cầu, hệ thống báo lỗi. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Khách hàng rời khỏi màn hình ví voucher. Use case kậ¿t thúc. |

## 3.2.12. Xem danh sách voucher
**Bảng 3.33: Đặc tả Use-case Xem danh sách voucher**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC31 |
| Tên Use-case | Xem danh sách voucher |
| Tác nhân | Khách hàng |
| Mô tả | Xem danh sách các mÝgiảm giá hiện có trong ví cá nhân. |
| Tiền điều kiện | - ĐÝđăng nhập và đang ở trang cá nhân hoặc ví ưu đÃi. |
| Hậu điều kiện | - Hệ thống hiển thị đầy đủ thông tin các voucher khả dụng. |
| Luồng sự kiện chính | 1. Chọn chức năng "Ví voucher".<br>2. Truy vấn danh sách voucher từ CSDL.<br>3. Khách hàng nhấn vào một voucher cụ thể để xem chi tiậ¿t điều kiện.<br>4. Kậ¿t thúc Use case. |
| Luồng sự kiện phụ | 2a. Nậ¿u không có mÝgiảm giá nào, hiển thị thông báo kèm nút điều hướng đậ¿n UC30. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Khách hàng thoát khỏi màn hình xem ví voucher. Use case kậ¿t thúc. |

## 3.2.13. Hủy tour
**Bảng 3.34: Đặc tả Use-case Hủy tour**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC32 |
| Tên Use-case | Hủy tour |
| Tác nhân | Khách hàng |
| Mô tả | Thực hiện yêu cầu hủy một chuyậ¿n đi đÝxác nhận trước đó. |
| Tiền điều kiện | - Có ít nhất một đơn hàng đÝđược xác nhận và chưa đậ¿n ngày khởi hành. |
| Hậu điều kiện | - Đơn hàng chuyển sang "ĐÝhủy".<br> - Chỗ đÝđặt được trả lại.<br> - Yêu cầu hoàn tiền được khởi tạo. |
| Luồng sự kiện chính | 1. Truy cập "Chuyậ¿n đi của tôi".<br>2. Hệ thống hiển thị danh sách các chuyậ¿n đi.<br>3. Chọn một chuyậ¿n đi sắp khởi hành và nhấn "Hủy tour".<br>4. Hệ thống kiểm tra điều kiện hủy.<br>5. Tính toán mức phí phạt hủy.<br>6. Hiển thị bảng xác nhận hủy tour.<br>7. Nhấn "Xác nhận hủy tour".<br>8. Cập nhật trạng thái thành "ĐÝhủy".<br>9. Thu hồi mÝvé, trả lại chỗ.<br>10. Gửi thông báo xác nhận.<br>11. Gọi thực thi UC33 - Hoàn tiền.<br>12. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 4a. Nậ¿u thời gian khởi hành còn dưới 2 ngày, thông báo lỗi không thể hủy tour. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Khách hàng thoát khỏi màn hình hủy tour. Use case kậ¿t thúc. |

## 3.2.14. Hoàn tiền
**Bảng 3.35: Đặc tả Use-case Hoàn tiền**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC33 |
| Tên Use-case | Hoàn tiền |
| Tác nhân | Khách hàng |
| Mô tả | Hệ thống thực hiện hoàn trả tiền cho khách hàng (hủy hợp lệ/thanh toán quá hạn). |
| Tiền điều kiện | - Đơn hàng đÝhủy thành công hoặc phát sinh giao dịch trễ. |
| Hậu điều kiện | - Tiền được hoàn trả về tài khoản nguồn, trạng thái "ĐÝhoàn tiền". |
| Luồng sự kiện chính | 1. Tự động khởi tạo yêu cầu hoàn tiền.<br>2. Truy xuất thông tin giao dịch gốc.<br>3. Tính toán số tiền thực hoàn.<br>4. Tạo bản ghi yêu cầu hoàn tiền với trạng thái "Chờ kậ¿ toán duyệt".<br>5. Hiển thị trạng thái đơn: "Đang xử lý hoàn tiền".<br>6. Chuyển sang UC50 â€“ Xử lý hoàn tiền.<br>7. Cập nhật trạng thái đơn hàng và gửi thông báo.<br>8. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 5a. Nậ¿u khách chủ động hủy yêu cầu hoàn tiền, cập nhật trạng thái "ĐÝhủy". |
| Luồng sự kiện lỗi hoặc ngoại lệ | Khách hàng thoát khỏi giao diện hoàn tiền. Use case kậ¿t thúc. |