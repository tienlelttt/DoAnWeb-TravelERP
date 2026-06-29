<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KinhDoanhTongHopController extends Controller
{
    /**
     * Lấy danh sách tổng hợp Yêu cầu hỗ trợ và Sự cố
     * GET /api/kinh-doanh/tong-hop-khieu-nai-su-co
     */
    public function danhSachTongHop(Request $request)
    {
        $search = $request->query('search');
        $trangThai = $request->query('trangThai');
        $mucDo = $request->query('mucDo');
        $page = (int) $request->query('page', 0) + 1;
        $size = (int) $request->query('size', 10);

        // Subquery cho Yêu cầu hỗ trợ (Complaints)
        $ycQuery = DB::table('yeu_cau_ho_tros as yc')
            ->leftJoin('don_dat_tours as ddt', 'yc.ma_dat_tour', '=', 'ddt.ma_dat_tour')
            ->leftJoin('tour_thuc_tes as tt', 'ddt.ma_tour_thuc_te', '=', 'tt.ma_tour_thuc_te')
            ->leftJoin('tour_maus as tm', 'tt.ma_tour_mau', '=', 'tm.ma_tour_mau')
            ->leftJoin('ho_chieu_sos as hcs', 'yc.ma_khach_hang', '=', 'hcs.ma_khach_hang')
            ->leftJoin('tai_khoans as tk', 'hcs.ma_tai_khoan', '=', 'tk.ma_tai_khoan')
            ->whereNotIn('yc.loai_yeu_cau', ['HUY_TOUR', 'HOAN_TIEN'])
            ->select(
                'yc.ma_yeu_cau_ho_tro as ma',
                'yc.ma_dat_tour',
                'tt.ma_tour_thuc_te',
                'tm.tieu_de as ten_tour',
                'tk.ho_ten as ten_khach_hang',
                'tk.so_dien_thoai',
                'yc.loai_yeu_cau as loai',
                'yc.noi_dung',
                'yc.trang_thai',
                DB::raw('NULL as muc_do'),
                'yc.ma_nhan_vien_xu_ly as ma_nhan_vien',
                'yc.created_at as thoi_gian',
                DB::raw("'YEU_CAU' as loai_ban_ghi")
            );

        // Subquery cho Sự cố (Incidents)
        $scQuery = DB::table('nhat_ky_su_cos as sc')
            ->leftJoin('tour_thuc_tes as tt', 'sc.ma_tour_thuc_te', '=', 'tt.ma_tour_thuc_te')
            ->leftJoin('tour_maus as tm', 'tt.ma_tour_mau', '=', 'tm.ma_tour_mau')
            ->leftJoin('ho_chieu_sos as hcs', 'sc.ma_khach_hang', '=', 'hcs.ma_khach_hang')
            ->leftJoin('tai_khoans as tk', 'hcs.ma_tai_khoan', '=', 'tk.ma_tai_khoan')
            ->select(
                'sc.ma_nhat_ky_su_co as ma',
                DB::raw("'' as ma_dat_tour"),
                'sc.ma_tour_thuc_te',
                'tm.tieu_de as ten_tour',
                'tk.ho_ten as ten_khach_hang',
                'tk.so_dien_thoai',
                'sc.loai_su_co as loai',
                'sc.mo_ta as noi_dung',
                DB::raw("'CHUA_XU_LY' as trang_thai"), // Mặc định map qua để giống complaint status (hoặc pending)
                'sc.muc_do',
                'sc.ma_nhan_vien_bao_cao as ma_nhan_vien',
                'sc.thoi_gian_bao_cao as thoi_gian',
                DB::raw("'SU_CO' as loai_ban_ghi")
            );

        // Bộ lọc chung
        if ($search) {
            $searchVal = "%{$search}%";
            $ycQuery->where(function ($q) use ($searchVal) {
                $q->where('yc.ma_yeu_cau_ho_tro', 'like', $searchVal)
                  ->orWhere('yc.ma_dat_tour', 'like', $searchVal)
                  ->orWhere('tk.ho_ten', 'like', $searchVal);
            });
            $scQuery->where(function ($q) use ($searchVal) {
                $q->where('sc.ma_nhat_ky_su_co', 'like', $searchVal)
                  ->orWhere('tk.ho_ten', 'like', $searchVal);
            });
        }

        // Bộ lọc trạng thái
        if ($trangThai && $trangThai !== 'all') {
            $apiStatus = '';
            switch ($trangThai) {
                case 'resolved': $apiStatus = 'DA_XU_LY'; break;
                case 'rejected': $apiStatus = 'TU_CHOI'; break;
                case 'pending_info': $apiStatus = 'CHO_BO_SUNG'; break;
                case 'pending_guide': $apiStatus = 'CHO_GIAI_TRINH'; break;
                case 'pending': $apiStatus = 'CHUA_XU_LY'; break;
            }
            if ($apiStatus) {
                $ycQuery->where('yc.trang_thai', $apiStatus);
                if ($apiStatus !== 'CHUA_XU_LY') {
                    $scQuery->whereRaw('1 = 0');
                }
            }
        }

        // Bộ lọc mức độ
        if ($mucDo && $mucDo !== 'all') {
            if ($mucDo === 'SOS') {
                $ycQuery->whereRaw('1 = 0'); // Không có complaint SOS
                $scQuery->where('sc.muc_do', 'SOS');
            } else if ($mucDo === 'THAP') {
                $scQuery->where('sc.muc_do', '!=', 'SOS');
            }
        }

        $unionQuery = $ycQuery->unionAll($scQuery);
        $paginator = DB::query()->fromSub($unionQuery, 'u')
                        ->orderBy('thoi_gian', 'desc')
                        ->paginate($size, ['*'], 'page', $page);

        $items = collect($paginator->items())->map(function($item) {
            if ($item->loai_ban_ghi === 'YEU_CAU') {
                return [
                    'source_type' => 'complaint',
                    'maYeuCau' => $item->ma,
                    'maDatTour' => $item->ma_dat_tour,
                    'maTourThucTe' => $item->ma_tour_thuc_te,
                    'tenTour' => $item->ten_tour,
                    'tenKhachHang' => $item->ten_khach_hang,
                    'soDienThoai' => $item->so_dien_thoai,
                    'loaiYeuCau' => $item->loai,
                    'noiDung' => $item->noi_dung,
                    'trangThai' => $item->trang_thai,
                    'maNhanVienXuLy' => $item->ma_nhan_vien,
                    'thoiDiemTao' => $item->thoi_gian
                ];
            } else {
                return [
                    'source_type' => 'incident',
                    'maNhatKySuCo' => $item->ma,
                    'maTour' => $item->ma_tour_thuc_te,
                    'loaiSuCo' => $item->loai,
                    'moTa' => $item->noi_dung,
                    'mucDo' => $item->muc_do,
                    'maHdvBaoCao' => $item->ma_nhan_vien,
                    'hoTenKhachHang' => $item->ten_khach_hang,
                    'thoiGianBaoCao' => $item->thoi_gian
                ];
            }
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thành công',
            'data' => [
                'content' => $items,
                'totalPages' => $paginator->lastPage(),
                'totalElements' => $paginator->total(),
                'size' => $paginator->perPage(),
                'number' => $paginator->currentPage() - 1,
                'last' => !$paginator->hasMorePages()
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
