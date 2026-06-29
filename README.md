<p align="center"><img width="454" height="126" alt="image" src="https://github.com/user-attachments/assets/2036c003-62d1-42f1-9817-6cca86de0fc8" /> </p>

# Digital Travel ERP Backend

**Đề tài:** Hệ thống quản lí vận hành du lịch số  
**Kiến trúc:** MySQL Database Â· Laravel PHP Backend Â· React/Vite Frontend  
**Repository:** Workspace gồm Backend Laravel và 3 ứng dụng Frontend: `admin`, `hdv`, `kh`

| Thành phần | Repository nguồn | Branch |
|---|---|---|
| Frontend Admin | [ThorBietBay001/Frontend-Digital-Travel-ERP](https://github.com/ThorBietBay001/Frontend-Digital-Travel-ERP) | `main` |
| Frontend HDV | [ThorBietBay001/Frontend-Digital-Travel-ERP](https://github.com/ThorBietBay001/Frontend-Digital-Travel-ERP) | `ui-ux/hdv` |
| Frontend Khách hàng | [ThorBietBay001/Frontend-Digital-Travel-ERP](https://github.com/ThorBietBay001/Frontend-Digital-Travel-ERP) | `ui-ux/KH` |

---

## Tài liệu Kỹ thuật
* [Tổng hợp Công thức Tính toán (Calculation Formulas)](./CALCULATION_FORMULAS.md)

---

## Mục lục

1. [Giới thiệu đồ án](#giới-thiệu-đồ-án)
2. [Cấu trúc](#cấu-trúc)
3. [Công nghệ và công cụ sử dụng](#công-nghệ-và-công-cụ-sử-dụng)
4. [Yêu cầu môi trường](#yêu-cầu-môi-trường)
5. [Hướng dẫn cài đặt và chạy dự án](#hướng-dẫn-cài-đặt-và-chạy-dự-án)
6. [Tài khoản seed](#tài-khoản-seed)
7. [Kiểm thử hệ thống](#kiểm-thử-hệ-thống)
8. [Lỗi thường gặp](#lỗi-thường-gặp)
9. [Tài liệu phát triển](#tài-liệu-phát-triển)
10. [Thành viên nhóm](#thành-viên-nhóm)

---

## Giới thiệu đồ án

Digital Travel ERP là hệ thống hỗ trợ quản lí và vận hành nghiệp vụ du lịch theo nhiều phân hệ:

| Phân hệ | Vai trò chính |
|---|---|
| Khách hàng | Tra cứu tour, đặt tour, thanh toán, quản lí hồ sơ số, voucher, khiếu nại |
| Admin / Quản trị | Quản lí tài khoản, phân quyền, nhân sự, nhật ký hệ thống |
| Sản phẩm | Quản lí tour mẫu, dịch vụ bổ sung, hành động xanh |
| Điều hành | Khởi tạo tour thực tế, phân công hướng dẫn viên, quản lí lịch công tác |
| Hướng dẫn viên | Xem tour được phân công, điểm danh, báo cáo sự cố, cập nhật chi phí |
| Kinh doanh | Quản lí đơn đặt tour, khách hàng, voucher, yêu cầu hỗ trợ |
| Kế toán | Duyệt chi phí, xử lí hoàn tiền, quyết toán tour, báo cáo doanh thu |

Backend cung cấp REST API bảo vệ bằng JWT. Frontend gồm ba giao diện riêng cho nhóm người dùng khác nhau, cùng gọi API qua prefix `/api`.

---

## Cấu trúc

```text
Digital-Travel_ERP/
â”œâ”€â”€ backend/                  # Backend PHP Laravel
â”‚ â”œâ”€â”€ app/
â”‚ â”œâ”€â”€ config/                 # Tệp cấu hình ứng dụng
â”‚ â”œâ”€â”€ database/               # Migrations, Seeders
â”‚ â”œâ”€â”€ routes/                 # Cấu hình định tuyến API
â”‚ â”œâ”€â”€ tests/                  # Bộ kiểm thử tự động (PHPUnit)
â”‚ â””â”€â”€ artisan                 # Công cụ CLI của Laravel
â”œâ”€â”€ frontend/                 # Các ứng dụng React
â”‚ â”œâ”€â”€ admin/                  # Giao diện quản trị/nhân viên nội bộ
â”‚ â”œâ”€â”€ hdv/                    # Giao diện hướng dẫn viên
â”‚ â””â”€â”€ kh/                     # Giao diện khách hàng
â””â”€â”€ docs/                     # Tài liệu dự án (Quy trình, Kiến trúc, API)
```

---

## Công nghệ và công cụ sử dụng

### Backend

| Nhóm | Công nghệ |
|---|---|
| Ngôn ngữ | PHP 8.x |
| Framework | Laravel 11.x |
| Security | JWT (tymon/jwt-auth) |
| ORM | Eloquent ORM |
| Database | MySQL 8.x |
| Validation | Laravel Form Request |

### Frontend

| Ứng dụng | Công nghệ chính |
|---|---|
| `admin` | React 19, TypeScript, Vite, Tailwind CSS, Axios, React Router, Recharts, Lucide React |
| `hdv` | React 19, TypeScript, Vite, Tailwind CSS, Axios, React Router, Lucide React |
| `kh` | React 19, TypeScript, Vite, Tailwind CSS, Radix UI, Axios, React Router, Sonner, Lucide React |

### Công cụ phát triển

| Công cụ | Mục đích |
|---|---|
| Laragon | Chạy máy chủ Web, PHP, MySQL tiện lợi trên Windows |
| Node.js + npm | Cài đặt và chạy frontend |
| Composer | Quản lý thư viện PHP |

---

## Yêu cầu môi trường

| Thành phần | Phiên bản / ghi chú |
|---|---|
| PHP | 8.2 trở lên (Tích hợp sẵn trong Laragon) |
| Composer | Khuyến nghị bản mới nhất |
| Node.js | Khuyến nghị Node.js 20 trở lên |
| Database | MySQL 8.x |
| Port backend | `8000` (php artisan serve) |
| Port frontend | Vite mặc định `5173`, nếu bận sẽ tự chuyển sang port tiếp theo |

Các frontend đãcấu hình Vite proxy:

```ts
'/api' -> 'http://localhost:8000'
```

---

## Hướng dẫn cài đặt và chạy dự án

Khuyến nghị sử dụng **Laragon** để cài đặt trọn gói PHP, MySQL và Composer trên Windows.

### 1. Khởi tạo Database tự động

- Tạo Database MySQL tên `travel_erp` (utf8mb4_unicode_ci) bằng Laragon, HeidiSQL hoặc dòng lệnh.
- Mở terminal, di chuyển vào thư mục `backend/`:
  ```bash
  cd backend
```

- Cài đặt các gói PHP:
  ```bash
  composer install --ignore-platform-reqs
```

- Tạo file .env từ .env.example:
  ```bash
  cp .env.example .env
```

- Sửa thông tin kết nối database trong .env:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=travel_erp
  DB_USERNAME=root
  DB_PASSWORD=
```

- Tạo khóa ứng dụng:
  ```bash
  php artisan key:generate
```

- Chạy migration để khởi tạo cấu trúc bảng:
  ```bash
  php artisan migrate:fresh
  ```

- Nạp dữ liệu cốt lõi (Bắt buộc cho Production - Tài khoản admin & Vai trò):
  ```bash
  php artisan db:seed
  ```
  
- Nạp dữ liệu nghiệp vụ gốc (Dành cho Local / Dev / Testing):
  Hệ thống cung cấp một công cụ import dữ liệu chuyên biệt để nạp thẳng các tệp RAW SQL khổng lồ vào DB mà không qua Seeder:
  ```bash
  php artisan db:import-sql
  ```
  *(Lệnh này sẽ tự động quét thư mục `database/raw-sql/` và import `accounts_seed.sql`, `business_demo_seed.sql`)*


### 2. Chạy Backend

```powershell
php artisan serve
```

Backend chạy tại: `http://localhost:8000`

### 3. Cài đặt và chạy Frontend

Mở các cửa sổ terminal riêng biệt cho từng ứng dụng:

#### Admin
```powershell
cd frontend/admin
npm install
npm run dev
```

#### Hướng dẫn viên
```powershell
cd frontend/hdv
npm install
npm run dev
```

#### Khách hàng
```powershell
cd frontend/kh
npm install
npm run dev
```

---

## Tài khoản seed

Mật khẩu mặc định cho tất cả các tài khoản: **`password`**

| Vai trò | Tên đăng nhập (Username) | Phân hệ / Cổng kiểm thử | Cổng mặc định |
|:---|:---|:---|:---|
| `ADMIN` | `admin` | Phân hệ Admin - Quản trị | `http://localhost:5173` |
| `SANPHAM` | `sanpham01` | Phân hệ Admin - Quản lý sản phẩm | `http://localhost:5173` |
| `DIEUHANH` | `manager01` | Phân hệ Admin - Điều phối, điều hành | `http://localhost:5173` |
| `KINHDOANH` | `sales01` | Phân hệ Admin - Quản lý kinh doanh | `http://localhost:5173` |
| `KETOAN` | `ketoan01` | Phân hệ Admin - Quản lý kế toán | `http://localhost:5173` |
| `HDV` | `hdv01` | Phân hệ Hướng dẫn viên (HDV) | `http://localhost:5174` |
| `KHACHHANG` | `khach01` | Phân hệ Khách hàng (KH) | `http://localhost:5175` |

---

## Lỗi thường gặp

| Hiện tượng | Nguyên nhân thường gặp | Cách xử lý |
|---|---|---|
| Backend lỗi 500 khi gọi API | Chưa copy `.env` hoặc sai cấu hình DB | Kiểm tra file `.env` và chạy lại `php artisan config:clear` |
| Lỗi migration báo thiếu bảng | Database chưa tồn tại | Vào HeidiSQL tạo Database `travel_erp` trước khi migrate |
| FE gọi API bị `Failed to fetch` | Backend chưa chạy hoặc gọi sai port | Chạy backend lệnh `php artisan serve` ở port `8000` |
| API trả `401 Unauthorized` | Chưa đăng nhập hoặc token hết hạn | Đăng nhập lại |

---
Tài liệu phát triển
- Ngữ cảnh dự án: docs/PROJECT_CONTEXT.md
- API Contract Baseline: docs/api-contract-baseline.md

---
## Thành viên nhóm

| STT | MSSV | Họ và Tên | GitHub | Email |
| :--- | :--- | :--- | :--- | :--- |
| 1 | 24521817 | Đoàn Thị Thuỳ Trang | https://github.com/ThorBietBay001 | 24521817@gm.uit.edu.vn |
| 2 | 24521769 | Lê Thị Thanh Tiền | https://github.com/tienlelttt | 24521769@gm.uit.edu.vn |
| 3 | 24521776 | Nguyễn Trần Thủy Tiên | https://github.com/NgKthy | 24521776@gm.uit.edu.vn |
| 4 | 24522039 | Nguyễn Tuấn Vũ | https://github.com/Yuu2006 | 24522039@gm.uit.edu.vn |
