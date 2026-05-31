Quy trình chuyển đổi: Java Spring Boot + Oracle → Laravel + MySQL
🎯 Mục tiêu
Giữ nguyên toàn bộ nghiệp vụ backend.

API Contract (đầu vào, đầu ra, status code, cấu trúc lỗi) phải giống hệt hệ thống cũ.

React hoạt động bình thường chỉ bằng cách thay đổi REACT_APP_API_URL.

🧰 Nguyên tắc xuyên suốt
Không sửa một dòng code React.

Ưu tiên công cụ tự động cho migration và kiểm thử.

Ghi lại mọi khác biệt tiềm ẩn giữa hai hệ sinh thái.
--------------------------
Giai đoạn 0: Phân tích & Chuẩn bị
Công việc
1. Thu thập tài liệu API từ code Java:
- Sử dụng Swagger (nếu có) → export OpenAPI spec.
- Hoặc dùng Postman Recorder để capture tất cả request từ React đang chạy.

2. Liệt kê tất cả endpoints với các thông tin:
- Method, path, query params, body mẫu.
- Cấu trúc response thành công và lỗi.
- Header yêu cầu (Authorization, Accept-Language, ...).
- Kiểu phân trang (nếu có) – đặc biệt chú ý cấu trúc content, totalElements, totalPages, size, number.
3. Xác định các scheduled jobs (cron) và logic cache (Redis, Ehcache).

4. Phân tích cấu trúc database Oracle:
- Các bảng, kiểu dữ liệu, sequence, trigger, view, stored procedure (nếu dùng).
- Ràng buộc khóa chính, khóa ngoại, unique, check.

Lưu ý ⚠️
+ Nếu dùng Spring Data JPA và Hibernate, hãy chạy chế độ spring.jpa.show-sql=true để ghi lại câu lệnh SQL thực tế – rất hữu ích cho việc tối ưu Eloquent sau này.

+ Đánh dấu các endpoint có sử dụng @Transactional để xác định nơi cần đảm bảo transaction trong Laravel.

--------------------------
Giai đoạn 1: Chuyển đổi cơ sở dữ liệu (Oracle → MySQL)
Quy trình an toàn (ETL)
1. Xuất schema Oracle (chỉ cấu trúc, không data) thành file SQL.

2. Sử dụng công cụ chuyên dụng để ánh xạ kiểu dữ liệu và ràng buộc.

3. Xử lý các điểm khác biệt nguy hiểm (can thiệp thủ công nếu công cụ chưa xử lý tốt):

Oracle	MySQL	Ghi chú
VARCHAR2(n)	VARCHAR(n)	Chiều dài tương tự
NUMBER(p,s)	DECIMAL(p,s) hoặc INT	Nếu s=0 và p<=11 có thể dùng INT
DATE (có giờ phút giây)	DATETIME	Không dùng TIMESTAMP để tránh chuyển đổi múi giờ
TIMESTAMP WITH TIME ZONE	TIMESTAMP + lưu thêm timezone	Hoặc dùng DATETIME + cột riêng lưu timezone nếu cần
SEQUENCE + trigger tạo ID	AUTO_INCREMENT	Xóa trigger, thêm AUTO_INCREMENT trên cột PK
CLOB/BLOB	LONGTEXT/LONGBLOB	

4. Tạo Laravel migrations từ schema MySQL đã điều chỉnh:
- Có thể viết migration thủ công (kiểm soát tốt hơn) hoặc dùng package Xethron/migrations-generator.
- Trong migration, đảm bảo đặt đúng engine InnoDB để hỗ trợ khóa ngoại.

5. Chạy migration trên database MySQL (môi trường development).

6. Migrate dữ liệu từ Oracle sang MySQL:
- INSERT INTO ... SELECT qua kết nối DB link (nếu có thể kết nối đồng thời).

7. Kiểm tra tính toàn vẹn:
- So sánh tổng số bản ghi từng bảng (SELECT COUNT(*)).
- Kiểm tra một số bản ghi ngẫu nhiên.
- Chạy truy vấn kiểm tra ràng buộc khóa ngoại (ví dụ: tìm orphan records).

Lưu ý ⚠️
Không sửa file SQL thủ công cho toàn bộ database – dễ sai sót. Chỉ can thiệp tay cho các cấu trúc đặc thù.

Backup database Oracle trước khi bắt đầu.

Nếu có dữ liệu nhạy cảm, cần làm mờ (masking) trước khi đưa vào môi trường dev.

--------------------------
Giai đoạn 2: Xây dựng Backend Laravel
2.1. Thiết lập dự án Laravel
bash
composer create-project laravel/laravel travel-erp-backend
cd travel-erp-backend
composer require tymon/jwt-auth fruitcake/laravel-cors
php artisan jwt:secret

Cấu hình file .env:
text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=travel_erp
DB_USERNAME=root
DB_PASSWORD=secret

JWT_SECRET=... (được tạo tự động)
FRONTEND_URL=http://localhost:3000   # domain React


2.2. Tạo Models và Eloquent Relationships
- Tạo model cho mỗi bảng (dùng php artisan make:model Tour -m nếu chưa có migration).
- Khai báo relationships dựa trên khóa ngoại: hasOne, hasMany, belongsTo, belongsToMany.
- Nếu Java dùng @ManyToOne(fetch = LAZY) → mặc định Eloquent cũng lazy loading, cần with() khi muốn eager load.

2.3. Authentication (JWT) – giữ nguyên để React không sửa
Cấu hình config/auth.php:

php
'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\TaiKhoan::class, // thay bằng model account của bạn
    ],
],
Middleware auth:api sẽ bảo vệ các route cần đăng nhập.

2.4. Form Request & API Resource (đảm bảo DTO và response chuẩn)
- Form Request – chứa validation rules (thay thế DTO + @Valid).
- API Resource – định dạng response cho từng model.
+ Trong mọi Resource, phải map thủ công từ snake_case của model sang camelCase của JSON.
Lưu ý kiểm tra:
- Dùng Postman để gọi một API bất kỳ, xem response có đúng camelCase không.
- Đặc biệt chú ý các field như created_at, updated_at, deleted_at.

🔥 2.5. Xử lý phân trang (Pagination Mapping) – BẮT BUỘC
- Vì Spring Boot trả về content, totalElements, totalPages, còn Laravel trả data, total, per_page → phải custom.
- Tạo CustomPaginatedResourceCollection (đã mô tả chi tiết ở phần trước). Áp dụng cho mọi endpoint có phân trang.

Lưu ý: Kiểm tra xem Java có dùng page index bắt đầu từ 0 hay 1 không (thường number bắt đầu từ 0). Nếu cần, adjust 'number' => $this->currentPage() - 1.

2.6. Service Layer (nghiệp vụ)
- Tạo thư mục app/Services, mỗi service là một class.
- Chuyển logic từ @Service Java sang PHP thuần.
- Inject model, repository (nếu cần) qua constructor.
+ Xác định tất cả các phương thức trong Java có annotation @Transactional (hoặc các logic phức tạp như tạo booking, trừ số chỗ, thanh toán, cập nhật nhiều bảng). Trong Laravel, bọc chúng trong DB::transaction()
      + Quy tắc:
      *Bất kỳ logic nào ghi vào nhiều hơn 1 bảng hoặc có ràng buộc dữ liệu chéo đều phải nằm trong DB::transaction().
      *Sử dụng lockForUpdate() khi cần đọc rồi ghi trên cùng một bản ghi (tránh overbooking).
      *Các exception cần được bắt và xử lý ở tầng controller (trả về JSON lỗi đúng format như đã config ở exception handler).
      + Lưu ý kiểm tra:
      *Viết unit test cho trường hợp lỗi giữa chừng (ví dụ hết chỗ, database lỗi) để đảm bảo không có dữ liệu rác được lưu.

2.7. Xử lý ngoại lệ toàn cục – GIỐNG HỆT SPRING BOOT
Vào bootstrap/app.php (Laravel 11+) hoặc app/Exceptions/Handler.php (Laravel 10 trở xuống) để override.

2.8. Cache (nếu Java dùng @Cacheable)
- Cài Redis: composer require predis/predis.
- Cấu hình .env: CACHE_DRIVER=redis.
- Dùng Cache::remember('key', $seconds, fn() => ...).

2.9. Scheduled Jobs (Task Scheduler)
- Tạo command: php artisan make:command CancelExpiredBookings.
- Viết logic trong handle().
- Đăng ký trong app/Console/Kernel.php:
php
protected function schedule(Schedule $schedule)
{
    $schedule->command('bookings:cancel-expired')->everyMinute();
    $schedule->command('pricing:update-dynamic')->hourly();
}

- Đặt cron trên server: * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1

2.10. Controller & Route API
- Sử dụng resource controllers.
- Nhóm route với prefix /api, middleware auth:api cho các endpoint cần token.
- Đảm bảo route có tên (name) để dễ generate URL.

--------------------------
🧪 Giai đoạn 3: Kiểm thử tự động – ĐẢM BẢO API CONTRACT
3.1. Tạo Postman Collection từ hệ thống cũ
- Export từ Swagger hoặc dùng Postman Recorder (proxy) khi chạy React.
- Lưu collection thành file JSON.

3.2. Dùng Newman hoặc Postman Runner để kiểm thử trên Laravel
bash
newman run collection.json --env-var "baseUrl=http://localhost:8000"
- So sánh response với expected (có thể dùng --bail để dừng khi lỗi).

3.3. Viết PHPUnit Test cho từng nghiệp vụ
bash
php artisan make:test TourApiTest

Lưu ý ⚠️
- Kiểm tra kỹ các endpoint phân trang sau khi đã custom collection.
- Kiểm tra CORS trước khi triển khai: gọi API từ domain khác (hoặc dùng Postman với Origin header) để xem có bị chặn không.

--------------------------
🚀 Giai đoạn 4: Triển khai & Cắt chuyển (Cut-over)
4.1. Cấu hình CORS – GIỐNG HỆT SPRING BOOT
File config/cors.php:

php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,  // nếu React dùng withCredentials
];

- Đồng thời, đảm bảo middleware HandleCors được đăng ký trong app/Http/Kernel.php (Laravel 10) hoặc tự động có trong 11.

4.2. Môi trường Production
- Cài đặt Nginx/Apache, PHP 8.1+, MySQL 8.0, Redis.

- Clone code, chạy composer install --optimize-autoloader.

- Set các biến môi trường (.env) đúng với production.

- Chạy migration: php artisan migrate --force.

- Import dữ liệu đã migrate từ Oracle (dùng công cụ ETL).

- Khởi động queue worker (nếu có jobs): php artisan queue:work --daemon.

4.3. Cắt chuyển
1. Tắt server Java cũ (hoặc chuyển port).

2. Cập nhật biến môi trường cho React: REACT_APP_API_URL=https://new-laravel-server.com/api.

3. Build lại React và triển khai (hoặc chỉ cần restart nếu dùng runtime env).

4. Mở ứng dụng, kiểm tra luồng chính (đăng nhập, xem danh sách, tạo đơn, thanh toán mock).

4.4. Giám sát hậu kiểm
- Xem log Laravel (storage/logs/laravel.log) để phát hiện lỗi 500.

- Kiểm tra scheduled jobs đã chạy đúng giờ chưa (có thể xem log trong database hoặc file riêng).

- So sánh báo cáo nghiệp vụ (doanh thu, số lượng tour bán) giữa hệ thống cũ và mới sau 24h.

📦 Tóm tắt các lưu ý quan trọng (checklist)
Lĩnh vực	Lưu ý
Database Migration	Dùng công cụ ETL (DBeaver, AWS SCT) – không sửa file SQL thủ công. Xử lý sequence → auto_increment, DATE → DATETIME.
Pagination	Custom CustomPaginatedResourceCollection để trả về content, totalElements, totalPages đúng chuẩn Spring Boot.
Exception Handler	Override trong bootstrap/app.php (Laravel 11) để format JSON lỗi y hệt Java (timestamp, status, error, message, path).
CORS	Cấu hình config/cors.php với allowed_origins cụ thể, supports_credentials=true nếu cần.
Authentication	Giữ JWT (tymon/jwt-auth) thay vì Sanctum để không sửa React.
Testing	Dùng Postman collection + Newman để kiểm thử tự động trước khi cắt chuyển.
Schedule	Dùng Laravel Task Scheduler, đảm bảo cron chạy mỗi phút.
Cache	Dùng Redis nếu Java có @Cacheable.


CẤU TRÚC FILE
travel-erp-backend/
├── app/
│   ├── Console/
│   │   ├── Commands/
│   │   │   ├── CancelExpiredBookings.php
│   │   │   └── UpdateDynamicPricing.php
│   │   └── Kernel.php                 # Đăng ký scheduled jobs
│   ├── Exceptions/
│   │   └── Handler.php                # Override exception (giống Spring Boot)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DanhGiaController.php
│   │   │   ├── DatTourController.php
│   │   │   ├── DichVuThemController.php
│   │   │   ├── QuyetToanController.php
│   │   │   ├── TourController.php
│   │   │   └── ...
│   │   ├── Middleware/
│   │   │   ├── JwtMiddleware.php      # Xác thực JWT
│   │   │   └── CorsMiddleware.php
│   │   ├── Requests/
│   │   │   ├── Auth/
│   │   │   ├── Tour/
│   │   │   └── ...
│   │   └── Resources/
│   │       ├── TourResource.php       # Map snake_case -> camelCase
│   │       ├── BookingResource.php
│   │       ├── CustomPaginatedResourceCollection.php
│   │       └── ...
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Tour.php                   # Tương ứng TOURMAU
│   │   ├── TourItinerary.php          # Tương ứng LICHTRINHTOUR
│   │   └── ...
│   ├── Repositories/                  # Tương ứng repository Java
│   │   ├── TourRepository.php
│   │   ├── BookingRepository.php
│   │   └── ...
│   └── Services/                      # Tương ứng service Java
│       ├── AuthService.php
│       ├── BookingService.php
│       ├── DynamicPricingService.php
│       ├── VoucherService.php
│       ├── ReportService.php
│       └── ...
├── bootstrap/
├── config/
│   ├── cors.php
│   ├── jwt.php
│   └── ...
├── database/
│   ├── migrations/
│   │   └── [timestamp]_create_tables.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── RoleSeeder.php
│   │   ├── UserSeeder.php
│   │   ├── TourSeeder.php
│   │   └── ...
├── public/
├── resources/
├── routes/
│   └── api.php                        # Khai báo các route API
├── storage/
├── tests/
│   ├── Feature/
│   │   ├── AuthApiTest.php
│   │   ├── TourApiTest.php
│   │   ├── BookingApiTest.php
│   │   └── ...
│   └── Unit/
├── .env
├── .env.example
├── artisan
└── composer.json
│
├── frontend/                        # ✅ Frontend React giữ nguyên từ dự án gốc
│   ├── public/
│   ├── src/
│   ├── .env.example                 # Có thể thêm REACT_APP_API_URL
│   ├── package.json
│   └── ...
│ 
├── database/                        # 🗄️ Scripts và tài liệu về CSDL (ngoài Laravel migrations)
│   ├── oracle-to-mysql/             # Scripts chuyển đổi từ Oracle sang MySQL
│   │   ├── export_schema_oracle.sql
│   │   ├── convert_sequences.sql
│   │   └── etl_script.py (tuỳ chọn)
│   ├── seed-data/                   # Dữ liệu mẫu (từ data gốc) – đã chuyển sang MySQL
│   │   ├── demo_data.sql
│   │   └── ...
│   └── README.md                    # Hướng dẫn chuyển đổi CSDL
│
├── docs/                            # 📚 Tài liệu dự án
│   ├── api/                         # OpenAPI/Swagger specs (export từ hệ thống cũ)
│   │   └── openapi.yaml
│   ├── postman/                     # Postman collection để kiểm thử API
│   │   └── TravelERP.postman_collection.json
│   ├── architecture/                # Sơ đồ, mô tả kiến trúc mới
│   │   └── laravel_mysql_architecture.png
│   └── migration-guide.md           # Hướng dẫn chi tiết cách chuyển đổi (cho team Dev)
│
├── scripts/                         # ⚙️ Script tự động hoá (chạy một lần hoặc định kỳ)
│   ├── migrate-data.sh              # Script di chuyển dữ liệu từ Oracle sang MySQL 
│   ├── setup-backend.sh             # Tự động cài đặt Laravel + chạy migration/seeder
│   └── health-check.sh              # Kiểm tra trạng thái API sau khi triển khai
│
├── tests/                           # 🧪 Kiểm thử tổng thể (có thể gộp vào backend/tests)
│   └── e2e/                         # Kiểm thử end-to-end (dùng Cypress hoặc Playwright)
│
├── .gitignore                       # Bỏ qua vendor, node_modules, .env, storage, ...
├── .env.example                     # Mẫu biến môi trường cho toàn bộ dự án (tuỳ chọn)
├── docker-compose.yml               # (Khuyến nghị) Chạy toàn bộ stack: MySQL, Redis, Laravel, React
├── LICENSE
└── README.md                        # Tổng quan dự án (đã viết ở phần trước)
