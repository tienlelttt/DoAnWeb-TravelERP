@extends('reports.layout')

@section('title', 'Báo cáo Chi tiết Giao dịch Thanh toán')
@section('report_name', 'BÁO CÁO CHI TIẾT GIAO DỊCH THANH TOÁN')

@section('content')

    @if(!empty($chartSvg))
        <div class="chart-container">
            <div class="chart-title">Biểu đồ tỷ lệ giá trị giao dịch theo Phương thức (Top Phương thức)</div>
            {!! $chartSvg !!}
        </div>
    @endif

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Nhật Ký Giao Dịch Thanh Toán</h2>
    
    @if(empty($data))
        <div class="empty-message">
            Không tìm thấy giao dịch thanh toán nào phát sinh trong khoảng thời gian này.
        </div>
    @else
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
                @php
                    $totalAmount = 0;
                    $totalCount = count($data);
                @endphp
                @foreach($data as $idx => $item)
                    @php
                        $totalAmount += $item['so_tien'];
                    @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-bold">{{ $item['ma_giao_dich'] }}</td>
                        <td>{{ $item['ma_dat_tour'] }}</td>
                        <td>
                            @if(strtoupper($item['phuong_thuc']) === 'TIEN_MAT')
                                <span>Tiền mặt</span>
                            @elseif(strtoupper($item['phuong_thuc']) === 'CHUYEN_KHOAN')
                                <span>Chuyển khoản</span>
                            @else
                                <span>{{ $item['phuong_thuc'] }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $item['ngay_thanh_toan'] ? \Carbon\Carbon::parse($item['ngay_thanh_toan'])->format('d/m/Y H:i') : '' }}
                        </td>
                        <td class="text-right text-bold" style="color: {{ strtoupper($item['trang_thai']) === 'THANH_CONG' || strtoupper($item['trang_thai']) === 'SUCCESS' ? '#059669' : '#374151' }}">
                            ₫{{ number_format($item['so_tien'], 0, '', ',') }}
                        </td>
                        <td class="text-center">
                            @if(strtoupper($item['trang_thai']) === 'THANH_CONG' || strtoupper($item['trang_thai']) === 'SUCCESS')
                                <span class="badge badge-success">Thành công</span>
                            @elseif(strtoupper($item['trang_thai']) === 'THAT_BAI' || strtoupper($item['trang_thai']) === 'FAILED')
                                <span class="badge badge-danger">Thất bại</span>
                            @elseif(strtoupper($item['trang_thai']) === 'CHO_XAC_NHAN' || strtoupper($item['trang_thai']) === 'PENDING')
                                <span class="badge badge-warning">Chờ xử lý</span>
                            @else
                                <span class="badge badge-info">{{ $item['trang_thai'] }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">
                        TỔNG DOANH SỐ ({{ $totalCount }} giao dịch):
                    </td>
                    <td></td>
                    <td class="text-right" style="font-size: 8pt; color: #047857; padding: 8px 6px;">₫{{ number_format($totalAmount, 0, '', ',') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

@endsection
