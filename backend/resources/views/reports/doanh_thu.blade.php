@extends('reports.layout')

@section('title', 'Báo cáo Doanh thu & Quyết toán')
@section('report_name', 'BÁO CÁO DOANH THU & QUYẾT TOÁN TOUR')

@section('content')

    @if(!empty($chartSvg))
        <div class="chart-container">
            <div class="chart-title">Biểu đồ so sánh doanh thu, chi phí và lợi nhuận (Top 15 Tour)</div>
            {!! $chartSvg !!}
        </div>
    @endif

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Bảng Chi Tiết Quyết Toán Tour</h2>
    
    @if(empty($data))
        <div class="empty-message">
            Không có dữ liệu quyết toán nào được ghi nhận trong khoảng thời gian này.
        </div>
    @else
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
                @php
                    $totalRev = 0;
                    $totalCost = 0;
                    $totalProfit = 0;
                @endphp
                @foreach($data as $idx => $item)
                    @php
                        $totalRev += $item['tong_doanh_thu'];
                        $totalCost += $item['tong_chi_phi'];
                        $totalProfit += $item['loi_nhuan'];
                    @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-bold">{{ $item['ma_quyet_toan'] }}</td>
                        <td>{{ $item['ma_tour_thuc_te'] }}</td>
                        <td>{{ $item['tieu_de_tour'] ?: 'Chưa có tên' }}</td>
                        <td class="text-right">₫{{ number_format($item['tong_doanh_thu'], 0, '', ',') }}</td>
                        <td class="text-right">₫{{ number_format($item['tong_chi_phi'], 0, '', ',') }}</td>
                        <td class="text-right text-bold {{ $item['loi_nhuan'] < 0 ? 'text-danger' : '' }}" style="color: {{ $item['loi_nhuan'] < 0 ? '#dc2626' : '#059669' }}">
                            ₫{{ number_format($item['loi_nhuan'], 0, '', ',') }}
                        </td>
                        <td class="text-center">
                            @if(strtoupper($item['trang_thai']) === 'DA_CHOT' || strtoupper($item['trang_thai']) === 'COMPLETED' || strtoupper($item['trang_thai']) === 'CHOT')
                                <span class="badge badge-success">Đã chốt</span>
                            @elseif(strtoupper($item['trang_thai']) === 'YEU_CAU_BO_SUNG')
                                <span class="badge badge-warning">Cần bổ sung</span>
                            @else
                                <span class="badge badge-info">{{ $item['trang_thai'] }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">TỔNG CỘNG:</td>
                    <td class="text-right" style="font-size: 8pt; color: #1e3a8a; padding: 8px 6px;">₫{{ number_format($totalRev, 0, '', ',') }}</td>
                    <td class="text-right" style="font-size: 8pt; color: #991b1b; padding: 8px 6px;">₫{{ number_format($totalCost, 0, '', ',') }}</td>
                    <td class="text-right" style="font-size: 8pt; color: {{ $totalProfit < 0 ? '#991b1b' : '#047857' }}; padding: 8px 6px;">
                        ₫{{ number_format($totalProfit, 0, '', ',') }}
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

@endsection
