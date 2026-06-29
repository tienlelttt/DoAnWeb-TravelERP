# Phân hệ Quản lý Điều phối & Chăm sóc khách hàng

## 4.1. Chăm sóc khách hàng

### 4.1.1. Tra cứu đơn hàng
**Bảng 4.1: Đặc tả Use-case Tra cứu đơn hàng**
| Mục | Nội dung |
|---|---|
| MÝUse-case | UC34 |
| Tên Use-case | Tra cứu đơn hàng |
| Tác nhân | Nhân viên |
| Mô tả | Cho phép nhân viên tra cứu thông tin chi tiậ¿t của một hoặc nhiều đơn đặt tour nhằm hỗ trợ khách hàng, kiểm tra tình trạng thanh toán hoặc phục vụ các nghiệp vụ liên quan. |
| Tiền điều kiện | - Nhân viên đÝđăng nhập thành công vào hệ thống. |
| Hậu điều kiện | - Hệ thống hiển thị danh sách đơn hàng thỏa mÃn điều kiện tìm kiậ¿m. |
| Luồng sự kiện chính | 1. Nhân viên truy cập chức năng "Quản lý đơn hàng".<br>2. Nhập các tiêu chí tìm kiậ¿m (MÝđơn, SĐT khách hàng, Ngày đặt...).<br>3. Nhấn "Tìm kiậ¿m".<br>4. Hệ thống truy vấn cơ sở dữ liệu.<br>5. Hệ thống hiển thị danh sách kậ¿t quả.<br>6. Nhân viên có thể nhấn "Xem chi tiậ¿t" để xem toàn bộ thông tin đơn hàng.<br>7. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 5a. Nậ¿u không có kậ¿t quả, hệ thống hiển thị thông báo "Không tìm thấy đơn hàng phù hợp". |
| Luồng sự kiện lỗi hoặc ngoại lệ | Nhân viên thoát khỏi màn hình tra cứu. Use case kậ¿t thúc. |

### 4.1.2. Đánh giá
**Bảng 4.2: Đặc tả Use-case Đánh giá**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC35 |
| Tên Use-case | Đánh giá |
| Tác nhân | Khách hàng |
| Mô tả | Cho phép khách hàng gửi đánh giá, phản hồi về chất lượng dịch vụ của một chuyậ¿n đi đÝhoàn thành. |
| Tiền điều kiện | - Khách hàng đÝđăng nhập và chuyậ¿n đi phải ở trạng thái "ĐÝhoàn thành". |
| Hậu điều kiện | - Đánh giá của khách hàng được ghi nhận vào hệ thống và công khai (nậ¿u được duyệt). |
| Luồng sự kiện chính | 1. Khách hàng truy cập danh sách "Chuyậ¿n đi đÝhoàn thành".<br>2. Chọn chuyậ¿n đi muốn đánh giá và nhấn "Đánh giá".<br>3. Hệ thống hiển thị biểu mẫu đánh giá (Số sao, nội dung bình luận, hình ảnh đính kèm).<br>4. Khách hàng điền thông tin và nhấn "Gửi đánh giá".<br>5. Hệ thống kiểm tra tính hợp lệ.<br>6. Lưu đánh giá vào CSDL ở trạng thái chờ duyệt hoặc hiển thị ngay.<br>7. Thông báo thành công và kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 5a. Nậ¿u thiậ¿u thông tin bắt buộc (ví dụ: chưa chọn số sao), hệ thống yêu cầu bổ sung. |

### 4.1.3. Khiậ¿u nại
**Bảng 4.3: Đặc tả Use-case Khiậ¿u nại**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC36 |
| Tên Use-case | Khiậ¿u nại |
| Tác nhân | Khách hàng |
| Mô tả | Khách hàng gửi các phản ánh, khiậ¿u nại về chất lượng dịch vụ hoặc các sự cố xảy ra trong quá trình sử dụng dịch vụ. |
| Tiền điều kiện | - Khách hàng đÝđăng nhập và chọn một chuyậ¿n đi (đang diễn ra hoặc đÝhoàn thành). |
| Hậu điều kiện | - Phiậ¿u khiậ¿u nại được tạo thành công trên hệ thống và chuyển trạng thái "Chờ xử lý". |
| Luồng sự kiện chính | 1. Khách hàng chọn "Khiậ¿u nại" tại màn hình chi tiậ¿t chuyậ¿n đi.<br>2. Hệ thống hiển thị biểu mẫu tạo phiậ¿u khiậ¿u nại.<br>3. Khách hàng nhập tiêu đề, mô tả sự cố và đính kèm hình ảnh/video bằng chứng.<br>4. Nhấn nút "Gửi khiậ¿u nại".<br>5. Hệ thống ghi nhận dữ liệu vào CSDL.<br>6. Gửi thông báo đậ¿n bộ phận điều hành/CSKH.<br>7. Hiển thị thông báo gửi thành công cho khách hàng.<br>8. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 5a. Nậ¿u đính kèm file vượt quá dung lượng cho phép, hệ thống báo lỗi và yêu cầu thử lại. |

## 4.2. Điều phối Hướng dẫn viên

### 4.2.1. Điều phối HDV
**Bảng 4.4: Đặc tả Use-case Điều phối HDV**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC37 |
| Tên Use-case | Điều phối HDV |
| Tác nhân | Nhân viên điều hành |
| Mô tả | Cho phép nhân viên điều hành phân công HDV phù hợp cho một chuyậ¿n đi dựa trên yêu cầu của đoàn khách, năng lực HDV và tình trạng khả dụng. |
| Tiền điều kiện | - Nhân viên đÝđăng nhập và có quyền truy cập phân hệ Điều phối.<br>- Chuyậ¿n đi đÝđược khởi tạo và đang ở trạng thái "Chờ phân bổ" hoặc "ĐÝlên lịch". |
| Hậu điều kiện | - Một bản ghi phân công được tạo. Trạng thái HDV chuyển thành "Bận" trong thời gian tour. |
| Luồng sự kiện chính | 1. Nhân viên điều hành truy cập phân hệ, chọn một chuyậ¿n đi cần phân bổ.<br>2. Hệ thống hiển thị thông tin chi tiậ¿t của chuyậ¿n đi.<br>3. Nhân viên nhấn nút "Phân bổ HDV".<br>4. Hệ thống tự động truy vấn (UC38) và gợi ý danh sách HDV.<br>5. Nhân viên chọn một HDV và nhấn "Xác nhận phân công".<br>6. Hệ thống kiểm tra xung đột lịch.<br>7. Tạo bản ghi phân công, khóa lịch HDV.<br>8. Gửi lệnh điều động đậ¿n HDV.<br>9. Hiển thị thông báo thành công.<br>10. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 3a. Thay thậ¿ nhân sự: Khi HDV báo bận đột xuất, nhân viên chọn "Thay thậ¿ nhân sự", hệ thống đề xuất HDV mới để nhân viên chọn.<br>3b. Hủy phân bổ: Không lưu thay đổi và trở về. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 6a. Xung đột lịch: Phát hiện trùng lịch, cảnh báo đỏ và yêu cầu chọn HDV khác.<br>8a. Lỗi gửi thông báo: Vẫn lưu phân bổ, hệ thống sậ½ tự động gửi lại sau. |

### 4.2.2. Tra cứu HDV
**Bảng 4.5: Đặc tả Use-case Tra cứu HDV**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC38 |
| Tên Use-case | Tra cứu HDV |
| Tác nhân | Nhân viên điều hành |
| Mô tả | Hỗ trợ nhân viên điều hành tìm kiậ¿m và xem danh sách các HDV đang sẵn sàng làm việc dựa trên các tiêu chí lọc. |
| Tiền điều kiện | - Nhân viên điều hành đÝđăng nhập vào hệ thống. |
| Hậu điều kiện | - Hệ thống hiển thị danh sách HDV thỏa mÃn điều kiện. Không làm thay đổi CSDL. |
| Luồng sự kiện chính | 1. Nhân viên truy cập chức năng tra cứu HDV.<br>2. Hệ thống hiển thị giao diện tìm kiậ¿m.<br>3. Nhập các tiêu chí (Thời gian, ngôn ngữ, kỹ năng, điểm đánh giá...).<br>4. Nhấn nút "Tìm kiậ¿m".<br>5. Hệ thống truy vấn CSDL.<br>6. Hiển thị kậ¿t quả tra cứu kèm nút "Xem chi tiậ¿t".<br>7. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 5a. Tra cứu từ màn hình chuyậ¿n đi: Tự động điền sẵn các tiêu chí khớp với yêu cầu của chuyậ¿n đi. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 6a. Không tìm thấy: Hiển thị thông báo, giữ nguyên tiêu chí để chỉnh sửa. |

## 4.3. Giải quyậ¿t khiậ¿u nại

### 4.3.1. Giải quyậ¿t khiậ¿u nại
**Bảng 4.6: Đặc tả Use-case Giải quyậ¿t khiậ¿u nại**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC39 |
| Tên Use-case | Giải quyậ¿t khiậ¿u nại |
| Tác nhân | Nhân viên điều hành |
| Mô tả | Tiậ¿p nhận, xử lý và theo dõi khiậ¿u nại từ khách hàng (xác minh thông tin, liên hệ các bên, đề xuất phương án và cập nhật kậ¿t quả). |
| Tiền điều kiện | - ĐÝcó ít nhất một khiậ¿u nại từ khách hàng ở trạng thái "Chờ xử lý". |
| Hậu điều kiện | - Khiậ¿u nại được cập nhật trạng thái (ĐÝgiải quyậ¿t, ĐÝhủy, Từ chối). Lịch sử được lưu và khách hàng nhận thông báo. |
| Luồng sự kiện chính | 1. Truy cập phân hệ "Quản lý khiậ¿u nại".<br>2. Chọn một khiậ¿u nại cần xử lý.<br>3. Xem chi tiậ¿t nội dung, ảnh/video bằng chứng.<br>4. Nhân viên chọn hướng xử lý (Bồi thường, Từ chối, Yêu cầu bổ sung...).<br>5. Nhập kậ¿t quả xử lý/ghi chú.<br>6. Nhấn "Hoàn tất xử lý".<br>7. Hệ thống cập nhật trạng thái khiậ¿u nại.<br>8. Gửi thông báo kậ¿t quả cho khách hàng.<br>9. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 4a. Yêu cầu bổ sung: Chuyển sang "Chờ bổ sung", gửi thông báo cho khách. Tự động chuyển lại "Chờ xử lý" khi khách phản hồi.<br>4b. Yêu cầu HDV giải trình: Chuyển trạng thái và gửi push notification cho HDV. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Thoát ngang màn hình: Hệ thống không lưu thay đổi. |