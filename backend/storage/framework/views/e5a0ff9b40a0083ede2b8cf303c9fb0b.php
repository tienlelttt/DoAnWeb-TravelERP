<?php $__env->startSection('title', 'Báo cáo Chi tiết Giao dịch Thanh toán'); ?>
<?php $__env->startSection('report_name', 'BÁO CÁO CHI TIẾT GIAO DỊCH THANH TOÁN'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(!empty($chartSvg)): ?>
        <div class="chart-container">
            <div class="chart-title">Biểu đồ tỷ lệ giá trị giao dịch theo Phương thức (Top Phương thức)</div>
            <?php echo $chartSvg; ?>

        </div>
    <?php endif; ?>

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Nhật Ký Giao Dịch Thanh Toán</h2>
    
    <?php if(empty($data)): ?>
        <div class="empty-message">
            Không tìm thấy giao dịch thanh toán nào phát sinh trong khoảng thời gian này.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">STT</th>
                    <th style="width: 15%;">Mã Giao Dịch</th>
                    <th style="width: 15%;">Mã Đặt Tour</th>
                    <th>Phương Thức</th>
                    <th class="text-center" style="width: 15%;">Ngày Giao Dịch</th>
                    <th class="text-right" style="width: 18%;">Số Tiền</th>
                    <th class="text-center" style="width: 12%;">Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalAmount = 0;
                    $totalCount = count($data);
                ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $totalAmount += $item['so_tien'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo e($idx + 1); ?></td>
                        <td class="text-bold"><?php echo e($item['ma_giao_dich']); ?></td>
                        <td><?php echo e($item['ma_dat_tour']); ?></td>
                        <td>
                            <?php if(strtoupper($item['phuong_thuc']) === 'TIEN_MAT'): ?>
                                <span>Tiền mặt</span>
                            <?php elseif(strtoupper($item['phuong_thuc']) === 'CHUYEN_KHOAN'): ?>
                                <span>Chuyển khoản</span>
                            <?php else: ?>
                                <span><?php echo e($item['phuong_thuc']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php echo e($item['ngay_thanh_toan'] ? \Carbon\Carbon::parse($item['ngay_thanh_toan'])->format('d/m/Y H:i') : ''); ?>

                        </td>
                        <td class="text-right text-bold" style="color: <?php echo e(strtoupper($item['trang_thai']) === 'THANH_CONG' || strtoupper($item['trang_thai']) === 'SUCCESS' ? '#059669' : '#374151'); ?>">
                            ₫<?php echo e(number_format($item['so_tien'], 0, '', ',')); ?>

                        </td>
                        <td class="text-center">
                            <?php if(strtoupper($item['trang_thai']) === 'THANH_CONG' || strtoupper($item['trang_thai']) === 'SUCCESS'): ?>
                                <span class="badge badge-success">Thành công</span>
                            <?php elseif(strtoupper($item['trang_thai']) === 'THAT_BAI' || strtoupper($item['trang_thai']) === 'FAILED'): ?>
                                <span class="badge badge-danger">Thất bại</span>
                            <?php elseif(strtoupper($item['trang_thai']) === 'CHO_XAC_NHAN' || strtoupper($item['trang_thai']) === 'PENDING'): ?>
                                <span class="badge badge-warning">Chờ xử lý</span>
                            <?php else: ?>
                                <span class="badge badge-info"><?php echo e($item['trang_thai']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">
                        TỔNG DOANH SỐ (<?php echo e($totalCount); ?> giao dịch):
                    </td>
                    <td></td>
                    <td class="text-right" style="font-size: 8pt; color: #047857; padding: 8px 6px;">₫<?php echo e(number_format($totalAmount, 0, '', ',')); ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('reports.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\asus\Downloads\J\WEB\DoAnWeb-TravelERP\backend\resources\views\reports\giao_dich.blade.php ENDPATH**/ ?>