<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportSqlData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import-sql {--path= : Tùy chọn đường dẫn file SQL}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import dữ liệu từ file RAW SQL vào Database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Bắt đầu nạp dữ liệu từ file RAW SQL...");

        $files = $this->option('path') 
            ? [base_path($this->option('path'))]
            : [
                database_path('raw-sql/accounts_seed.sql'),
                database_path('raw-sql/business_demo_seed.sql')
            ];

        foreach ($files as $file) {
            if (!file_exists($file)) {
                $this->error("Không tìm thấy file: {$file}");
                continue;
            }

            $this->info("Đang nạp file: " . basename($file));
            $sql = file_get_contents($file);
            try {
                // Kích hoạt PIPES_AS_CONCAT cho session này để hỗ trợ toán tử || nối chuỗi
                $sql = "SET SESSION sql_mode = CONCAT(@@sql_mode, ',PIPES_AS_CONCAT');\n" . $sql;
                DB::unprepared($sql);
                $this->info("Hoàn thành nạp: " . basename($file));
            } catch (\Exception $e) {
                $this->error("Lỗi khi nạp file " . basename($file) . ": " . substr($e->getMessage(), 0, 500));
            }
        }

        $this->info("Import dữ liệu SQL thành công!");
    }
}
