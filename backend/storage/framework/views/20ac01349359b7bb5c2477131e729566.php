<?php $__env->startSection('title', 'Báo cáo Đơn đặt Tour'); ?>
<?php $__env->startSection('report_name', 'BÁO CÁO CHI TIẾT ĐƠN ĐẶT TOUR'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(!empty($chartSvg)): ?>
        <div class="chart-container">
            <div class="chart-title">Biểu đồ xu hướng số lượng đơn đặt tour theo ngày (Gần nhất)</div>
            <?php echo $chartSvg; ?>

        </div>
    <?php endif; ?>

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Danh Sách Đơn Đặt Tour Trong Kỳ</h2>
    
    <?php if(empty($data)): ?>
        <div class="empty-message">
            Không tìm thấy đơn đặt tour nào trong khoảng thời gian này.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">STT</th>
                    <th style="width: 15%;">Mã Đặt Tour</th>
                    <th style="width: 15%;">Mã Tour TT</th>
                    <th>Tên Tour thực tế</th>
                    <th class="text-center" style="width: 15%;">Ngày Đặt</th>
                    <th class="text-right" style="width: 18%;">Tổng Tiền</th>
                    <th class="text-center" style="width: 12%;">Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalRev = 0;
                    $totalCount = count($data);
                ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $totalRev += $item['tong_tien'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo e($idx + 1); ?></td>
                        <td class="text-bold"><?php echo e($item['ma_dat_tour']); ?></td>
                        <td><?php echo e($item['ma_tour_thuc_te']); ?></td>
                        <td><?php echo e($item['tieu_de_tour'] ?: 'Chưa có tên'); ?></td>
                        <td class="text-center"><?php echo e(\Carbon\Carbon::parse($item['ngay_dat'])->format('d/m/Y')); ?></td>
                        <td class="text-right text-bold">₫<?php echo e(number_format($item['tong_tien'], 0, '', ',')); ?></td>
                        <td class="text-center">
                            <?php if(strtoupper($item['trang_thai']) === 'DA_THANH_TOAN'): ?>
                                <span class="badge badge-success">Đã thanh toán</span>
                            <?php elseif(strtoupper($item['trang_thai']) === 'CHO_XAC_NHAN' || strtoupper($item['trang_thai']) === 'CHO_THANH_TOAN'): ?>
                                <span class="badge badge-warning">Chờ duyệt</span>
                            <?php elseif(strtoupper($item['trang_thai']) === 'HUY' || strtoupper($item['trang_thai']) === 'DA_HUY'): ?>
                                <span class="badge badge-danger">Đã hủy</span>
                            <?php else: ?>
                                <span class="badge badge-info"><?php echo e($item['trang_thai']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">
                        TỔNG CỘNG (<?php echo e($totalCount); ?> đơn):
                    </td>
                    <td></td>
                    <td class="text-right" style="font-size: 8pt; color: #1e3a8a; padding: 8px 6px;">₫<?php echo e(number_format($totalRev, 0, '', ',')); ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('reports.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\asus\Downloads\J\WEB\DoAnWeb-TravelERP\backend\resources\views/reports/don_dat_tour.blade.php ENDPATH**/ ?>