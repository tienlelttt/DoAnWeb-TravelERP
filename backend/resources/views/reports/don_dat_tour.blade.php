@extends('reports.layout')

@section('title', 'Báo cáo Đơn đặt Tour')
@section('report_name', 'BÁO CÁO CHI TIẾT ĐƠN ĐẶT TOUR')

@section('content')

    @if(!empty($chartSvg))
        <div class="chart-container">
            <div class="chart-title">Biểu đồ xu hướng số lượng đơn đặt tour theo ngày (Gần nhất)</div>
            <img src="data:image/svg+xml;base64,{{ base64_encode($chartSvg) }}" width="100%" style="width: 100%; height: auto;" />
        </div>
    @endif

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Danh Sách Đơn Đặt Tour Trong Kỳ</h2>
    
    @if(empty($data))
        <div class="empty-message">
            Không tìm thấy đơn đặt tour nào trong khoảng thời gian này.
        </div>
    @else
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
                @php
                    $totalRev = 0;
                    $totalCount = count($data);
                @endphp
                @foreach($data as $idx => $item)
                    @php
                        $totalRev += $item['tong_tien'];
                    @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-bold">{{ $item['ma_dat_tour'] }}</td>
                        <td>{{ $item['ma_tour_thuc_te'] }}</td>
                        <td>{{ $item['tieu_de_tour'] ?: 'Chưa có tên' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item['ngay_dat'])->format('d/m/Y') }}</td>
                        <td class="text-right text-bold">₫{{ number_format($item['tong_tien'], 0, '', ',') }}</td>
                        <td class="text-center">
                            @if(strtoupper($item['trang_thai']) === 'DA_THANH_TOAN')
                                <span class="badge badge-success">Đã thanh toán</span>
                            @elseif(strtoupper($item['trang_thai']) === 'CHO_XAC_NHAN' || strtoupper($item['trang_thai']) === 'CHO_THANH_TOAN')
                                <span class="badge badge-warning">Chờ duyệt</span>
                            @elseif(strtoupper($item['trang_thai']) === 'HUY' || strtoupper($item['trang_thai']) === 'DA_HUY')
                                <span class="badge badge-danger">Đã hủy</span>
                            @else
                                <span class="badge badge-info">{{ str_replace('_', ' ', $item['trang_thai']) }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">
                        TỔNG CỘNG ({{ $totalCount }} đơn):
                    </td>
                    <td></td>
                    <td class="text-right" style="font-size: 8pt; color: #1e3a8a; padding: 8px 6px;">₫{{ number_format($totalRev, 0, '', ',') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

@endsection
