<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportSql extends Command
{
    /**
     * Tên lệnh artisan.
     */
    protected $signature = 'db:import-sql';

    /**
     * Mô tả lệnh.
     */
    protected $description = 'Import toàn bộ file SQL seed từ thư mục raw-sql vào database';

    /**
     * Xử lý lệnh.
     */
    public function handle()
    {
        $this->info("Bắt đầu làm sạch Database...");
        // Chạy migrate:fresh để xóa toàn bộ dữ liệu cũ và tạo lại cấu trúc bảng
        $this->call('migrate:fresh', ['--force' => true]);
        $this->info("Đã xóa sạch dữ liệu cũ và tạo lại bảng.");

        // Thứ tự các file cần import để không bị lỗi khóa ngoại (Foreign Key)
        $files = [
            'accounts_seed.sql',
            'missing_accounts.sql',
            // 'business_full_seed.sql', // Bỏ qua file này để tránh lỗi trùng lặp khóa chính
            'business_full_seed_generated.sql'
        ];

        $this->info("Bắt đầu nạp dữ liệu từ các file SQL...");

        foreach ($files as $file) {
            $path = database_path('raw-sql/' . $file);
            
            if (!File::exists($path)) {
                $this->error("❌ Không tìm thấy file: {$file}");
                continue;
            }

            $this->info("⏳ Đang nạp: {$file}...");
            
            $sql = File::get($path);
            
            try {
                DB::unprepared($sql);
                $this->info("✔ Đã nạp thành công: {$file}");
            } catch (\Exception $e) {
                $this->error("❌ Lỗi khi nạp file {$file}:");
                $this->error($e->getMessage());
                return self::FAILURE;
            }
        }

        $this->info("🎉 Đã nạp toàn bộ dữ liệu thành công!");
        return self::SUCCESS;
    }
}
