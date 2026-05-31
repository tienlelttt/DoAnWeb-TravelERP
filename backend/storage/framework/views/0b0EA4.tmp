<?php $__env->startSection('title', 'Báo cáo Phân tích Chi phí Thực tế'); ?>
<?php $__env->startSection('report_name', 'BÁO CÁO PHÂN TÍCH CHI PHÍ THỰC TẾ'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(!empty($chartSvg)): ?>
        <div class="chart-container">
            <div class="chart-title">Biểu đồ tỷ lệ chi phí thực tế phát sinh theo Danh mục (Top 15 Danh mục)</div>
            <?php echo $chartSvg; ?>

        </div>
    <?php endif; ?>

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Danh Sách Chi Phí Thực Tế Phát Sinh</h2>
    
    <?php if(empty($data)): ?>
        <div class="empty-message">
            Không tìm thấy chi phí thực tế nào được ghi nhận trong khoảng thời gian này.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">STT</th>
                    <th style="width: 15%;">Mã Chi Phí</th>
                    <th style="width: 15%;">Mã Tour TT</th>
                    <th>Danh Mục Chi Phí</th>
                    <th class="text-center" style="width: 15%;">Ngày Khai</th>
                    <th class="text-right" style="width: 18%;">Thành Tiền</th>
                    <th class="text-center" style="width: 12%;">Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalCost = 0;
                    $totalCount = count($data);
                ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $totalCost += $item['thanh_tien'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo e($idx + 1); ?></td>
                        <td class="text-bold"><?php echo e($item['ma_chi_phi_thuc_te']); ?></td>
                        <td><?php echo e($item['ma_tour_thuc_te']); ?></td>
                        <td><?php echo e($item['danh_muc'] ?: 'Khác'); ?></td>
                        <td class="text-center">
                            <?php echo e($item['ngay_khai'] ? \Carbon\Carbon::parse($item['ngay_khai'])->format('d/m/Y') : ''); ?>

                        </td>
                        <td class="text-right text-bold">₫<?php echo e(number_format($item['thanh_tien'], 0, '', ',')); ?></td>
                        <td class="text-center">
                            <?php if(strtoupper($item['trang_thai_duyet']) === 'DA_DUYET' || strtoupper($item['trang_thai_duyet']) === 'DUYET'): ?>
                                <span class="badge badge-success">Đã duyệt</span>
                            <?php elseif(strtoupper($item['trang_thai_duyet']) === 'CHO_DUYET'): ?>
                                <span class="badge badge-warning">Chờ duyệt</span>
                            <?php elseif(strtoupper($item['trang_thai_duyet']) === 'TU_CHOI' || strtoupper($item['trang_thai_duyet']) === 'KHONG_DUYET'): ?>
                                <span class="badge badge-danger">Từ chối</span>
                            <?php else: ?>
                                <span class="badge badge-info"><?php echo e($item['trang_thai_duyet']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">
                        TỔNG CỘNG (<?php echo e($totalCount); ?> khoản):
                    </td>
                    <td></td>
                    <td class="text-right" style="font-size: 8pt; color: #991b1b; padding: 8px 6px;">₫<?php echo e(number_format($totalCost, 0, '', ',')); ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('reports.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\asus\Downloads\J\WEB\DoAnWeb-TravelERP\backend\resources\views\reports\chi_phi.blade.php ENDPATH**/ ?>