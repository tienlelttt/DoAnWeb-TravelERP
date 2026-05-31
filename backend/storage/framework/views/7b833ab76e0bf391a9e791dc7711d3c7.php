<?php $__env->startSection('title', 'Báo cáo Doanh thu & Quyết toán'); ?>
<?php $__env->startSection('report_name', 'BÁO CÁO DOANH THU & QUYẾT TOÁN TOUR'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(!empty($chartSvg)): ?>
        <div class="chart-container">
            <div class="chart-title">Biểu đồ so sánh doanh thu, chi phí và lợi nhuận (Top 15 Tour)</div>
            <?php echo $chartSvg; ?>

        </div>
    <?php endif; ?>

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Bảng Chi Tiết Quyết Toán Tour</h2>
    
    <?php if(empty($data)): ?>
        <div class="empty-message">
            Không có dữ liệu quyết toán nào được ghi nhận trong khoảng thời gian này.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">STT</th>
                    <th style="width: 12%;">Mã QT</th>
                    <th style="width: 12%;">Mã Tour TT</th>
                    <th>Tên Tour thực tế</th>
                    <th class="text-right" style="width: 15%;">Doanh Thu</th>
                    <th class="text-right" style="width: 15%;">Chi Phí</th>
                    <th class="text-right" style="width: 15%;">Lợi Nhuận</th>
                    <th class="text-center" style="width: 10%;">Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalRev = 0;
                    $totalCost = 0;
                    $totalProfit = 0;
                ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $totalRev += $item['tong_doanh_thu'];
                        $totalCost += $item['tong_chi_phi'];
                        $totalProfit += $item['loi_nhuan'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo e($idx + 1); ?></td>
                        <td class="text-bold"><?php echo e($item['ma_quyet_toan']); ?></td>
                        <td><?php echo e($item['ma_tour_thuc_te']); ?></td>
                        <td><?php echo e($item['tieu_de_tour'] ?: 'Chưa có tên'); ?></td>
                        <td class="text-right">₫<?php echo e(number_format($item['tong_doanh_thu'], 0, '', ',')); ?></td>
                        <td class="text-right">₫<?php echo e(number_format($item['tong_chi_phi'], 0, '', ',')); ?></td>
                        <td class="text-right text-bold <?php echo e($item['loi_nhuan'] < 0 ? 'text-danger' : ''); ?>" style="color: <?php echo e($item['loi_nhuan'] < 0 ? '#dc2626' : '#059669'); ?>">
                            ₫<?php echo e(number_format($item['loi_nhuan'], 0, '', ',')); ?>

                        </td>
                        <td class="text-center">
                            <?php if(strtoupper($item['trang_thai']) === 'DA_CHOT' || strtoupper($item['trang_thai']) === 'COMPLETED' || strtoupper($item['trang_thai']) === 'CHOT'): ?>
                                <span class="badge badge-success">Đã chốt</span>
                            <?php elseif(strtoupper($item['trang_thai']) === 'YEU_CAU_BO_SUNG'): ?>
                                <span class="badge badge-warning">Cần bổ sung</span>
                            <?php else: ?>
                                <span class="badge badge-info"><?php echo e($item['trang_thai']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">TỔNG CỘNG:</td>
                    <td class="text-right" style="font-size: 8pt; color: #1e3a8a; padding: 8px 6px;">₫<?php echo e(number_format($totalRev, 0, '', ',')); ?></td>
                    <td class="text-right" style="font-size: 8pt; color: #991b1b; padding: 8px 6px;">₫<?php echo e(number_format($totalCost, 0, '', ',')); ?></td>
                    <td class="text-right" style="font-size: 8pt; color: <?php echo e($totalProfit < 0 ? '#991b1b' : '#047857'); ?>; padding: 8px 6px;">
                        ₫<?php echo e(number_format($totalProfit, 0, '', ',')); ?>

                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('reports.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\asus\Downloads\J\WEB\DoAnWeb-TravelERP\backend\resources\views\reports\doanh_thu.blade.php ENDPATH**/ ?>