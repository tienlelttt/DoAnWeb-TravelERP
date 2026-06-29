# Phân hệ Quản lý sản phẩm và Tour

**Phạm vi:** UC01-UC20
---

## 3.2.1. Quản lý tour mẫu
Bảng 3.3: Đặc tả Use - case Quản lý tour mẫu
Mục Nội dung
UC01MÝUse - case
Tên Use - case Quản lý tour mẫu
Tác nhân Nhân viên sản phẩm
Mô tả Use case bao trùm các chức năng về quản lý tour mẫu
- Nhân viên đÝđăng nhậ­p vào hệ thống và có quyền truy cậ­p
Tiền điều kiện
vào trang Quản lý tour mẫu.
- Các thay đổi về dữ liệu tour mẫu được ghi nhậ­n chính xác
Hậ­u điều kiện
vào cơ sở dữ liệu.
### 1. Nhân viên truy cậ­p vào giao diện "Quản lý tour mẫu".
### 2. Hệ thống hiển thị danh sách các tour mẫu hiện có cùng
các tùy chọn chức năng.
### 3. Nhân viên xác định hành động muốn thực hiện:
- Nậ¿u chọn "Thêm tour mẫu", hệ thống thực hiện UC02:
Luồng sự kiện Thêm mới tour mẫu.
chính - Nậ¿u chọn "Sao chép tour mẫu", hệ thống thực hiện UC03:
Sao chép tour mẫu.
- Nậ¿u chọn "Cậ­p nhậ­t thông tin", hệ thống thực hiện UC04:
Cậ­p nhậ­t tour mẫu.
- Nậ¿u chọn "Xóa", hệ thống thực hiện UC05: Xóa tour mẫu.


- Nậ¿u chọn "Tra cứu tour mẫu", hệ thống thực hiện UC06:
Tra cứu tour mẫu.
### 4. Kậ¿t thúc Use Case.
Luồng sự kiện
Không có
phụ
Luồng sự kiện - Nhân viên sản phẩm thoát khỏi màn hình quản lý tour mẫu.
lỗi hoặc ngoại lệ Use Case dừng lại.
Activity diagram:





Sequence diagram:


### 3.2.1.2. Thêm mới tour mẫu
Bảng 3.4: Đặc tả Use - case Thêm mới tour mẫu
Mục Nội dung
MÝUse - case UC02
Tên Use - case Thêm mới tour mẫu
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên sản phẩm khởi tạo khung dữ liệu tour
Mô tả gốc (tour mẫu) bao gồm các thông tin định mức và giá sàn
để làm CSDL nền tảng cho việc triển khai chuyậ¿n đi thực tậ¿.
- Nhân viên đÝđăng nhậ­p vào hệ thống và có quyền truy cậ­p
Tiền điều kiện vào trang Quản lý tour mẫu.
- Nhân viên đang ở giao diện danh sách tour mẫu.
- Một bản ghi tour mẫu mới được tạo trong CSDL với mÃ
định danh duy nhất.
Hậ­u điều kiện
- Hệ thống hiển thị thông báo thành công và cậ­p nhậ­t danh
sách, sẵn sàng cho việc thiậ¿t lậ­p lịch trình chi tiậ¿t.
### 1. Nhân viên nhấn nút "Thêm tour mẫu" tại trang giao diện
quản lý.
### 2. Hệ thống hiển thị biểu mẫu nhậ­p liệu với các trường: Tiêu
đề, Mô tả, Thời lượng (Số ngày/đêm), Giá sàn.
Luồng sự kiện
### 3. Nhân viên cung cấp đầy đủ các thông tin bắt buộc vào
chính
biểu mẫu.
### 4. Sau khi nhân viên nhậ­p xong trường "Thời lượng", hệ
thống gọi thực thi UC08 - Thêm lịch trình tour để nhân viên
thiậ¿t lậ­p chi tiậ¿t hoạt động cho từng ngày.


### 5. Nhân viên nhấn nút "Lưu".
### 6. Hệ thống thực hiện kiểm tra tính hợp lệ của dữ liệu tour
mẫu và tính trọn vậ¹n của lịch trình đÝnhậ­p tại UC08.
### 7. Hệ thống tự động phát sinh mÝđịnh danh duy nhất cho
tour mẫu mới.
### 8. Hệ thống thực hiện lưu đồng bộ bản ghi tour mẫu vào
CSDL.
### 9. Hệ thống hiển thị thông báo "Thêm mới tour mẫu thành
công" và quay lại trang danh sách quản lý.
### 10. Kậ¿t thúc Use Case.
Luồng sự kiện Không có
phụ
6a. Nậ¿u thông tin thiậ¿u, sai định dạng hoặc lịch trình chưa
Luồng sự kiện hoàn tất, hệ thống báo lỗi và yêu cầu sửa lại tại bước 3.
lỗi hoặc ngoại lệ Nhân viên sản phẩm thoát khỏi màn hình thêm tour mẫu.
Use Case dừng lại.
Activity diagram:





Sequence diagram:


### 3.2.1.3. Sao chép tour mẫu
Bảng 3.5: Đặc tả Use - case Sao chép tour mẫu
Mục Nội dung
MÝUse - case UC03
Tên Use - case Sao chép tour mẫu
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên sản phẩm tạo nhanh một tour mẫu mới
Mô tả bằng cách kậ¿ thừa toàn bộ khung dữ liệu từ một tour mẫu có
sẵn.
- Nhân viên đÝđăng nhậ­p thành công vào hệ thống.
Tiền điều kiện
- Nhân viên đang ở giao diện danh sách tour mẫu.
- Một bản ghi tour mẫu mới được tạo trong CSDL với mÃ
Hậ­u điều kiện
định danh mới, kậ¿ thừa nội dung từ bản gốc.
### 1. Nhân viên tìm kiậ¿m và chọn một tour mẫu cần sao chép
từ danh sách.
### 2. Nhân viên nhấn nút â€œSao chép tour mẫuâ€.
### 3. Hệ thống truy xuất toàn bộ thông tin của tour mẫu gốc
(Tiêu đề, Mô tả, Thời lượng, Giá sàn).
Luồng sự kiện
### 4. Hệ thống hiển thị biểu mẫu nhậ­p liệu với các trường dữ
chính
liệu đÝđược điền sẵn thông tin từ tour mẫu gốc.
### 5. Nhân viên thực hiện điều chỉnh các thông tin cần thiậ¿t.
### 6. Nhân viên nhấn nút "Lưu".
### 7. Hệ thống thực hiện kiểm tra tính hợp lệ của dữ liệu và đối
soát trùng lặp tên tour.


### 8. Hệ thống tự động phát sinh mÝđịnh danh duy nhất cho
bản sao mới.
### 9. Hệ thống thực hiện lưu bản ghi mới vào CSDL và hiển thị
thông báo "Sao chép tour mẫu thành công" và quay về trang
danh sách tour mẫu.
### 10. Kậ¿t thúc Use Case.
Luồng sự kiện 5a. Nhân viên chọn â€œLịch trìnhâ€ chuyển sang giao diện
phụ "Quản lý lịch trình" để chỉnh sửa các hoạt động vừa kậ¿ thừa.
6a. Nậ¿u trùng lặp tiêu đề tour hoặc dữ liệu không hợp lệ, hệ
thống báo lỗi và yêu cầu sửa lại tại bước 5. Luồng sự kiện
lỗi hoặc ngoại lệ - Nhân viên sản phẩm thoát khỏi màn hình sao chép tour
mẫu. Use Case dừng lại.
Activity diagram:





Sequence diagram:


### 3.2.1.4. Sửa thông tin tour mẫu
Bảng 3.6: Đặc tả Use - case Sửa thông tin tour mẫu
Mục Nội dung
MÝUse - case UC04
Tên Use - case Sửa thông tin tour mẫu
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên sản phẩm điều chỉnh, cậ­p nhậ­t các thông
Mô tả
tin của tour mẫu.
Tiền điều kiện - Nhân viên phải đăng nhậ­p vào hệ thống.
- Thông tin thay đổi được cậ­p nhậ­t chính xác vào CSDL.
Hậ­u điều kiện
- Hệ thống hiển thị thông báo thành công.
### 1. Nhân viên thực hiện tra cứu một tour mẫu từ danh sách
quản lý.
### 2. Nhân viên nhấn nút "Chỉnh sửa thông tin".
### 3. Hệ thống kiểm tra ràng buộc để xác định tour mẫu này đÃ
được dùng để khởi tạo bất kỳ tour thực tậ¿ nào chưa.
### 4. Nậ¿u chưa có tour thực tậ¿ nào liên kậ¿t, hệ thống hiển thị
Luồng sự kiện biểu mẫu chỉnh sửa với toàn bộ thông tin hiện tại của tour.
chính 5. Nhân viên thực hiện thay đổi các thông tin cần thiậ¿t trên
các trường nhậ­p liệu (Tiêu đề, Mô tả, Thời lượng, Giá sàn).
### 6. Nhân viên nhấn nút "Lưu thay đổi".
### 7. Hệ thống thực hiện kiểm tra tính hợp lệ của dữ liệu và cậ­p
nhậ­t các thay đổi vào CSDL.
### 8. Hệ thống hiển thị thông báo "Cậ­p nhậ­t thông tin thành
công" và quay lại trang danh sách quản lý tour mẫu.


### 9. Kậ¿t thúc Use Case.
5a. Nhân viên chọn â€œSửa lịch trìnhâ€, hệ thống thực hiện
Luồng sự kiện
UC09 â€“ â€œSửa lịch trình tourâ€ để nhân viên chỉnh sửa các hoạt
phụ
động vừa kậ¿ thừa.
3a. Nậ¿u đÝcó tour thực tậ¿ được khởi tạo từ tour mẫu này, hệ
thống hiển thị thông báo và quay lại màn hình danh sách.
Luồng sự kiện 6a. Nậ¿u thông tin bị bỏ trống hoặc sai định dạng, hệ thống
lỗi hoặc ngoại lệ báo lỗi và yêu cầu sửa lại.
- Nhân viên sản phẩm thoát khỏi màn hình sửa tour mẫu.
Use Case dừng lại.
Activity diagram:





Sequence diagram:


### 3.2.1.5. Xóa tour mẫu
Bảng 3.7: Đặc tả Use - case Xóa tour mẫu
Mục Nội dung
MÝUse - case UC05
Tên Use - case Xóa tour mẫu
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên sản phẩm loại bỏ một tour mẫu khỏi hệ
Mô tả thống khi chương trình du lịch đó không còn phù hợp với
chiậ¿n lược kinh doanh hoặc bị nhậ­p lỗi.
- Nhân viên đÝđăng nhậ­p thành công vào hệ thống.
Tiền điều kiện
- Nhân viên đang ở giao diện danh sách tour mẫu.
- Thông báo xóa tour mẫu thành công và dữ liệu được cậ­p
Hậ­u điều kiện
nhậ­t trong CSDL.
### 1. Nhân viên tìm kiậ¿m và chọn tour mẫu cần loại bỏ từ danh
sách quản lý.
### 2. Nhân viên nhấn nút "Xóa".
### 3. Hệ thống thực hiện quy trình kiểm tra các ràng buộc dữ
liệu trong CSDL.
Luồng sự kiện 4. Hệ thống hiển thị hộp thoại xác thực yêu cầu nhân viên
chính xác nhậ­n lại quyậ¿t định xóa.
### 5. Nhân viên nhấn chọn nút "Xác nhậ­n".
### 6. Hệ thống thực hiện lệnh xóa bản ghi (tour mẫu, lịch trình)
tương ứng trong CSDL.
### 7. Hệ thống hiển thị thông báo "Xóa tour mẫu thành công"
và tự động làm mới trang danh sách quản lý.


### 8. Kậ¿t thúc Use Case.
Luồng sự kiện 5a. Nhân viên nhấn chọn nút â€œHủyâ€, hệ thống hủy thao tác
phụ xóa và đóng hộp thoại.
3a. Nậ¿u tour mẫu đÝđược sử dụng để khởi tạo tour thực tậ¿
hoặc có dữ liệu liên kậ¿t, hệ thống báo lỗi và từ chối xóa tại
Luồng sự kiện bước 1.
lỗi hoặc ngoại lệ - Nhân viên sản phẩm thoát khỏi màn hình xóa tour mẫu.
Use Case dừng lại.
Activity diagram:





Sequence diagram:


### 3.2.1.6. Tra cứu tour mẫu
Bảng 3.8: Đặc tả Use - case Tra cứu tour mẫu
Mục Nội dung
MÝUse - case UC06
Tên Use - case Tra cứu tour mẫu
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên sản phẩm tìm kiậ¿m và xem danh sách
Mô tả các chương trình tour mẫu hiện có trong hệ thống để thực
hiện các thao tác quản lý.
- Nhân viên phải đăng nhậ­p vào hệ thống.
Tiền điều kiện
- Nhân viên đang ở giao diện quản lý tour mẫu.
- Danh sách tour mẫu được hiển thị theo từ khóa hoặc tiêu
Hậ­u điều kiện
chí lọc.
### 1. Hệ thống hiển thị danh sách toàn bộ các tour mẫu hiện có
từ CSDL.
### 2. Nhân viên nhậ­p từ khóa tìm kiậ¿m (tên tour, mÝtour) hoặc
chọn bộ lọc (vùng miền, loại hình eco).
Luồng sự kiện
### 3. Hệ thống thực hiện truy vấn và lọc các bản ghi trùng khớp
chính
với yêu cầu.
### 4. Hệ thống hiển thị kậ¿t quả lọc trên giao diện bao gồm: Tên
tour, Giá sàn, Thời lượng.
### 5. Kậ¿t thúc Use Case.
Luồng sự kiện 4a. Nậ¿u không tìm thấy bản ghi nào phù hợp, hệ thống hiển
phụ thị thông báo "Không tìm thấy kậ¿t quả"


Luồng sự kiện - Nhân viên sản phẩm thoát khỏi màn hình thêm tour mẫu.
lỗi hoặc ngoại lệ Use Case dừng lại.
Activity diagram:
Sequence diagram:





## 3.2.2. Quản lý lịch trình tour
Bảng 3.9: Đặc tả Use - case Quản lý lịch trình tour
Mục Nội dung
MÝUse - case UC07
Tên Use - case Quản lý lịch trình tour
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên thiậ¿t lậ­p và duy trì các hoạt động chi tiậ¿t
Mô tả
theo từng ngày (lịch trình) cho một tour mẫu cụ thể.
- Nhân viên đÝđăng nhậ­p vào hệ thống và có quyền truy cậ­p
Tiền điều kiện
vào trang Quản lý lịch trình tour.
- Các hoạt động lịch trình được lưu trữ và liên kậ¿t chính xác
Hậ­u điều kiện
với mÝtour mẫu trong cơ sở dữ liệu.
### 1. Nhân viên chọn chức năng, một trong các luồng sau sậ½
được thực thi:
- Nậ¿u chọn "Thêm lịch trình", hệ thống thực hiện UC08:
Luồng sự kiện
Thêm lịch trình tour.
chính
- Nậ¿u chọn "Sửa lịch trình", hệ thống thực hiện UC09: Sửa
lịch trình tour.
### 5. Kậ¿t thúc Use Case.
Luồng sự kiện Không có
phụ
Luồng sự kiện - Nhân viên sản phẩm thoát khỏi màn hình quản lý lịch trình
lỗi hoặc ngoại lệ tour. Use Case dừng lại.


Activity diagram:
Sequence diagram:


### 3.2.2.2. Thêm lịch trình tour
Bảng 3.10: Đặc tả Use - case Thêm lịch trình tour
Mục Nội dung
MÝUse - case UC08
Tên Use - case Thêm lịch trình tour
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên sản phẩm thiậ¿t lậ­p chi tiậ¿t các hoạt động,
Mô tả điểm tham quan và thực đơn theo từng ngày cho một tour
mẫu cụ thể.
- Nhân viên đÝđăng nhậ­p và có quyền truy cậ­p chức năng
Quản lý lịch trình.
Tiền điều kiện
- Sau khi nhân viên nhậ­p trường thời lượng trong phần thêm
tour mẫu.
Hậ­u điều kiện - Các bản ghi lịch trình mới được lưu vào CSDL.
### 1. Nhân viên truy cậ­p vào chức năng thêm lịch trình.
### 2. Hệ thống hiển thị biểu mẫu nhậ­p thông tin lịch trình.
### 3. Nhân viên lần lượt nhậ­p nội dung chi tiậ¿t cho từng ngày
trong các phân đoạn vừa sinh ra gồm tiêu đề hoạt động
Luồng sự kiện chính của ngày, mô tả chi tiậ¿t lịch trình, thông tin thực
chính đơn.
### 4. Nhân viên rà soát lại toàn bộ các ngày và nhấn nút "Lưu"
(tại UC02) để xác nhậ­n hoàn tất.
### 5. Hệ thống thực hiện kiểm tra tính trọn vậ¹n của dữ liệu (đảm
bảo không có ngày nào bị bỏ trống).


### 6. Hệ thống tự động phát sinh mÝđịnh danh duy nhất cho
lịch trình mới.
### 7. Hệ thống thực hiện ghi các bản ghi lịch trình vào CSDL
liên kậ¿t với mÝtour mẫu tương ứng.
### 8. Hệ thống thông báo thành công và trả về danh sách lịch
trình.
### 9. Kậ¿t thúc Use Case.
Luồng sự kiện Không có
phụ
5a. Nậ¿u phát hiện có phân đoạn chưa được nhậ­p nội dung,
hệ thống báo lỗi và yêu cầu nhân viên bổ sung. Luồng sự kiện
lỗi và ngoại lệ - Nhân viên sản phẩm thoát khỏi màn hình thêm lịch trình
tour. Use Case dừng lại.
Activity diagram:


Sequence diagram:





### 3.2.2.3. Sửa lịch trình tour
Bảng 3.11: Đặc tả Use - case Sửa lịch trình tour
Mục Nội dung
MÝUse - case UC09
Tên Use - case Sửa lịch trình tour
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên điều chỉnh nội dung các hoạt động, điểm
Mô tả tham quan hoặc thực đơn của từng ngày trong một tour thực
tậ¿.
- Nhân viên đÝđăng nhậ­p và có quyền truy cậ­p chức năng
Tiền điều kiện Quản lý lịch trình.
- ĐÝchọn một tour mẫu cụ thể từ danh sách quản lý.
Hậ­u điều kiện - Các thay đổi về dữ liệu được cậ­p nhậ­t vào CSDL.
### 1. Nhân viên nhấn vào sửa một lịch trình.
### 2. Hệ thống hiển thị biểu mẫu với các thông tin hiện tại.
### 3. Nhân viên thực hiện các thay đổi nội dung cần thiậ¿t trên
biểu mẫu.
Luồng sự kiện
### 4. Nhân viên nhấn nút "Lưu thay đổi".
chính
### 5. Hệ thống thực hiện kiểm tra tính hợp lệ của dữ liệu (đảm
bảo không bỏ trống các trường bắt buộc).
### 6. Hệ thống ghi nhậ­n các thay đổi và cậ­p nhậ­t trực tiậ¿p vào
bản ghi lịch trình của riêng tour thực tậ¿ đó trong CSDL.


### 7. Hệ thống hiển thị thông báo "Cậ­p nhậ­t lịch trình ngày
thành công" và trả về danh sách lịch trình mới.
### 8. Kậ¿t thúc Use Case.
Luồng sự kiện Không có.
phụ
5a. Nậ¿u thông tin không hợp lệ, hệ thống báo lỗi và yêu cầu
Luồng sự kiện sửa lại.
lỗi và ngoại lệ - Nhân viên sản phẩm thoát khỏi màn hình sửa lịch trình
tour. Use Case dừng lại.
Activity diagram:


Sequence diagram:


## 3.2.3. Quản lý tour thực tậ¿
Bảng 3.12: Đặc tả Use - case Quản lý tour thực tậ¿
Mục Nội dung
MÝUse - case UC10
Tên Use - case Quản lý tour thực tậ¿
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên quản lý danh sách các chuyậ¿n tour thực
Mô tả
tậ¿, bao gồm khởi tạo chuyậ¿n đi từ tour mẫu, điều chỉnh thông


tin vậ­n hành, tra cứu và loại bỏ các chuyậ¿n tour không còn
phù hợp.
- Nhân viên phải đăng nhậ­p vào hệ thống.
- Nhân viên đÝchọn chức năng â€œQuản lý chuyậ¿n tour thực
Tiền điều kiện
tậ¿â€.
- ĐÝcó dữ liệu tour mẫu trong hệ thống.
- Một bản ghi tour thực tậ¿ mới được lưu với trạng thái â€œChờ
Hậ­u điều kiện
kích hoạtâ€.
### 1. Hệ thống hiển thị danh sách các chuyậ¿n tour thực tậ¿ hiện
có cùng bộ lọc tìm kiậ¿m.
### 2. Hệ thống yêu cầu Nhân viên xác định chức năng muốn
thực hiện.
### 3. Khi Nhân viên chọn chức năng, một trong các Use Case
con tương ứng sậ½ được thực thi:
- Nậ¿u chọn "Khởi tạo chuyậ¿n tour", thực hiện UC11: Khởi
Luồng sự kiện
tạo tour thực tậ¿ từ tour mẫu.
chính
- Nậ¿u chọn "Xóa tour thực tậ¿", thực hiện UC12: Xóa tour
thực tậ¿.
- Nậ¿u chọn "Sửa tour thực tậ¿", thực hiện UC13: Sửa tour
thực tậ¿.
- Nậ¿u chọn "Tra cứu tour thực tậ¿", thực hiện UC14: Tra cứu
tour thực tậ¿.
### 4. Kậ¿t thúc Use Case.


Luồng sự kiện Không có
phụ
Luồng sự kiện - Nhân viên sản phẩm thoát khỏi màn hình quản lý tour thực
lỗi và ngoại lệ tậ¿. Use Case dừng lại.
Activity Diagram:


Sequence diagram:


### 3.2.3.1. Khởi tạo tour thực tậ¿ từ tour mẫu
Bảng 3.13: Đặc tả Use - case Khởi tạo tour thực tậ¿ từ tour mẫu
Mục Nội dung
MÝUse - case UC11
Tên Use - case Khởi tạo tour thực tậ¿ từ tour mẫu
Tác nhân Nhân viên sản phẩm


Cho phép nhân viên thực hiện khởi tạo một chuyậ¿n đi cụ thể
Mô tả dựa trên khung chương trình của một tour mẫu có sẵn và
thiậ¿t lậ­p các thông số vậ­n hành của tour.
- Nhân viên phải đăng nhậ­p vào hệ thống.
Tiền điều kiện - Nhân viên đÝchọn chức năng â€œQuản lý tour thực tậ¿â€.
- ĐÝcó dữ liệu tour mẫu trong hệ thống.
- Một bản ghi tour thực tậ¿ mới được lưu với trạng thái â€œChờ
Hậ­u điều kiện
kích hoạtâ€.
### 1. Nhân viên nhấn nút "Khởi tạo chuyậ¿n tour" tại trang Quản
lý tour thực tậ¿.
### 2. Hệ thống hiển thị danh sách các tour mẫu khả dụng.
### 3. Nhân viên tìm kiậ¿m và chọn một tour mẫu để làm CSDL
gốc.
### 4. Hệ thống tự động trích xuất các thông tin định mức từ tour
mẫu và toàn bộ lịch trình chi tiậ¿t của tour.
Luồng sự kiện 5. Nhân viên nhậ­p các thông tin vậ­n hành: Ngày khởi hành,
chính Ngày về, Phương tiện, Số chỗ tối đa, Giá bán hiện hành.
### 6. Nhân viên nhấn nút "Xác nhậ­n khởi tạo".
### 7. Hệ thống thực hiện kiểm tra tính hợp lệ của dữ liệu và đối
soát quy tắc giá sàn với tour mẫu.
### 8. Hệ thống thực hiện lưu bản ghi vào CSDL.
### 9. Hệ thống hiển thị thông báo "Khởi tạo chuyậ¿n tour thành
công" và chuyển trạng thái chuyậ¿n tour sang "Chờ kích
hoạt".


### 10. Kậ¿t thúc Use Case.
Luồng sự kiện Không có.
phụ
7a. Nậ¿u thông tin không hợp lệ, hệ thống báo lỗi và yêu cầu
Luồng sự kiện sửa lại.
lỗi và ngoại lệ - Nhân viên thoát khỏi màn hình khởi tạo tour. Use Case
dừng lại.
Activity diagram:





Sequence diagram:
### 3.2.3.2. Xóa tour thực tậ¿
Bảng 3.14: Đặc tả Use - case Xóa tour thực tậ¿
Mục Nội dung
MÝUse - case UC12
Tên Use - case Xóa tour thực tậ¿


Tác nhân Nhân viên sản phẩm
Cho phép nhân viên loại bỏ một chuyậ¿n tour thực tậ¿ ra khỏi
Mô tả
hệ thống.
- Nhân viên phải đăng nhậ­p vào hệ thống.
Tiền điều kiện
- Nhân viên đÝchọn chức năng â€œQuản lý tour thực tậ¿â€.
- Bản ghi chuyậ¿n tour thực tậ¿ bị xóa khỏi danh sách hiển thị,
Hậ­u điều kiện
quỹ chỗ và nguồn lực liên quan được giải phóng.
### 1. Nhân viên tìm kiậ¿m và chọn chuyậ¿n tour thực tậ¿ cần xử
lý trong danh sách quản lý.
### 2. Nhân viên nhấn nút "Xóa".
### 3. Hệ thống kiểm tra điều kiện xóa.
### 4. Hệ thống hiển thị hộp thoại xác nhậ­n: "Bạn có chắc chắn
muốn xóa vĩnh viễn chuyậ¿n tour này?".Luồng sự kiện
chính 5. Nhân viên nhấn "Xác nhậ­n".
### 6. Hệ thống thực hiện xóa bản ghi trong CSDL và giải phóng
các nguồn lực liên quan.
### 7. Hệ thống hiển thị thông báo "Xóa chuyậ¿n tour thành
công" và làm mới danh sách.
### 8. Kậ¿t thúc Use Case.
4a. Nậ¿u đơn hàng đÝcó khách đặt, hệ thống hiển thị bảng
phân tích tác động, nhân viên nhậ­p lý do xóa, hệ thống thực
Luồng sự kiện
hiện chức năng hủy tour và quay lại bước 7.
phụ
5a. Nhân viên nhấn chọn nút â€œHủyâ€, hệ thống hủy thao tác
xóa và đóng hộp thoại.


3a. Nậ¿u tour đÝhoàn thành hoặc đang trong quá trình vậ­n
Luồng sự kiện hành, hệ thống hiển thị lỗi và từ chối thực hiện lệnh xóa.
lỗi và ngoại lệ - Nhân viên thoát khỏi màn hình xóa tour. Use Case dừng
lại.
Activity diagram:





Sequence diagram:





### 3.2.3.3. Sửa tour thực tậ¿
Bảng 3.15: Đặc tả Use - case Sửa tour thực tậ¿
Mục Nội dung
MÝUse - case UC13
Tên Use - case Sửa tour thực tậ¿
Tác nhân Nhân viên sản phẩm, Nhân viên kinh doanh.
- Nhân viên điều chỉnh các thông tin vậ­n hành hoặc cậ­p nhậ­t
Mô tả
giá hiện hành để tối ưu kinh doanh.
- Nhân viên đÝđăng nhậ­p thành công vào hệ thống.
Tiền điều kiện - Nhân viên đang ở giao diện danh sách Quản lý tour thực
tậ¿.
- Thông tin thay đổi được cậ­p nhậ­t chính xác vào CSDL và
Hậ­u điều kiện
hệ thống hiển thị thông báo thành công.
### 1. Nhân viên tìm kiậ¿m và chọn chuyậ¿n tour thực tậ¿ cần chỉnh
sửa từ danh sách.
### 2. Nhân viên nhấn nút "Cậ­p nhậ­t".
### 3. Hệ thống kiểm tra trạng thái tour và hiển thị biểu mẫu với
Luồng sự kiện
các ràng buộc tương ứng:
chính
- Trạng thái "Chờ kích hoạt": Tất cả các trường đều có thể
chỉnh sửa.
- Trạng thái "Đang vậ­n hành": Hệ thống khóa các trường:
Ngày khởi hành, Phương tiện, Giá tiền.


- Trạng thái "ĐÝhoàn thành": Khóa toàn bộ biểu mẫu, chỉ
cho phép xem.
### 4. Nhân viên thực hiện các thay đổi trên các trường được
phép nhậ­p liệu.
### 5. Nhân viên nhấn nút "Lưu thay đổi".
### 6. Hệ thống thực hiện kiểm tra tính hợp lệ của dữ liệu và các
quy tắc ràng buộc tài chính (Giá bán > Giá sàn).
### 7. Hệ thống cậ­p nhậ­t thông tin mới vào CSDL.
### 8. Hệ thống hiển thị thông báo "Cậ­p nhậ­t thông tin chuyậ¿n
tour thành công".
### 9. Hệ thống tự động làm mới danh sách và quay lại màn hình
quản lý.
### 10. Kậ¿t thúc Use Case.
Luồng sự kiện Không có.
phụ
6a. Nậ¿u dữ liệu không hợp lệ, hệ thống báo lỗi và yêu cầu
Luồng sự kiện nhân viên sửa lại.
lỗi và ngoại lệ - Nhân viên thoát khỏi màn hình chỉnh sửa tour. Use Case
dừng lại.
Activity diagram:





Sequence diagram:


### 3.2.3.4. Tra cứu tour thực tậ¿
Bảng 3.16: Đặc tả Use - case Tra cứu tour thực tậ¿
Mục Nội dung
MÝUse - case UC14
Tên Use - case Tra cứu tour thực tậ¿
Tác nhân Nhân viên
Cho phép nhân viên tra cứu các chuyậ¿n đi cụ thể dựa trên
Mô tả ngày khởi hành, phương tiện hoặc tình trạng quỹ chỗ để
quản lý vậ­n hành.
- Nhân viên phải đăng nhậ­p vào hệ thống.
Tiền điều kiện
- Nhân viên đang ở giao diện Quản lý chuyậ¿n tour thực tậ¿.
Hậ­u điều kiện - Hiển thị các chuyậ¿n tour phù hợp với điều kiện tìm kiậ¿m.
### 1. Hệ thống hiển thị danh sách các chuyậ¿n tour thực tậ¿ sắp
khởi hành.
### 2. Nhân viên nhậ­p từ khóa (tên tour mẫu gốc) hoặc lọc theo:
Khoảng ngày đi, phương tiện hoặc khoảng giá bán.
Luồng sự kiện
chính 3. Hệ thống đối soát dữ liệu trong CSDL.
### 4. Hệ thống hiển thị danh sách kậ¿t quả gồm: Ngày khởi
hành, phương tiện, giá hiện hành và số chỗ trống.
### 5. Kậ¿t thúc Use Case.
4a. Nậ¿u không tìm thấy chuyậ¿n tour nào phù hợp, hệ thống
Luồng sự kiện
hiển thị thông báo "Không tìm thấy kậ¿t quả" và quay lại
phụ
bước 2.


Luồng sự kiện - Nhân viên thoát khỏi màn hình tra cứu. Use Case dừng lại.
lỗi và ngoại lệ
Activity diagram:
Sequence diagram:





## 3.2.4. Quản lý dịch vụ bổ sung
Bảng 3.17: Đặc tả Use - case Quản lý dịch vụ bổ sung
Mục Nội dung
MÝUse - case UC15
Tên Use - case Quản lý dịch vụ bổ sung
Tác nhân Nhân viên sản phẩm, Nhân viên kậ¿ toán
Cho phép nhân viên quản lý danh mục các dịch vụ đi kèm
Mô tả
(phòng khách sạn, hoạt động giải trí,...).
- Nhân viên đÝđăng nhậ­p vào hệ thống và có quyền quản lý
Tiền điều kiện danh mục dịch vụ.
- Nhân viên đÝđang ở giao diện tour thực tậ¿ tương ứng.
- Danh mục dịch vụ bổ sung được cậ­p nhậ­t chính xác trong
Hậ­u điều kiện
CSDL để hiển thị trên giao diện Đặt hàng của khách hàng.
### 1. Nhân viên truy cậ­p chức năng â€œQuản lý danh mục dịch
vụâ€.
### 2. Hệ thống hiển thị danh sách các dịch vụ hiện có (bao gồm
cả loại phòng và dịch vụ thêm).
Luồng sự kiện 3. Hệ thống yêu cầu nhân viên xác định chức năng muốn
thực hiện.chính
### 4. Khi nhân viên chọn chức năng, một trong các luồng tương
ứng sậ½ được thực thi:
- Nậ¿u chọn "Thêm dịch vụ", hệ thống thực hiện UC16:
Thêm dịch vụ.


- Nậ¿u chọn "Sửa dịch vụ", hệ thống thực hiện UC17: Sửa
thông tin dịch vụ.
- Nậ¿u chọn "Xóa dịch vụ", hệ thống thực hiện UC18: Xóa
dịch vụ.
- Nậ¿u chọn "Tra cứu dịch vụ", hệ thống thực hiện UC19: Tra
cứu dịch vụ.
### 5. Kậ¿t thúc Use Case.
Luồng sự kiện Không có
phụ
Luồng sự kiện - Nhân viên thoát khỏi màn hình quản lý. Use Case dừng lại.
lỗi và ngoại lệ
Activity Diagram:


Sequence diagram:





### 3.2.4.1. Thêm dịch vụ
Bảng 3.18: Đặc tả Use - case Thêm dịch vụ
Mục Nội dung
MÝUse - case UC16
Tên Use - case Thêm dịch vụ
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên sản phẩm khởi tạo các loại hình dịch vụ
Mô tả bổ sung mới (như hạng phòng khách sạn, các hoạt động vui
chơi) vào danh mục hệ thống.
- Nhân viên phải đăng nhậ­p vào hệ thống.
Tiền điều kiện - Nhân viên đÝkhởi tạo thành công tour thực tậ¿ và đang ở
giao diện tour thực tậ¿ tương ứng.
- Một bản ghi dịch vụ mới được tạo trong CSDL.
Hậ­u điều kiện - Hệ thống hiển thị thông báo thành công và cậ­p nhậ­t danh
sách hiển thị.
### 1. Nhân viên nhấn nút "Thêm dịch vụ" cho tour.
### 2. Hệ thống hiển thị biểu mẫu nhậ­p liệu với các trường: Tên
dịch vụ, Phân loại (Loại phòng / Dịch vụ thêm), Đơn giá,
Đơn vị tính.
Luồng sự kiện
### 3. Nhân viên cung cấp đầy đủ các thông tin bắt buộc vào
chính
biểu mẫu.
### 4. Nhân viên nhấn nút "Lưu dịch vụ".
### 5. Hệ thống thực hiện kiểm tra tính hợp lệ của dữ liệu (kiểm
tra rỗng, định dạng số dương cho đơn giá).


### 6. Hệ thống tự động phát sinh mÝđịnh danh duy nhất cho
dịch vụ mới.
### 7. Hệ thống thực hiện lưu bản ghi mới vào CSDL.
### 8. Hệ thống hiển thị thông báo thành công.
### 9. Kậ¿t thúc Use Case.
Luồng sự kiện Không có
phụ
5a. Nậ¿u thông tin nhậ­p không hợp lệ, hệ thống yêu cầu nhân
Luồng sự kiện viên chỉnh sửa lại tại bước 3.
lỗi và ngoại lệ - Nhân viên thoát khỏi màn hình thêm dịch vụ. Use Case
dừng lại.
Activity diagram:





Sequence diagram:


### 3.2.4.2. Sửa thông tin dịch vụ
Bảng 3.19: Đặc tả Use - case Sửa thông tin dịch vụ
Mục Nội dung
MÝUse - case UC17
Tên Use - case Sửa thông tin dịch vụ
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên điều chỉnh các thông tin hiện có của
Mô tả
dịch vụ bổ sung (tên dịch vụ, đơn giá, đơn vị tính).
- Nhân viên đÝđăng nhậ­p thành công vào hệ thống.
Tiền điều kiện
- Nhân viên đÝđang ở giao diện tour thực tậ¿ tương ứng.
- Các thông tin thay đổi được cậ­p nhậ­t chính xác vào CSDL.
Hậ­u điều kiện
- Hệ thống hiển thị thông báo thành công.
### 1. Nhân viên nhấn vào một dịch vụ cần chỉnh sửa.
### 2. Nhân viên nhấn nút "Chỉnh sửa".
### 3. Hệ thống kiểm tra ràng buộc để xác định dịch vụ này đÃ
phát sinh giao dịch nào chưa.
Luồng sự kiện 4. Nậ¿u dịch vụ chưa phát sinh giao dịch, hệ thống hiển thị
chính biểu mẫu chỉnh sửa với toàn bộ thông tin hiện tại của dịch
vụ đó: Tên dịch vụ, Phân loại, Đơn giá, Đơn vị tính.
### 5. Nhân viên thực hiện các thay đổi cần thiậ¿t trên các trường
nhậ­p liệu.
### 6. Nhân viên nhấn nút "Lưu thay đổi".


### 7. Hệ thống thực hiện kiểm tra tính hợp lệ của dữ liệu (kiểm
tra rỗng, định dạng số dương cho đơn giá).
### 8. Hệ thống thực hiện cậ­p nhậ­t các thay đổi vào CSDL cho
bản ghi tương ứng.
### 9. Hệ thống hiển thị thông báo â€œCậ­p nhậ­t thông tin dịch vụ
thành côngâ€.
### 10. Kậ¿t thúc Use Case.
Luồng sự kiện Không có.
phụ
3a. Nậ¿u dịch vụ đÝphát sinh giao dịch, hệ thống từ chối thực
hiện chỉnh sửa dịch vụ và quay lại màn hình quản lý dịch vụ.
Luồng sự kiện 6a. Nậ¿u thông tin nhậ­p không hợp lệ, hệ thống yêu cầu nhân
lỗi và ngoại lệ viên chỉnh sửa lại tại bước 4.
- Nhân viên thoát khỏi màn hình sửa dịch vụ. Use Case dừng
lại.
Activity diagram:





Sequence diagram:
### 3.2.4.3. Xóa dịch vụ
Bảng 3.20: Đặc tả Use - case Xóa dịch vụ
Mục Nội dung
MÝUse - case UC18
Tên Use - case Xóa dịch vụ


Tác nhân Nhân viên sản phẩm
Cho phép nhân viên loại bỏ một dịch vụ bổ sung hoặc loại
Mô tả
phòng ra khỏi tour thực tậ¿.
- Nhân viên đÝđăng nhậ­p thành công vào hệ thống.
Tiền điều kiện
- Nhân viên đÝđang ở giao diện tour thực tậ¿ tương ứng.
- Thông tin thay đổi được cậ­p nhậ­t chính xác vào CSDL và
Hậ­u điều kiện
hệ thống hiển thị thông báo thành công.
### 1. Nhân viên nhấn vào biểu tượng â€œXóaâ€ trên một dịch vụ
cần xóa.
### 2. Hệ thống thực hiện quy trình kiểm tra các ràng buộc dữ
liệu trong CSDL.
### 3. Hệ thống xác định dịch vụ chưa từng phát sinh giao dịch
(Số lượng đơn hàng liên quan = 0).
Luồng sự kiện
### 4. Hệ thống hiển thị hộp thoại xác nhậ­n xóa vĩnh viễn.
chính
### 5. Nhân viên nhấn chọn nút "Xác nhậ­n".
### 6. Hệ thống thực hiện lệnh xóa bản ghi tương ứng trong
CSDL .
### 7. Hệ thống hiển thị thông báo "Xóa dịch vụ thành công" và
tự động làm mới trang danh sách quản lý.
### 8. Kậ¿t thúc Use Case.
2a. Nậ¿u dịch vụ đÝphát sinh giao dịch, hệ thống hiển thị
Luồng sự kiện thông báo lỗi và từ chối thực hiện lệnh xóa.
phụ 4a. Nhân viên nhấn chọn nút â€œHủyâ€, hệ thống hủy thao tác
xóa và đóng hộp thoại.


Luồng sự kiện - Nhân viên thoát khỏi màn hình xóa dịch vụ. Use Case dừng
lỗi và ngoại lệ lại.
Activity diagram:
Sequence diagram:


### 3.2.4.4. Tra cứu dịch vụ
Bảng 3.21: Đặc tả Use - case Tra cứu dịch vụ
Mục Nội dung
MÝUse - case UC19
Tên Use - case Tra cứu dịch vụ
Tác nhân Nhân viên sản phẩm, Nhân viên kinh doanh.
Cho phép nhân viên tra cứu danh mục các loại phòng và dịch
Mô tả
vụ bổ sung dựa trên tên, phân loại hoặc đơn giá.


- Nhân viên phải đăng nhậ­p vào hệ thống.
Tiền điều kiện
- Nhân viên đang ở giao diện Quản lý dịch vụ bổ sung.
- Hiển thị danh sách các dịch vụ hoặc loại phòng phù hợp
Hậ­u điều kiện
với tiêu chí tìm kiậ¿m.
### 1. Hệ thống hiển thị danh sách toàn bộ các loại phòng và
dịch vụ bổ sung đang có trong hệ thống.
### 2. Nhân viên thực hiện lọc theo tiêu chí: Phân loại.
### 3. Hệ thống thực hiện đối soát dữ liệu trong CSDL. Luồng sự kiện
### 4. Hệ thống hiển thị danh sách kậ¿t quả gồm: MÝdịch vụ, chính
Tên dịch vụ, Phân loại, Đơn giá/Phụ thu, Đơn vị tính và
Trạng thái.
### 5. Kậ¿t thúc Use Case.
Luồng sự kiện 4a. Nậ¿u không tìm thấy dịch vụ nào phù hợp, hệ thống hiển
phụ thị thông báo "Không tìm thấy kậ¿t quả".
Luồng sự kiện - Nhân viên thoát khỏi màn hình tra cứu. Use Case dừng lại.
lỗi và ngoại lệ
Activity diagram:


Sequence diagram:





## 3.2.5. Cấu hình hành động xanh cho tour
Bảng 3.22: Đặc tả Use - case Cấu hình hành động xanh cho tour
Mục Nội dung
MÝUse - case UC20
Tên Use - case Cấu hình hành động xanh cho tour
Tác nhân Nhân viên sản phẩm
Cho phép nhân viên sản phẩm thiậ¿t lậ­p danh sách các hành
động xanh (kèm điểm thưởng) sậ½ được áp dụng cho một tour
Mô tả cụ thể. Các hành động này sậ½ được sử dụng để HDV xác
nhậ­n và cộng điểm cho khách hàng trong quá trình vậ­n hành
tour.
- Nhân viên sản phẩm đÝđăng nhậ­p vào hệ thống và có
Tiền điều kiện quyền truy cậ­p phân hệ Quản lý sản phẩm.
- Hệ thống hiển thị màn hình chi tiậ¿t tour thực tậ¿.
- Danh sách hành động xanh được gán cho tour được lưu
trong CSDL.
Hậ­u điều kiện
- Các hành động này sậ½ xuất hiện trong ứng dụng của HDV
khi vậ­n hành tour đó.
### 1. Nhân viên nhấn nút "Cấu hình hành động xanh".
### 2. Hệ thống hiển thị danh sách tất cả hành động xanh có sẵn
trong hệ thống, mỗi hành động có checkbox và ô nhậ­p điểm
Luồng sự kiện
thưởng (mặc định hiển thị điểm từ danh mục, có thể điều
chính
chỉnh).
### 3. Nhân viên tích chọn các hành động muốn áp dụng cho
tour, có thể điều chỉnh điểm thưởng nậ¿u cần.


### 4. Hệ thống kiểm tra tính hợp lệ của dữ liệu (điểm thưởng
phải > 0, không trùng lặp).
### 5. Nhân viên nhấn nút "Lưu".
### 6. Hệ thống hiển thị thông báo thành công.
### 7. Kậ¿t thúc Use Case.
Luồng sự kiện
Không có.
phụ
6a. Nậ¿u thông tin không hợp lệ, hệ thống thông báo lỗi và
Luồng sự kiện yêu cầu nhân viên điều chỉnh lại.
lỗi và ngoại lệ - Nhân viên thoát khỏi màn hình cấu hình. Use Case dừng
lại.
Activity diagram:


Sequence diagram:


