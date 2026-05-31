<?php

namespace App\Helpers;

/**
 * Lớp trợ giúp vẽ biểu đồ vector SVG thuần PHP, chất lượng cao, hiển thị tiếng Việt hoàn hảo.
 */
class SvgChartHelper
{
    private static $colors = [
        '#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6',
        '#ec4899', '#14b8a6', '#6366f1', '#f97316', '#6b7280'
    ];

    /**
     * Biểu đồ Cột Nhóm (Grouped Bar Chart)
     * Thích hợp so sánh Doanh thu - Chi phí - Lợi nhuận của từng tour.
     */
    public static function groupedBar(array $data, array $labels, array $legend = ['Doanh thu', 'Chi phí', 'Lợi nhuận']): string
    {
        $w = 680;
        $h = 280;
        $padLeft = 80;
        $padRight = 120;
        $padTop = 30;
        $padBottom = 40;

        $plotW = $w - $padLeft - $padRight;
        $plotH = $h - $padTop - $padBottom;

        // Tìm giá trị cực đại để chia tỉ lệ trục Y (tối thiểu là 1)
        $maxVal = 1;
        foreach ($data as $group) {
            foreach ($group as $val) {
                if ($val > $maxVal) $maxVal = $val;
            }
        }
        // Làm tròn giá trị Y lớn nhất lên một khoảng đẹp
        $magnitude = pow(10, floor(log10($maxVal)));
        if ($magnitude > 0) {
            $ceilFactor = ceil($maxVal / ($magnitude / 2)) * ($magnitude / 2);
            $maxVal = $ceilFactor > 0 ? $ceilFactor : $maxVal;
        }

        $svg = "<svg width=\"{$w}\" height=\"{$h}\" viewBox=\"0 0 {$w} {$h}\" xmlns=\"http://www.w3.org/2000/svg\" style=\"font-family: Arial, sans-serif;\">\n";
        
        // Vẽ lưới và nhãn trục Y (5 vạch chia)
        for ($i = 0; $i <= 4; $i++) {
            $ratio = $i / 4;
            $y = $h - $padBottom - ($plotH * $ratio);
            $val = $maxVal * $ratio;
            
            // Định dạng số tiền viết tắt
            $valText = self::formatShortNumber($val);
            
            // Đường lưới ngang
            $svg .= "  <line x1=\"{$padLeft}\" y1=\"{$y}\" x2=\"" . ($w - $padRight) . "\" y2=\"{$y}\" stroke=\"#f3f4f6\" stroke-width=\"1\" />\n";
            // Nhãn Y
            $svg .= "  <text x=\"" . ($padLeft - 10) . "\" y=\"" . ($y + 4) . "\" font-size=\"10\" fill=\"#6b7280\" text-anchor=\"end\">{$valText}</text>\n";
        }

        // Vẽ cột và nhãn trục X
        $numGroups = count($labels);
        if ($numGroups > 0) {
            $groupW = $plotW / $numGroups;
            $barW = ($groupW * 0.7) / 3; // 3 cột trong 1 nhóm
            $gap = $groupW * 0.15;

            for ($i = 0; $i < $numGroups; $i++) {
                $group = $data[$i] ?? [0, 0, 0];
                $label = $labels[$i];
                // Cắt nhãn nếu quá dài
                if (mb_strlen($label) > 15) {
                    $label = mb_substr($label, 0, 13) . '...';
                }

                $groupX = $padLeft + ($i * $groupW) + $gap;

                // Vẽ 3 cột: Doanh thu, Chi phí, Lợi nhuận
                for ($j = 0; $j < 3; $j++) {
                    $val = (float) ($group[$j] ?? 0);
                    $barH = ($val / $maxVal) * $plotH;
                    $bx = $groupX + ($j * $barW);
                    $by = $h - $padBottom - $barH;
                    $color = self::$colors[$j];

                    // Cột vẽ bằng thẻ rect có góc hơi bo
                    $svg .= "  <rect x=\"{$bx}\" y=\"{$by}\" width=\"" . ($barW - 1) . "\" height=\"{$barH}\" fill=\"{$color}\" rx=\"2\" />\n";
                }

                // Nhãn trục X (tên Tour) xoay nhẹ hoặc nằm ngang
                $labelX = $groupX + ($groupW * 0.35);
                $labelY = $h - $padBottom + 18;
                $svg .= "  <text x=\"{$labelX}\" y=\"{$labelY}\" font-size=\"9\" fill=\"#374151\" text-anchor=\"middle\">{$label}</text>\n";
            }
        }

        // Vẽ trục chính X, Y
        $svg .= "  <line x1=\"{$padLeft}\" y1=\"" . ($h - $padBottom) . "\" x2=\"" . ($w - $padRight) . "\" y2=\"" . ($h - $padBottom) . "\" stroke=\"#d1d5db\" stroke-width=\"1.5\" />\n";
        $svg .= "  <line x1=\"{$padLeft}\" y1=\"{$padTop}\" x2=\"{$padLeft}\" y2=\"" . ($h - $padBottom) . "\" stroke=\"#d1d5db\" stroke-width=\"1.5\" />\n";

        // Vẽ Legend bên phải biểu đồ
        $lx = $w - $padRight + 15;
        for ($k = 0; $k < count($legend); $k++) {
            $ly = $padTop + ($k * 22) + 10;
            $color = self::$colors[$k];
            $svg .= "  <rect x=\"{$lx}\" y=\"{$ly}\" width=\"12\" height=\"12\" fill=\"{$color}\" rx=\"2\" />\n";
            $svg .= "  <text x=\"" . ($lx + 18) . "\" y=\"" . ($ly + 10) . "\" font-size=\"10\" fill=\"#4b5563\" font-weight=\"bold\">{$legend[$k]}</text>\n";
        }

        $svg .= "</svg>\n";
        return $svg;
    }

    /**
     * Biểu đồ Đường (Line Chart)
     * Thích hợp vẽ xu hướng doanh thu/số lượng theo thời gian.
     */
    public static function line(array $data, array $labels, string $lineLabel = 'Số lượng'): string
    {
        $w = 680;
        $h = 240;
        $padLeft = 70;
        $padRight = 40;
        $padTop = 20;
        $padBottom = 40;

        $plotW = $w - $padLeft - $padRight;
        $plotH = $h - $padTop - $padBottom;

        $maxVal = 1;
        foreach ($data as $val) {
            if ($val > $maxVal) $maxVal = $val;
        }
        $magnitude = pow(10, floor(log10($maxVal)));
        if ($magnitude > 0) {
            $ceilFactor = ceil($maxVal / ($magnitude / 2)) * ($magnitude / 2);
            $maxVal = $ceilFactor > 0 ? $ceilFactor : $maxVal;
        }

        $svg = "<svg width=\"{$w}\" height=\"{$h}\" viewBox=\"0 0 {$w} {$h}\" xmlns=\"http://www.w3.org/2000/svg\" style=\"font-family: Arial, sans-serif;\">\n";

        // Trục Y
        for ($i = 0; $i <= 4; $i++) {
            $ratio = $i / 4;
            $y = $h - $padBottom - ($plotH * $ratio);
            $val = $maxVal * $ratio;
            $valText = self::formatShortNumber($val);

            $svg .= "  <line x1=\"{$padLeft}\" y1=\"{$y}\" x2=\"" . ($w - $padRight) . "\" y2=\"{$y}\" stroke=\"#f3f4f6\" stroke-width=\"1\" />\n";
            $svg .= "  <text x=\"" . ($padLeft - 10) . "\" y=\"" . ($y + 4) . "\" font-size=\"10\" fill=\"#6b7280\" text-anchor=\"end\">{$valText}</text>\n";
        }

        // Vẽ đường và điểm nút
        $numPoints = count($data);
        if ($numPoints > 0) {
            $pointsX = [];
            $pointsY = [];
            $stepX = $numPoints > 1 ? $plotW / ($numPoints - 1) : $plotW;

            for ($i = 0; $i < $numPoints; $i++) {
                $pointsX[$i] = $padLeft + ($i * $stepX);
                $pointsY[$i] = $h - $padBottom - (($data[$i] / $maxVal) * $plotH);

                // Nhãn X (chỉ in khoảng cách để tránh tràn chữ)
                $labelInterval = max(1, ceil($numPoints / 10));
                if ($i % $labelInterval === 0 || $i === $numPoints - 1) {
                    $svg .= "  <text x=\"{$pointsX[$i]}\" y=\"" . ($h - $padBottom + 18) . "\" font-size=\"9\" fill=\"#374151\" text-anchor=\"middle\">{$labels[$i]}</text>\n";
                }
            }

            // Dựng đường Path nối các điểm
            $pathD = "M {$pointsX[0]} {$pointsY[0]}";
            for ($i = 1; $i < $numPoints; $i++) {
                $pathD .= " L {$pointsX[$i]} {$pointsY[$i]}";
            }

            // Vẽ đường
            $svg .= "  <path d=\"{$pathD}\" fill=\"none\" stroke=\"#3b82f6\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" />\n";

            // Vẽ các chấm và tooltip giá trị nhỏ
            for ($i = 0; $i < $numPoints; $i++) {
                $svg .= "  <circle cx=\"{$pointsX[$i]}\" cy=\"{$pointsY[$i]}\" r=\"3.5\" fill=\"#1e3a8a\" stroke=\"#ffffff\" stroke-width=\"1.5\" />\n";
                // Giá trị nhỏ trên đầu nút (nếu số lượng điểm không quá nhiều)
                if ($numPoints <= 15) {
                    $valText = number_format($data[$i], 0, '', ',');
                    $svg .= "  <text x=\"{$pointsX[$i]}\" y=\"" . ($pointsY[$i] - 7) . "\" font-size=\"8\" font-weight=\"bold\" fill=\"#1e293b\" text-anchor=\"middle\">{$valText}</text>\n";
                }
            }
        }

        // Vẽ trục chính X, Y
        $svg .= "  <line x1=\"{$padLeft}\" y1=\"" . ($h - $padBottom) . "\" x2=\"" . ($w - $padRight) . "\" y2=\"" . ($h - $padBottom) . "\" stroke=\"#d1d5db\" stroke-width=\"1.5\" />\n";
        $svg .= "  <line x1=\"{$padLeft}\" y1=\"{$padTop}\" x2=\"{$padLeft}\" y2=\"" . ($h - $padBottom) . "\" stroke=\"#d1d5db\" stroke-width=\"1.5\" />\n";

        $svg .= "</svg>\n";
        return $svg;
    }

    /**
     * Biểu đồ Tròn (Pie Chart)
     * Thích hợp vẽ tỷ lệ phần trăm (Chi phí danh mục, phương thức thanh toán).
     */
    public static function pie(array $data, array $labels): string
    {
        $w = 680;
        $h = 240;
        $cx = 240;
        $cy = 120;
        $r = 90;

        $total = array_sum($data);
        if ($total <= 0) $total = 1;

        $svg = "<svg width=\"{$w}\" height=\"{$h}\" viewBox=\"0 0 {$w} {$h}\" xmlns=\"http://www.w3.org/2000/svg\" style=\"font-family: Arial, sans-serif;\">\n";

        $currentAngle = 0.0;
        $numSlices = count($data);

        for ($i = 0; $i < $numSlices; $i++) {
            $val = (float) $data[$i];
            if ($val <= 0) continue;

            $fraction = $val / $total;
            $angleDegrees = $fraction * 360;
            $color = self::$colors[$i % count(self::$colors)];

            // Tính toán toạ độ lượng giác để dựng path cho hình tròn
            // Đổi góc từ độ sang radian
            $startAngleRad = deg2rad($currentAngle - 90); // -90 độ để bắt đầu từ đỉnh trên cùng (12 giờ)
            $endAngleRad = deg2rad($currentAngle + $angleDegrees - 90);

            $x1 = $cx + $r * cos($startAngleRad);
            $y1 = $cy + $r * sin($startAngleRad);
            $x2 = $cx + $r * cos($endAngleRad);
            $y2 = $cy + $r * sin($endAngleRad);

            // Large Arc Flag: nếu góc > 180 độ thì bằng 1, ngược lại bằng 0
            $largeArcFlag = $angleDegrees > 180 ? 1 : 0;

            // Xử lý đặc biệt nếu chỉ có 1 phần tử duy nhất lấp đầy 100%
            if ($angleDegrees >= 360) {
                $svg .= "  <circle cx=\"{$cx}\" cy=\"{$cy}\" r=\"{$r}\" fill=\"{$color}\" />\n";
            } else {
                // Lệnh d vẽ: Di chuyển đến tâm -> vẽ đường đến điểm 1 -> vẽ cung tròn đến điểm 2 -> đóng đường về tâm
                $pathD = "M {$cx} {$cy} L {$x1} {$y1} A {$r} {$r} 0 {$largeArcFlag} 1 {$x2} {$y2} Z";
                $svg .= "  <path d=\"{$pathD}\" fill=\"{$color}\" stroke=\"#ffffff\" stroke-width=\"1.5\" />\n";
            }

            $currentAngle += $angleDegrees;
        }

        // Vẽ Legend và tỉ lệ % bên phải biểu đồ
        $lx = 420;
        for ($i = 0; $i < $numSlices; $i++) {
            $val = (float) $data[$i];
            $pct = $total > 0 ? ($val / $total) * 100 : 0;
            $color = self::$colors[$i % count(self::$colors)];
            $label = $labels[$i];
            if (mb_strlen($label) > 18) {
                $label = mb_substr($label, 0, 16) . '...';
            }

            $ly = 30 + ($i * 20);
            $valText = number_format($val, 0, '', ',');
            $pctText = number_format($pct, 1) . '%';

            $svg .= "  <rect x=\"{$lx}\" y=\"{$ly}\" width=\"12\" height=\"12\" fill=\"{$color}\" rx=\"2\" />\n";
            $svg .= "  <text x=\"" . ($lx + 18) . "\" y=\"" . ($ly + 10) . "\" font-size=\"10\" fill=\"#374151\">{$label} ({$pctText} - {$valText})</text>\n";
        }

        $svg .= "</svg>\n";
        return $svg;
    }

    /**
     * Biểu đồ Thanh Ngang (Horizontal Bar Chart)
     * Thích hợp so sánh tỷ lệ hoàn thành, lấp đầy tour hoặc top sản phẩm bán chạy.
     */
    public static function horizontalBar(array $data, array $labels, string $valUnit = ''): string
    {
        $w = 680;
        $h = 280;
        $padLeft = 140; // Rộng hơn để chứa nhãn bên trái
        $padRight = 50;
        $padTop = 20;
        $padBottom = 30;

        $plotW = $w - $padLeft - $padRight;
        $plotH = $h - $padTop - $padBottom;

        $maxVal = 1;
        foreach ($data as $val) {
            if ($val > $maxVal) $maxVal = $val;
        }
        // Làm tròn lên
        $magnitude = pow(10, floor(log10($maxVal)));
        if ($magnitude > 0) {
            $ceilFactor = ceil($maxVal / ($magnitude / 2)) * ($magnitude / 2);
            $maxVal = $ceilFactor > 0 ? $ceilFactor : $maxVal;
        }

        $svg = "<svg width=\"{$w}\" height=\"{$h}\" viewBox=\"0 0 {$w} {$h}\" xmlns=\"http://www.w3.org/2000/svg\" style=\"font-family: Arial, sans-serif;\">\n";

        // Vẽ vạch và lưới dọc trục X
        for ($i = 0; $i <= 4; $i++) {
            $ratio = $i / 4;
            $x = $padLeft + ($plotW * $ratio);
            $val = $maxVal * $ratio;
            $valText = self::formatShortNumber($val);

            $svg .= "  <line x1=\"{$x}\" y1=\"{$padTop}\" x2=\"{$x}\" y2=\"" . ($h - $padBottom) . "\" stroke=\"#f3f4f6\" stroke-width=\"1\" />\n";
            $svg .= "  <text x=\"{$x}\" y=\"" . ($h - $padBottom + 14) . "\" font-size=\"9\" fill=\"#6b7280\" text-anchor=\"middle\">{$valText}</text>\n";
        }

        // Vẽ các thanh ngang
        $numBars = count($data);
        if ($numBars > 0) {
            $barH = ($plotH / $numBars) * 0.65;
            $gap = ($plotH / $numBars) * 0.35;

            for ($i = 0; $i < $numBars; $i++) {
                $val = (float) $data[$i];
                $barW = ($val / $maxVal) * $plotW;
                $color = self::$colors[$i % count(self::$colors)];

                $by = $padTop + ($i * ($barH + $gap)) + ($gap / 2);
                $bx = $padLeft;

                // Thanh ngang bo tròn góc phải
                $svg .= "  <rect x=\"{$bx}\" y=\"{$by}\" width=\"{$barW}\" height=\"{$barH}\" fill=\"{$color}\" rx=\"2\" />\n";

                // Nhãn bên trái (tên)
                $label = $labels[$i];
                if (mb_strlen($label) > 22) {
                    $label = mb_substr($label, 0, 20) . '...';
                }
                $svg .= "  <text x=\"" . ($padLeft - 8) . "\" y=\"" . ($by + ($barH / 2) + 4) . "\" font-size=\"9\" font-weight=\"bold\" fill=\"#374151\" text-anchor=\"end\">{$label}</text>\n";

                // Giá trị bên phải thanh
                $valText = number_format($val, 0, '', ',') . $valUnit;
                $svg .= "  <text x=\"" . ($padLeft + $barW + 5) . "\" y=\"" . ($by + ($barH / 2) + 4) . "\" font-size=\"9\" font-weight=\"bold\" fill=\"#1e293b\">{$valText}</text>\n";
            }
        }

        // Vẽ trục chính X, Y
        $svg .= "  <line x1=\"{$padLeft}\" y1=\"" . ($h - $padBottom) . "\" x2=\"" . ($w - $padRight) . "\" y2=\"" . ($h - $padBottom) . "\" stroke=\"#d1d5db\" stroke-width=\"1.5\" />\n";
        $svg .= "  <line x1=\"{$padLeft}\" y1=\"{$padTop}\" x2=\"{$padLeft}\" y2=\"" . ($h - $padBottom) . "\" stroke=\"#d1d5db\" stroke-width=\"1.5\" />\n";

        $svg .= "</svg>\n";
        return $svg;
    }

    /**
     * Định dạng số thành viết tắt (ví dụ: 1,500,000 -> 1.5M, 20,000 -> 20K)
     */
    private static function formatShortNumber(float $val): string
    {
        if ($val >= 1000000000) {
            return round($val / 1000000000, 1) . 'B';
        }
        if ($val >= 1000000) {
            return round($val / 1000000, 1) . 'M';
        }
        if ($val >= 1000) {
            return round($val / 1000, 1) . 'K';
        }
        return (string) round($val, 0);
    }
}
