@extends('reports.layout')

@section('title', 'Báo cáo Phân tích Chi phí Thực tế')
@section('report_name', 'BÁO CÁO PHÂN TÍCH CHI PHÍ THỰC TẾ')

@section('content')

    @if(!empty($chartSvg))
        <div class="chart-container">
            <div class="chart-title">Biểu đồ tỷ lệ chi phí thực tế phát sinh theo Danh mục (Top 15 Danh mục)</div>
            <img src="data:image/svg+xml;base64,{{ base64_encode($chartSvg) }}" width="100%" style="width: 100%; height: auto;" />
        </div>
    @endif

    <h2 style="font-size: 10pt; font-weight: bold; color: #1e293b; margin-top: 25px; margin-bottom: 8px;">Danh Sách Chi Phí Thực Tế Phát Sinh</h2>
    
    @if(empty($data))
        <div class="empty-message">
            Không tìm thấy chi phí thực tế nào được ghi nhận trong khoảng thời gian này.
        </div>
    @else
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
                @php
                    $totalCost = 0;
                    $totalCount = count($data);
                @endphp
                @foreach($data as $idx => $item)
                    @php
                        $totalCost += $item['thanh_tien'];
                    @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-bold">{{ $item['ma_chi_phi_thuc_te'] }}</td>
                        <td>{{ $item['ma_tour_thuc_te'] }}</td>
                        <td>{{ $item['danh_muc'] ?: 'Khác' }}</td>
                        <td class="text-center">
                            {{ $item['ngay_khai'] ? \Carbon\Carbon::parse($item['ngay_khai'])->format('d/m/Y') : '' }}
                        </td>
                        <td class="text-right text-bold">₫{{ number_format($item['thanh_tien'], 0, '', ',') }}</td>
                        <td class="text-center">
                            @if(strtoupper($item['trang_thai_duyet']) === 'DA_DUYET' || strtoupper($item['trang_thai_duyet']) === 'DUYET')
                                <span class="badge badge-success">Đã duyệt</span>
                            @elseif(strtoupper($item['trang_thai_duyet']) === 'CHO_DUYET')
                                <span class="badge badge-warning">Chờ duyệt</span>
                            @elseif(strtoupper($item['trang_thai_duyet']) === 'TU_CHOI' || strtoupper($item['trang_thai_duyet']) === 'KHONG_DUYET')
                                <span class="badge badge-danger">Từ chối</span>
                            @else
                                <span class="badge badge-info">{{ $item['trang_thai_duyet'] }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="4" class="text-right text-bold" style="font-size: 8pt; color: #111827; padding: 8px 6px;">
                        TỔNG CỘNG ({{ $totalCount }} khoản):
                    </td>
                    <td></td>
                    <td class="text-right" style="font-size: 8pt; color: #991b1b; padding: 8px 6px;">₫{{ number_format($totalCost, 0, '', ',') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

@endsection
