<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <style>
        @page {
            margin: 110px 40px 60px 40px;
        }
        header {
            position: fixed;
            top: -90px;
            left: 0;
            right: 0;
            height: 70px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 8px;
        }
        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8pt;
            color: #6b7280;
            padding-top: 6px;
        }
        .page-number:after {
            content: "Trang " counter(page);
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8.5pt;
            color: #374151;
            line-height: 1.5;
        }
        .report-header {
            margin-bottom: 20px;
        }
        .report-title {
            font-size: 16pt;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0 0 5px 0;
        }
        .report-meta {
            font-size: 9pt;
            color: #4b5563;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 11pt;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }
        .company-subtitle {
            font-size: 7.5pt;
            color: #6b7280;
            margin: 2px 0 0 0;
        }
        .table-company {
            width: 100%;
            border: none;
            margin-bottom: 0;
        }
        .table-company td {
            border: none;
            padding: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        thead {
            display: table-header-group;
            background-color: #f3f4f6;
        }
        th {
            border: 1px solid #d1d5db;
            padding: 6px 5px;
            font-weight: bold;
            text-align: left;
            font-size: 8pt;
            color: #1f2937;
        }
        td {
            border: 1px solid #e5e7eb;
            padding: 6px 5px;
            font-size: 7.5pt;
            vertical-align: middle;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-bold {
            font-weight: bold;
        }
        
        .chart-container {
            margin: 25px 0;
            text-align: center;
            page-break-inside: avoid;
            page-break-after: always;
        }
        .chart-title {
            font-size: 10pt;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-info { background-color: #dbeafe; color: #1e40af; }
        .badge-gray { background-color: #f3f4f6; color: #374151; }

        .empty-message {
            padding: 40px;
            text-align: center;
            font-size: 10pt;
            color: #dc2626;
            background-color: #fef2f2;
            border: 1px dashed #fca5a5;
            border-radius: 6px;
            margin: 30px 0;
        }
    </style>
</head>
<body>

    <header>
        <table class="table-company">
            <tr>
                <td>
                    <div class="company-name">DIGITAL TRAVEL ERP SYSTEM</div>
                    <div class="company-subtitle">Hệ thống Điều hành & Quản trị Du lịch Số Quốc tế</div>
                </td>
                <td class="text-right" style="vertical-align: top;">
                    <div style="font-size: 7.5pt; color: #6b7280;">
                        Ngày xuất: <?php echo e(date('d/m/Y H:i')); ?><br/>
                        Tác giả: <?php echo e(auth('api')->user()?->ho_ten ?? 'Kế toán hệ thống'); ?>

                    </div>
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table style="width: 100%; border: none; margin-bottom: 0;">
            <tr>
                <td style="border: none; padding: 0; color: #9ca3af; font-size: 7.5pt; text-align: left;">
                    Digital Travel ERP - Báo cáo bảo mật nội bộ
                </td>
                <td style="border: none; padding: 0; text-align: right;" class="page-number"></td>
            </tr>
        </table>
    </footer>

    <div class="report-header">
        <h1 class="report-title"><?php echo $__env->yieldContent('report_name'); ?></h1>
        <div class="report-meta">
            Khoảng thời gian: <strong><?php echo e($periodText); ?></strong>
        </div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>

</body>
</html>
<?php /**PATH C:\Users\asus\Downloads\J\WEB\DoAnWeb-TravelERP\backend\resources\views/reports/layout.blade.php ENDPATH**/ ?>