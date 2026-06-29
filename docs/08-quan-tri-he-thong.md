# Phân hệ Quản trị Hệ thống

## 8.1. Quản lý truy cậ­p tài khoản (Authentication)

### 8.1.1. Quản lý truy cậ­p tài khoản (Overview)
**Bảng 8.1: Đặc tả Use-case Quản lý truy cậ­p tài khoản**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC55 |
| Tên Use-case | Quản lý truy cậ­p tài khoản (Overview) |
| Tác nhân | Khách hàng, Người dùng hệ thống |
| Mô tả | Use-case tổng quan cho phép người dùng đăng ký, đăng nhậ­p, đăng xuất và khôi phục mậ­t khẩu. |
| Tiền điều kiện | - Người dùng có thiậ¿t bị kậ¿t nối Internet. |
| Hậ­u điều kiện | - Trạng thái truy cậ­p của người dùng được xác thực và cậ­p nhậ­t. |
| Luồng sự kiện chính | 1. Người dùng truy cậ­p hệ thống.<br>2. Chọn chức năng tương ứng (Đăng ký/Đăng nhậ­p/Quên mậ­t khẩu).<br>3. Nhậ­p thông tin yêu cầu.<br>4. Hệ thống xác thực thông tin.<br>5. Chuyển hướng người dùng đậ¿n giao diện phù hợp dựa trên vai trò.<br>6. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Không có. |

### 8.1.2. Đăng ký khách hàng mới
**Bảng 8.2: Đặc tả Use-case Đăng ký khách hàng mới**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC56 |
| Tên Use-case | Đăng ký khách hàng mới |
| Tác nhân | Khách hàng |
| Mô tả | Khách hàng tạo tài khoản mới để sử dụng các dịch vụ tìm kiậ¿m và đặt tour trên hệ thống. |
| Tiền điều kiện | - Khách hàng chưa đăng nhậ­p và chưa có tài khoản trên hệ thống. |
| Hậ­u điều kiện | - Một tài khoản khách hàng mới được tạo và lưu vào CSDL. |
| Luồng sự kiện chính | 1. Khách hàng chọn "Đăng ký".<br>2. Nhậ­p các thông tin: Email, Username, Mậ­t khẩu, Nhậ­p lại mậ­t khẩu, SĐT, Địa chỉ.<br>3. Nhấn nút "Đăng ký".<br>4. Hệ thống kiểm tra thông tin hợp lệ, tạo và gửi mÝOTP về Email.<br>5. Khách hàng kiểm tra Email, nhậ­p mÝOTP và nhấn "Xác thực".<br>6. Hệ thống mÝhoá mậ­t khẩu, lưu thông tin tài khoản vào CSDL.<br>7. Hiển thị thông báo "Đăng ký thành công" và chuyển hướng đậ¿n trang đăng nhậ­p.<br>8. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 5a. Nhậ­p sai OTP: Cho phép nhậ­p lại tối đa 5 lần.<br>5b. Gửi lại OTP: Khách hàng yêu cầu gửi lại, hệ thống tạo OTP mới và gửi lại email. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 4a. Email tồn tại: Hệ thống báo lỗi email đÝđược sử dụng và yêu cầu nhậ­p email khác. |

### 8.1.3. Đăng nhậ­p
**Bảng 8.3: Đặc tả Use-case Đăng nhậ­p**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC57 |
| Tên Use-case | Đăng nhậ­p |
| Tác nhân | Tất cả người dùng |
| Mô tả | Cho phép người dùng truy cậ­p vào hệ thống bằng tài khoản đÝđược xác thực. |
| Tiền điều kiện | - Người dùng đÝcó tài khoản và đÝxác nhậ­n email. |
| Hậ­u điều kiện | - Phiên đăng nhậ­p (Session) được tạo, người dùng được cấp quyền truy cậ­p theo vai trò. |
| Luồng sự kiện chính | 1. Chọn "Đăng nhậ­p".<br>2. Nhậ­p Email/Username và Mậ­t khẩu.<br>3. Nhấn "Đăng nhậ­p".<br>4. Hệ thống đối chiậ¿u thông tin với CSDL.<br>5. Xác thực thành công, hệ thống tạo phiên (Session/Token).<br>6. Chuyển hướng người dùng đậ¿n Dashboard (nhân viên) hoặc Trang chủ (khách hàng).<br>7. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 2a. Quên mậ­t khẩu: Khách hàng nhấn "Quên mậ­t khẩu", hệ thống chuyển sang UC59. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 4a. Sai thông tin: Sai tên đăng nhậ­p hoặc mậ­t khẩu, hệ thống báo lỗi và yêu cầu nhậ­p lại. |

### 8.1.4. Đăng xuất
**Bảng 8.4: Đặc tả Use-case Đăng xuất**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC58 |
| Tên Use-case | Đăng xuất |
| Tác nhân | Tất cả người dùng |
| Mô tả | Người dùng chấm dứt phiên làm việc hiện tại và thoát khỏi hệ thống. |
| Tiền điều kiện | - Người dùng đang trong trạng thái đăng nhậ­p. |
| Hậ­u điều kiện | - Phiên làm việc bị hủy, yêu cầu đăng nhậ­p lại cho lần truy cậ­p tiậ¿p theo. |
| Luồng sự kiện chính | 1. Người dùng vào Menu tài khoản và chọn "Đăng xuất".<br>2. Hệ thống hủy phiên (Session), xóa Token/Cookie trên trình duyệt.<br>3. Hệ thống ghi log thời gian đăng xuất.<br>4. Chuyển hướng người dùng về trang đăng nhậ­p hoặc trang chủ khách khách.<br>5. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 1a. Đăng xuất mọi thiậ¿t bị: Người dùng chọn tùy chọn này trong cài đặt, hệ thống hủy toàn bộ phiên đăng nhậ­p của tài khoản trên tất cả thiậ¿t bị. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Không có. |

### 8.1.5. Quên mậ­t khẩu
**Bảng 8.5: Đặc tả Use-case Quên mậ­t khẩu**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC59 |
| Tên Use-case | Quên mậ­t khẩu |
| Tác nhân | Người dùng |
| Mô tả | Hỗ trợ người dùng khôi phục lại mậ­t khẩu truy cậ­p khi bị quên thông qua xác thực Email. |
| Tiền điều kiện | - Người dùng không thể đăng nhậ­p do quên mậ­t khẩu. |
| Hậ­u điều kiện | - Mậ­t khẩu mới được thiậ¿t lậ­p và lưu vào CSDL. |
| Luồng sự kiện chính | 1. Người dùng chọn "Quên mậ­t khẩu" tại màn hình đăng nhậ­p.<br>2. Nhậ­p địa chỉ Email đÝđăng ký và gửi yêu cầu.<br>3. Hệ thống kiểm tra Email hợp lệ, sinh mÝOTP và gửi đậ¿n Email đó.<br>4. Người dùng nhậ­p mÝOTP và Mậ­t khẩu mới, sau đó nhấn "Xác nhậ­n".<br>5. Hệ thống xác thực OTP hợp lệ.<br>6. MÝhóa mậ­t khẩu mới và cậ­p nhậ­t vào CSDL.<br>7. Hiển thị thông báo thành công và chuyển về trang đăng nhậ­p.<br>8. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 3a. Email không tồn tại: Báo lỗi không tìm thấy tài khoản.<br>5a. OTP không hợp lệ: OTP sai quá 5 lần hoặc hậ¿t hạn, hệ thống hủy quy trình khôi phục. |

### 8.1.6. Đổi mậ­t khẩu
**Bảng 8.6: Đặc tả Use-case Đổi mậ­t khẩu**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC60 |
| Tên Use-case | Đổi mậ­t khẩu |
| Tác nhân | Người dùng đÝđăng nhậ­p |
| Mô tả | Người dùng chủ động thay đổi mậ­t khẩu tài khoản để đảm bảo an toàn bảo mậ­t. |
| Tiền điều kiện | - Người dùng đang đăng nhậ­p vào hệ thống. |
| Hậ­u điều kiện | - Mậ­t khẩu được cậ­p nhậ­t thành công. |
| Luồng sự kiện chính | 1. Người dùng vào mục "Cài đặt tài khoản" và chọn "Đổi mậ­t khẩu".<br>2. Nhậ­p Mậ­t khẩu hiện tại, Mậ­t khẩu mới và Nhậ­p lại mậ­t khẩu mới.<br>3. Hệ thống kiểm tra mậ­t khẩu hiện tại.<br>4. Hệ thống gửi Email chứa mÝOTP xác nhậ­n thao tác.<br>5. Người dùng nhậ­p mÝOTP.<br>6. Hệ thống xác thực, cậ­p nhậ­t mậ­t khẩu mới vào CSDL.<br>7. Hiển thị thông báo thành công.<br>8. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 3a. Sai mậ­t khẩu cũ: Báo lỗi và yêu cầu nhậ­p lại.<br>6a. Sai OTP quá số lần quy định: Hủy thao tác đổi mậ­t khẩu. |

## 8.2. Quản lý tài khoản người dùng (Admin)

### 8.2.1. Quản lý tài khoản người dùng
**Bảng 8.7: Đặc tả Use-case Quản lý tài khoản người dùng (Overview)**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC61 |
| Tên Use-case | Quản lý tài khoản người dùng |
| Tác nhân | Quản trị viên (Admin) |
| Mô tả | Giao diện trung tâm cho phép Admin theo dõi và quản lý danh sách toàn bộ người dùng trong hệ thống (nhân viên, khách hàng). |
| Tiền điều kiện | - Quản trị viên đÝđăng nhậ­p và có quyền "Quản trị hệ thống". |
| Hậ­u điều kiện | - Hiển thị danh sách tài khoản chính xác theo dữ liệu. |
| Luồng sự kiện chính | 1. Quản trị viên truy cậ­p module "Quản lý tài khoản người dùng".<br>2. Hệ thống hiển thị danh sách dạng bảng (MÝNV/KH, Họ tên, Email, Vai trò, Trạng thái).<br>3. Quản trị viên có thể chọn các thao tác: Tìm kiậ¿m (UC66), Thêm mới (UC62), Cậ­p nhậ­t năng lực (UC63), Khóa/Mở/Xóa (UC64, UC65), Phân quyền (UC67).<br>4. Hệ thống thực thi các usecase tương ứng.<br>5. Sau khi thao tác hoàn tất, load lại danh sách mới nhất.<br>6. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Không có. |

### 8.2.2. Tạo tài khoản nhân viên
**Bảng 8.8: Đặc tả Use-case Tạo tài khoản nhân viên**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC62 |
| Tên Use-case | Tạo tài khoản nhân viên |
| Tác nhân | Quản trị viên |
| Mô tả | Quản trị viên khởi tạo tài khoản truy cậ­p hệ thống nội bộ cho nhân viên mới. |
| Tiền điều kiện | - Đang ở giao diện Quản lý tài khoản người dùng. |
| Hậ­u điều kiện | - Tài khoản nhân viên mới được tạo và email thông báo được gửi đi. |
| Luồng sự kiện chính | 1. Quản trị viên nhấn nút "Thêm mới".<br>2. Hệ thống hiển thị form nhậ­p liệu.<br>3. Quản trị viên điền các thông tin: Họ tên, Email công ty, Username, SĐT, Vai trò khởi tạo.<br>4. Nhấn "Lưu lại".<br>5. Hệ thống kiểm tra dữ liệu hợp lệ, tự động sinh mậ­t khẩu ngẫu nhiên.<br>6. Lưu bản ghi vào CSDL.<br>7. Gửi mậ­t khẩu qua email nội bộ cho nhân viên.<br>8. Hiển thị thông báo thành công và load lại danh sách.<br>9. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 5a. Trùng lặp dữ liệu: Email hoặc Username đÝtồn tại, hệ thống báo lỗi và yêu cầu đổi thông tin khác. |

### 8.2.3. Cậ­p nhậ­t năng lực nhân viên
**Bảng 8.9: Đặc tả Use-case Cậ­p nhậ­t năng lực nhân viên**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC63 |
| Tên Use-case | Cậ­p nhậ­t năng lực nhân viên |
| Tác nhân | Quản trị viên |
| Mô tả | Quản trị viên cậ­p nhậ­t thông tin về ngoại ngữ, chứng chỉ chuyên môn, thậ¿ mạnh của nhân viên nhằm phục vụ công tác điều phối tour. |
| Tiền điều kiện | - Đang ở giao diện quản lý chi tiậ¿t của một nhân viên. |
| Hậ­u điều kiện | - Thông tin năng lực của nhân viên được cậ­p nhậ­t vào CSDL. |
| Luồng sự kiện chính | 1. Quản trị viên chọn một nhân viên và chuyển sang tab "Quản lý năng lực".<br>2. Hệ thống hiển thị danh sách các năng lực/chứng chỉ hiện tại.<br>3. Quản trị viên nhấn "Thêm/Sửa năng lực".<br>4. Nhậ­p loại ngôn ngữ, cấp độ chứng chỉ hoặc mô tả thậ¿ mạnh.<br>5. Nhấn "Lưu thay đổi".<br>6. Hệ thống ghi nhậ­n vào CSDL và thông báo thành công.<br>7. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 3a. Xóa chứng chỉ: Quản trị viên chọn một chứng chỉ cũ và nhấn xóa. Hệ thống cậ­p nhậ­t loại bỏ. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Không có. |

### 8.2.4. Xóa/Khóa tài khoản
**Bảng 8.10: Đặc tả Use-case Xóa/Khóa tài khoản**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC64 |
| Tên Use-case | Xóa/Khóa tài khoản |
| Tác nhân | Quản trị viên |
| Mô tả | Quản trị viên vô hiệu hóa (Khóa) hoặc loại bỏ hoàn toàn (Xóa) tài khoản khỏi hệ thống khi nhân viên nghỉ việc hoặc vi phạm. |
| Tiền điều kiện | - Quản trị viên đang xem danh sách tài khoản. |
| Hậ­u điều kiện | - Tài khoản bị thay đổi trạng thái thành "Khóa" hoặc bị xóa vĩnh viễn khỏi CSDL. |
| Luồng sự kiện chính | 1. Quản trị viên chọn một tài khoản cụ thể.<br>2. Nhấn chọn nút "Khóa" hoặc "Xóa".<br>3. Hệ thống hiển thị hộp thoại xác nhậ­n cảnh báo.<br>4. Quản trị viên nhấn "Xác nhậ­n".<br>5. Hệ thống kiểm tra các ràng buộc dữ liệu.<br>6. Thực hiện đổi trạng thái (Locked) hoặc xóa cứng bản ghi trong CSDL.<br>7. Thông báo thành công.<br>8. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 5a. Lỗi ràng buộc dữ liệu khi xóa: Nậ¿u tài khoản nhân viên/khách hàng đang liên kậ¿t với các giao dịch, đơn đặt tour hoặc tour đang chạy, hệ thống chặn hành động Xóa, hiển thị cảnh báo và gợi ý chuyển sang hành động "Khóa". |

### 8.2.5. Mở khoá tài khoản
**Bảng 8.11: Đặc tả Use-case Mở khóa tài khoản**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC65 |
| Tên Use-case | Mở khóa tài khoản |
| Tác nhân | Quản trị viên |
| Mô tả | Khôi phục lại quyền truy cậ­p cho một tài khoản đang bị khóa. |
| Tiền điều kiện | - Có ít nhất một tài khoản ở trạng thái "Locked". |
| Hậ­u điều kiện | - Trạng thái tài khoản chuyển thành "Active". |
| Luồng sự kiện chính | 1. Quản trị viên lọc danh sách các tài khoản bị khóa.<br>2. Chọn tài khoản cần xử lý và nhấn "Mở khóa".<br>3. Hệ thống yêu cầu xác nhậ­n.<br>4. Quản trị viên xác nhậ­n thao tác.<br>5. Hệ thống thay đổi trạng thái tài khoản thành "Active" trong CSDL.<br>6. Hiển thị thông báo thành công.<br>7. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Không có. |

### 8.2.6. Tìm kiậ¿m tài khoản
**Bảng 8.12: Đặc tả Use-case Tìm kiậ¿m tài khoản**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC66 |
| Tên Use-case | Tìm kiậ¿m tài khoản |
| Tác nhân | Quản trị viên |
| Mô tả | Hỗ trợ admin tra cứu nhanh chóng một hoặc nhiều tài khoản theo tiêu chí cụ thể. |
| Tiền điều kiện | - Quản trị viên đang ở giao diện danh sách tài khoản. |
| Hậ­u điều kiện | - Hiển thị danh sách kậ¿t quả phù hợp. |
| Luồng sự kiện chính | 1. Quản trị viên nhậ­p thông tin vào thanh tìm kiậ¿m hoặc sử dụng bộ lọc (MÃ, Họ tên, Email, SĐT, Trạng thái).<br>2. Hệ thống truy vấn CSDL dựa trên tiêu chí.<br>3. Hệ thống trả về và hiển thị danh sách tài khoản phù hợp lên màn hình.<br>4. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | 3a. Không tìm thấy: Hiển thị thông báo "Không có tài khoản nào phù hợp" và gợi ý làm mới bộ lọc. |
| Luồng sự kiện lỗi hoặc ngoại lệ | Không có. |

## 8.3. Phân quyền và Giám sát

### 8.3.1. Phân quyền truy cậ­p
**Bảng 8.13: Đặc tả Use-case Phân quyền truy cậ­p**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC67 |
| Tên Use-case | Phân quyền truy cậ­p |
| Tác nhân | Quản trị viên |
| Mô tả | Gán các vai trò (Role) và quyền hạn (Permission) cụ thể cho tài khoản nhân viên, kiểm soát quyền truy cậ­p của họ đối với từng phân hệ trên ERP. |
| Tiền điều kiện | - Quản trị viên có đủ thẩm quyền phân quyền. |
| Hậ­u điều kiện | - Ma trậ­n phân quyền của nhân viên được cậ­p nhậ­t, áp dụng ngay ở lần đăng nhậ­p tiậ¿p theo. |
| Luồng sự kiện chính | 1. Quản trị viên chọn một tài khoản nhân viên và nhấn nút "Phân quyền".<br>2. Hệ thống hiển thị danh sách các vai trò (Role) và chi tiậ¿t các quyền hạn chức năng (Read, Write, Delete).<br>3. Quản trị viên xem xét và tích chọn/bỏ chọn các quyền hạn hoặc gán vai trò mới.<br>4. Nhấn "Lưu thiậ¿t lậ­p".<br>5. Hệ thống cậ­p nhậ­t bảng phân quyền trong CSDL.<br>6. Hiển thị thông báo cậ­p nhậ­t thành công.<br>7. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 1a. Thiậ¿u thẩm quyền: Nậ¿u admin hiện tại không được cấp phép thực hiện phân quyền, hệ thống chặn thao tác và báo lỗi từ chối truy cậ­p. |

### 8.3.2. Xem nhậ­t ký hệ thống
**Bảng 8.14: Đặc tả Use-case Xem nhậ­t ký hệ thống**

| Mục | Nội dung |
|---|---|
| MÝUse-case | UC68 |
| Tên Use-case | Xem nhậ­t ký hệ thống |
| Tác nhân | Quản trị viên |
| Mô tả | Tra cứu lịch sử hoạt động của người dùng (Audit Trail) và các lỗi hệ thống để giám sát bảo mậ­t, phục vụ truy vậ¿t khi có sự cố. |
| Tiền điều kiện | - Quản trị viên có quyền xem log hệ thống. |
| Hậ­u điều kiện | - Danh sách bản ghi log được hiển thị chính xác. |
| Luồng sự kiện chính | 1. Quản trị viên truy cậ­p module "Nhậ­t ký hệ thống".<br>2. Cấu hình các bộ lọc: Khoảng thời gian, Người dùng, Loại hành động (CRUD, Login), Mức độ (Info, Warning, Error).<br>3. Nhấn "Tìm kiậ¿m".<br>4. Hệ thống truy xuất dữ liệu từ bảng Log.<br>5. Hiển thị danh sách kậ¿t quả (Thời gian, User, Action, IP, Trạng thái).<br>6. Quản trị viên có thể nhấn xem chi tiậ¿t payload của từng log.<br>7. Kậ¿t thúc use case. |
| Luồng sự kiện phụ | Không có. |
| Luồng sự kiện lỗi hoặc ngoại lệ | 1a. Từ chối truy cậ­p: Nậ¿u quản trị viên không đủ thẩm quyền, hệ thống báo lỗi không có quyền truy cậ­p chức năng này. |