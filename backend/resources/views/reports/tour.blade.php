@extends('reports.layout')

@section('title', 'Báo cáo Thống kê Tour Thực tế')
@section('report_name', 'BÁO CÁO THỐNG KÊ TOUR THỰC TẾ')

@section('content')

    @if(!empty($chartSvg))
        <div class="chart-container">
            <div class="chart-title">Biểu đồ so sánh số lượng khách đã đặt (Top 15 Tour)</div>
            {!! $chartSvg !!}
        </div>
    @endif

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Danh Sách Tour Thực Tế Trong Kỳ</h2>
    
    @if(empty($data))
        <div class="empty-message">
            Không tìm thấy tour thực tế nào được ghi nhận trong khoảng thời gian này.
        </div>
    @else
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
                @php
                    $totalBooked = 0;
                    $totalMax = 0;
                    $totalCount = count($data);
                @endphp
                @foreach($data as $idx => $item)
                    @php
                        $booked = max(0, $item['so_khach_toi_da'] - $item['cho_con_lai']);
                        $totalBooked += $booked;
                        $totalMax += $item['so_khach_toi_da'];
                        $occupancyRate = $item['so_khach_toi_da'] > 0 ? round(($booked / $item['so_khach_toi_da']) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-bold">{{ $item['ma_tour_thuc_te'] }}</td>
                        <td>{{ $item['tieu_de'] ?: 'Chưa có tên' }}</td>
                        <td class="text-center">
                            {{ $item['ngay_khoi_hanh'] ? \Carbon\Carbon::parse($item['ngay_khoi_hanh'])->format('d/m/Y') : '' }}
                        </td>
                        <td class="text-right">₫{{ number_format($item['gia_hien_hanh'], 0, '', ',') }}</td>
                        <td class="text-center">{{ $booked }} / {{ $item['so_khach_toi_da'] }}</td>
                        <td class="text-center text-bold" style="color: {{ $occupancyRate >= 80 ? '#059669' : ($occupancyRate >= 50 ? '#d97706' : '#dc2626') }}">
                            {{ $occupancyRate }}%
                        </td>
                        <td class="text-center">
                            @if(strtoupper($item['trang_thai']) === 'HOAN_THANH' || strtoupper($item['trang_thai']) === 'COMPLETED')
                                <span class="badge badge-success">Hoàn thành</span>
                            @elseif(strtoupper($item['trang_thai']) === 'DANG_BAN' || strtoupper($item['trang_thai']) === 'BAN')
                                <span class="badge badge-info">Đang bán</span>
                            @elseif(strtoupper($item['trang_thai']) === 'KHOI_HANH')
                                <span class="badge badge-success">Khởi hành</span>
                            @elseif(strtoupper($item['trang_thai']) === 'HUY' || strtoupper($item['trang_thai']) === 'DA_HUY')
                                <span class="badge badge-danger">Đã hủy</span>
                            @else
                                <span class="badge badge-gray">{{ $item['trang_thai'] }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="5" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">
                        TỔNG CỘNG ({{ $totalCount }} tour):
                    </td>
                    <td class="text-center" style="font-size: 8pt; color: #1e3a8a; padding: 8px 6px;">
                        {{ $totalBooked }} / {{ $totalMax }} chỗ
                    </td>
                    <td class="text-center" style="font-size: 8pt; color: #1e3a8a; padding: 8px 6px;">
                        {{ $totalMax > 0 ? round(($totalBooked / $totalMax) * 100, 1) : 0 }}%
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

@endsection
