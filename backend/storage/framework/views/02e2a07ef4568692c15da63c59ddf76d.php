<?php $__env->startSection('title', 'Báo cáo Thống kê Tour Thực tế'); ?>
<?php $__env->startSection('report_name', 'BÁO CÁO THỐNG KÊ TOUR THỰC TẾ'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(!empty($chartSvg)): ?>
        <div class="chart-container">
            <div class="chart-title">Biểu đồ so sánh số lượng khách đã đặt (Top 15 Tour)</div>
            <?php echo $chartSvg; ?>

        </div>
    <?php endif; ?>

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Danh Sách Tour Thực Tế Trong Kỳ</h2>
    
    <?php if(empty($data)): ?>
        <div class="empty-message">
            Không tìm thấy tour thực tế nào được ghi nhận trong khoảng thời gian này.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">STT</th>
                    <th style="width: 12%;">Mã Tour TT</th>
                    <th>Tên Tour Thực Tế</th>
                    <th class="text-center" style="width: 12%;">Khởi Hành</th>
                    <th class="text-right" style="width: 13%;">Giá Tour</th>
                    <th class="text-center" style="width: 13%;">Số Chỗ (Đã Đặt/Tối Đa)</th>
                    <th class="text-center" style="width: 10%;">Tỷ Lệ</th>
                    <th class="text-center" style="width: 12%;">Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalBooked = 0;
                    $totalMax = 0;
                    $totalCount = count($data);
                ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $booked = max(0, $item['so_khach_toi_da'] - $item['cho_con_lai']);
                        $totalBooked += $booked;
                        $totalMax += $item['so_khach_toi_da'];
                        $occupancyRate = $item['so_khach_toi_da'] > 0 ? round(($booked / $item['so_khach_toi_da']) * 100, 1) : 0;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo e($idx + 1); ?></td>
                        <td class="text-bold"><?php echo e($item['ma_tour_thuc_te']); ?></td>
                        <td><?php echo e($item['tieu_de'] ?: 'Chưa có tên'); ?></td>
                        <td class="text-center">
                            <?php echo e($item['ngay_khoi_hanh'] ? \Carbon\Carbon::parse($item['ngay_khoi_hanh'])->format('d/m/Y') : ''); ?>

                        </td>
                        <td class="text-right">₫<?php echo e(number_format($item['gia_hien_hanh'], 0, '', ',')); ?></td>
                        <td class="text-center"><?php echo e($booked); ?> / <?php echo e($item['so_khach_toi_da']); ?></td>
                        <td class="text-center text-bold" style="color: <?php echo e($occupancyRate >= 80 ? '#059669' : ($occupancyRate >= 50 ? '#d97706' : '#dc2626')); ?>">
                            <?php echo e($occupancyRate); ?>%
                        </td>
                        <td class="text-center">
                            <?php if(strtoupper($item['trang_thai']) === 'HOAN_THANH' || strtoupper($item['trang_thai']) === 'COMPLETED'): ?>
                                <span class="badge badge-success">Hoàn thành</span>
                            <?php elseif(strtoupper($item['trang_thai']) === 'DANG_BAN' || strtoupper($item['trang_thai']) === 'BAN'): ?>
                                <span class="badge badge-info">Đang bán</span>
                            <?php elseif(strtoupper($item['trang_thai']) === 'KHOI_HANH'): ?>
                                <span class="badge badge-success">Khởi hành</span>
                            <?php elseif(strtoupper($item['trang_thai']) === 'HUY' || strtoupper($item['trang_thai']) === 'DA_HUY'): ?>
                                <span class="badge badge-danger">Đã hủy</span>
                            <?php else: ?>
                                <span class="badge badge-gray"><?php echo e($item['trang_thai']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="5" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">
                        TỔNG CỘNG (<?php echo e($totalCount); ?> tour):
                    </td>
                    <td class="text-center" style="font-size: 8pt; color: #1e3a8a; padding: 8px 6px;">
                        <?php echo e($totalBooked); ?> / <?php echo e($totalMax); ?> chỗ
                    </td>
                    <td class="text-center" style="font-size: 8pt; color: #1e3a8a; padding: 8px 6px;">
                        <?php echo e($totalMax > 0 ? round(($totalBooked / $totalMax) * 100, 1) : 0); ?>%
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('reports.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\asus\Downloads\J\WEB\DoAnWeb-TravelERP\backend\resources\views\reports\tour.blade.php ENDPATH**/ ?>