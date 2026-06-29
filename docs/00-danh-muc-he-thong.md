# Danh mục Hệ thống, Actor và Use-case

Tài liệu này tổng hợp toàn bộ danh sách các tác nhân (Actor) và các ca sử dụng (Use-case) của hệ thống Digital Travel ERP, đóng vai trò như một bản đồ tra cứu chung cho các phân hệ nghiệp vụ.

## 1. Danh sách Tác nhân (Actor)

Hệ thống được thiậ¿t kậ¿ với 10 Actor chính tham gia vào các quá trình vậ­n hành:

| STT | Tên Actor | Mô tả |
|---|---|---|
| 1 | Khách hàng | Người sử dụng cuối của hệ thống, thực hiện tra cứu, đặt tour, thanh toán, quản lý Hộ chiậ¿u số và tương tác với dịch vụ sau bán hàng. |
| 2 | Nhân viên | Tác nhân tổng quát đại diện cho tất cả nhân viên công ty, có chức năng đăng nhậ­p và sử dụng hệ thống nội bộ. |
| 3 | Nhân viên sản phẩm | Nhân viên bộ phậ­n sản phẩm, chịu trách nhiệm xây dựng tour mẫu, lịch trình, quản lý danh mục dịch vụ và định mức giá sàn. |
| 4 | Nhân viên kinh doanh | Nhân viên bộ phậ­n kinh doanh, quản lý đơn hàng, tư vấn khách hàng, quản lý voucher và chương trình khuyậ¿n mÃi. |
| 5 | Nhân viên điều hành | Nhân viên bộ phậ­n điều hành, quản lý quỹ chỗ, phân bổ HDV, xử lý sự cố và giám sát vậ­n hành tour. |
| 6 | Hướng dẫn viên (HDV) | Nhân viên hiện trường, sử dụng ứng dụng di động để điểm danh, xác nhậ­n hành động xanh, báo cáo sự cố và nhậ­p chi phí. |
| 7 | Nhân viên kậ¿ toán | Nhân viên bộ phậ­n tài chính, thực hiện đối soát thanh toán, quyậ¿t toán tour và trích xuất báo cáo tài chính. |
| 8 | Quản trị viên | Nhân viên kỹ thuậ­t, quản lý tài khoản, phân quyền, cấu hình tham số hệ thống và giám sát bảo mậ­t. |
| 9 | Cổng thanh toán (External System) | Hệ thống bên thứ ba xử lý các giao dịch thanh toán điện tử từ khách hàng. |
| 10 | Hệ thống Power BI (External System) | Hệ thống bên thứ ba tiậ¿p nhậ­n dữ liệu từ ERP để trực quan hóa và phân tích báo cáo. |

## 2. Danh sách 68 Use-case toàn hệ thống

Các Use-case được chia thành 8 tài liệu đặc tả (md) khác nhau. Dưới đây là danh sách tổng hợp:

### Phân hệ 1: Quản lý sản phẩm & Tour ([Xem chi tiậ¿t](01-quan-ly-san-pham-tour.md))
| MÝUC | Tên Use-case | Tác nhân chính |
|---|---|---|
| UC01 | Quản lý tour mẫu | Nhân viên sản phẩm |
| UC02 | Thêm mới tour mẫu | Nhân viên sản phẩm |
| UC03 | Sao chép tour mẫu | Nhân viên sản phẩm |
| UC04 | Sửa thông tin tour mẫu | Nhân viên sản phẩm |
| UC05 | Xóa tour mẫu | Nhân viên sản phẩm |
| UC06 | Tra cứu tour mẫu | Nhân viên sản phẩm |
| UC07 | Quản lý lịch trình tour | Nhân viên sản phẩm |
| UC08 | Thêm lịch trình tour | Nhân viên sản phẩm |
| UC09 | Sửa lịch trình tour | Nhân viên sản phẩm |
| UC10 | Quản lý tour thực tậ¿ | Nhân viên sản phẩm |
| UC11 | Khởi tạo tour thực tậ¿ từ tour mẫu | Nhân viên sản phẩm |
| UC12 | Xóa tour thực tậ¿ | Nhân viên sản phẩm |
| UC13 | Sửa tour thực tậ¿ | Nhân viên sản phẩm, NV kinh doanh |
| UC14 | Tra cứu tour thực tậ¿ | Nhân viên |
| UC15 | Quản lý dịch vụ bổ sung | Nhân viên sản phẩm, NV kậ¿ toán |
| UC16 | Thêm dịch vụ | Nhân viên sản phẩm |
| UC17 | Sửa thông tin dịch vụ | Nhân viên sản phẩm |
| UC18 | Xóa dịch vụ | Nhân viên sản phẩm |
| UC19 | Tra cứu dịch vụ | Nhân viên sản phẩm, NV kinh doanh |
| UC20 | Cấu hình hành động xanh cho tour | Nhân viên sản phẩm |

### Phân hệ 2: Quản lý Hộ chiậ¿u số ([Xem chi tiậ¿t](02-quan-ly-ho-chieu-so.md))
| MÝUC | Tên Use-case | Tác nhân chính |
|---|---|---|
| UC21 | Xem thông tin hồ sơ số | Khách hàng |
| UC22 | Xem chi tiậ¿t lịch sử hành trình | Khách hàng |
| UC23 | Cậ­p nhậ­t hồ sơ số | Khách hàng |
| UC24 | Tra cứu khách hàng | Nhân viên |

### Phân hệ 3: Đặt tour & Thanh toán ([Xem chi tiậ¿t](03-dat-tour-va-thanh-toan.md))
| MÝUC | Tên Use-case | Tác nhân chính |
|---|---|---|
| UC25 | Tra cứu tour | Khách hàng |
| UC26 | Xem chi tiậ¿t tour | Khách hàng |
| UC27 | Đặt tour | Khách hàng |
| UC28 | Áp dụng voucher | Khách hàng |
| UC29 | Thanh toán đơn hàng | Khách hàng, Cổng thanh toán |
| UC30 | Quy đổi voucher | Khách hàng |
| UC31 | Xem danh sách voucher | Khách hàng |
| UC32 | Hủy tour | Khách hàng |
| UC33 | Hoàn tiền | Khách hàng |

### Phân hệ 4: Quản lý Điều phối & CSKH ([Xem chi tiậ¿t](04-quan-ly-dieu-phoi.md))
| MÝUC | Tên Use-case | Tác nhân chính |
|---|---|---|
| UC34 | Tra cứu đơn hàng | Nhân viên |
| UC35 | Đánh giá | Khách hàng |
| UC36 | Khiậ¿u nại | Khách hàng |
| UC37 | Điều phối HDV | Nhân viên điều hành |
| UC38 | Tra cứu HDV | Nhân viên điều hành |
| UC39 | Giải quyậ¿t khiậ¿u nại | Nhân viên điều hành |

### Phân hệ 5: Quản lý Vậ­n hành Mobile ([Xem chi tiậ¿t](05-quan-ly-van-hanh-mobile.md))
| MÝUC | Tên Use-case | Tác nhân chính |
|---|---|---|
| UC40 | Xem lịch trình và thông tin đoàn | HDV |
| UC41 | Điểm danh khách hàng | HDV |
| UC42 | Xác nhậ­n hành động xanh | HDV |
| UC43 | Báo cáo sự cố | HDV |
| UC44 | Cậ­p nhậ­t chi phí thực tậ¿ | HDV |

### Phân hệ 6: Quản lý Tài chính - Kậ¿ toán ([Xem chi tiậ¿t](06-quan-ly-tai-chinh.md))
| MÝUC | Tên Use-case | Tác nhân chính |
|---|---|---|
| UC45 | Tính lợi nhuậ­n gộp | Nhân viên kậ¿ toán |
| UC46 | Xem cảnh báo chi phí | Nhân viên kậ¿ toán |
| UC47 | Phê duyệt chi phí thực tậ¿ | Nhân viên kậ¿ toán |
| UC48 | Quyậ¿t toán tour | Nhân viên kậ¿ toán |
| UC49 | Tra cứu tour cần quyậ¿t toán | Nhân viên kậ¿ toán |
| UC50 | Xử lý hoàn tiền | Nhân viên kậ¿ toán |

### Phân hệ 7: Quản lý Voucher & Khuyậ¿n mÃi ([Xem chi tiậ¿t](07-quan-ly-voucher-khuyen-mai.md))
| MÝUC | Tên Use-case | Tác nhân chính |
|---|---|---|
| UC51 | Trích xuất báo cáo Power BI | Nhân viên |
| UC52 | Quản lý voucher | Nhân viên kinh doanh |
| UC53 | Tạo voucher | Nhân viên kinh doanh |
| UC54 | Phân phối và thu hồi voucher | Nhân viên kinh doanh |

### Phân hệ 8: Quản trị hệ thống ([Xem chi tiậ¿t](08-quan-tri-he-thong.md))
| MÝUC | Tên Use-case | Tác nhân chính |
|---|---|---|
| UC55 | Quản lý truy cậ­p tài khoản | Người dùng |
| UC56 | Đăng ký | Khách hàng |
| UC57 | Đăng nhậ­p | Người dùng |
| UC58 | Đăng xuất | Người dùng |
| UC59 | Quên mậ­t khẩu | Người dùng |
| UC60 | Đổi mậ­t khẩu | Người dùng |
| UC61 | Quản lý tài khoản người dùng | Quản trị viên |
| UC62 | Tạo tài khoản nhân viên | Quản trị viên |
| UC63 | Cậ­p nhậ­t năng lực nhân viên | Quản trị viên |
| UC64 | Xóa/Khóa tài khoản | Quản trị viên |
| UC65 | Mở khoá tài khoản | Quản trị viên |
| UC66 | Tìm kiậ¿m tài khoản | Quản trị viên |
| UC67 | Phân quyền truy cậ­p | Quản trị viên |
| UC68 | Xem nhậ­t ký hệ thống | Quản trị viên |
