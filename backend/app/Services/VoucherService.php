<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\DatTourUuDai;
use App\Models\DonDatTour;
use App\Models\HoChieuSo;
use App\Models\KhuyenMaiKh;
use App\Models\NhatKyDoiDiem;
use App\Exceptions\AppException;
use App\Repositories\VoucherRepository;
use App\Repositories\KhuyenMaiKHRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VoucherService
{
    protected $voucherRepository;
    protected $khuyenMaiKHRepository;

    public function __construct(VoucherRepository $voucherRepository, KhuyenMaiKHRepository $khuyenMaiKHRepository)
    {
        $this->voucherRepository = $voucherRepository;
        $this->khuyenMaiKHRepository = $khuyenMaiKHRepository;
    }

    /**
     * Tính toán số tiền được ưu đãi giảm trừ từ Voucher (tương ứng FN_TINH_TIEN_UU_DAI)
     *
     * @param Voucher $voucher
     * @param float $tongTien
     * @return float
     */
    public function tinhTienUuDai(Voucher $voucher, float $tongTien): float
    {
        $loaiUuDai = strtoupper($voucher->loai_uu_dai);
        $tienGiam = 0.0;

        if (in_array($loaiUuDai, ['PHAN_TRAM', 'PERCENTAGE', 'PERCENT'])) {
            // Giảm theo phần trăm
            $tienGiam = $tongTien * ($voucher->gia_tri_giam / 100);
        } else {
            // Giảm theo số tiền trực tiếp
            $tienGiam = (float) $voucher->gia_tri_giam;
        }

        // Khống chế theo trần giảm tối đa (nếu có cấu hình)
        if ($voucher->muc_giam_toi_da > 0 && $tienGiam > $voucher->muc_giam_toi_da) {
            $tienGiam = (float) $voucher->muc_giam_toi_da;
        }

        // Đảm bảo số tiền giảm không âm và không vượt quá tổng tiền gốc
        return max(0.0, min($tienGiam, $tongTien));
    }

    /**
     * Áp dụng voucher cho một đơn đặt tour hiện có
     *
     * @param string $maVoucher
     * @param DonDatTour $donDatTour
     * @param float $tongTien
     * @return float
     */
    // UC52 | Nhân viên kinh doanh | Áp dụng voucher.
    public function apDungVoucher(string $maVoucher, DonDatTour $donDatTour, float $tongTien): float
    {
        // 1. Kiểm tra đơn hàng phải ở trạng thái CHO_XAC_NHAN
        if ($donDatTour->trang_thai !== 'CHO_XAC_NHAN') {
            throw AppException::badRequest("Chỉ có thể áp dụng voucher cho đơn hàng ở trạng thái 'Chờ xác nhận'");
        }

        // 2. Tìm kiếm Voucher qua Repository (hỗ trợ cả tìm theo ma_voucher và ma_code)
        $voucher = $this->voucherRepository->timTheoMaHoacCodeCoKhoa($maVoucher);

        if (!$voucher) {
            throw AppException::badRequest("Voucher không hợp lệ hoặc đã hết hạn");
        }

        // 3. Kiểm tra tính hợp lệ của Voucher gốc
        if ($voucher->trang_thai !== 'SAN_SANG') {
            throw AppException::badRequest("Voucher không ở trạng thái sẵn sàng sử dụng");
        }

        $now = Carbon::now();
        if ($now->lt(Carbon::parse($voucher->ngay_hieu_luc)) || $now->gt(Carbon::parse($voucher->ngay_het_han))) {
            throw AppException::badRequest("Voucher không hợp lệ hoặc đã hết hạn");
        }

        if ($voucher->so_luot_da_dung >= $voucher->so_luot_phat_hanh) {
            throw AppException::badRequest("Voucher đã hết lượt sử dụng");
        }

        // 4. Kiểm tra ví voucher của khách hàng qua Repository
        $khuyenMaiKh = $this->khuyenMaiKHRepository->timVoucherTrongViCoKhoa($donDatTour->ma_khach_hang, $voucher->ma_voucher);

        if (!$khuyenMaiKh) {
            throw AppException::badRequest("Bạn không sở hữu voucher này");
        }

        if ($khuyenMaiKh->trang_thai !== 'CO_HIEU_LUC') {
            throw AppException::badRequest("Voucher đã được sử dụng hoặc không còn hiệu lực");
        }

        if ($khuyenMaiKh->ngay_het_han && $now->gt(Carbon::parse($khuyenMaiKh->ngay_het_han))) {
            throw AppException::badRequest("Voucher không hợp lệ hoặc đã hết hạn");
        }

        // 5. Kiểm tra ràng buộc: Mỗi đơn hàng chỉ áp dụng tối đa 1 voucher
        $uuDaiDaCo = DatTourUuDai::where('ma_dat_tour', $donDatTour->ma_dat_tour)->exists();
        if ($uuDaiDaCo) {
            throw AppException::badRequest("Đơn đặt tour này đã được áp dụng voucher từ trước");
        }

        // 6. Tính số tiền giảm
        $tienGiam = $this->tinhTienUuDai($voucher, $tongTien);

        // 7. Tạo bản ghi dat_tour_uu_dais
        DatTourUuDai::create([
            'ma_dat_tour' => $donDatTour->ma_dat_tour,
            'ma_voucher' => $voucher->ma_voucher,
            'so_tien_uu_dai' => $tienGiam,
            'ngay_ap_dung' => $now,
        ]);

        // 8. Cập nhật trạng thái ví voucher của khách hàng qua Repository (dùng composite key update an toàn)
        $this->khuyenMaiKHRepository->capNhatTrangThaiDaSuDung($donDatTour->ma_khach_hang, $voucher->ma_voucher);

        // 9. Tăng so_luot_da_dung của Voucher gốc qua Repository
        $this->voucherRepository->tangSoLuotDaDung($voucher);

        return $tienGiam;
    }

    public function apVoucherTheoContract(string $maTaiKhoan, array $data): Voucher
    {
        return DB::transaction(function () use ($maTaiKhoan, $data) {
            $donDatTour = $this->timDonDatTourCuaKhach($maTaiKhoan, $data['maDatTour']);

            $tienGiam = $this->apDungVoucher($data['maVoucher'], $donDatTour, (float) $donDatTour->tong_tien);
            $donDatTour->tong_tien = (float) $donDatTour->tong_tien - $tienGiam;
            $donDatTour->save();

            return Voucher::where('ma_voucher', $data['maVoucher'])
                ->orWhere('ma_code', $data['maVoucher'])
                ->firstOrFail();
        });
    }

    // UC52 | Nhân viên kinh doanh | Áp dụng voucher (apDungVoucherChoDon).
    public function apDungVoucherChoDon(string $maTaiKhoan, array $data): DonDatTour
    {
        $donDatTour = DB::transaction(function () use ($maTaiKhoan, $data) {
            $don = $this->timDonDatTourCuaKhach($maTaiKhoan, $data['maDatTour']);
            $tienGiam = $this->apDungVoucher($data['maVoucher'], $don, (float) $don->tong_tien);

            $don->tong_tien = (float) $don->tong_tien - $tienGiam;
            $don->save();

            return $don;
        });

        return $donDatTour->load([
            'tourThucTe.tourMau',
            'khachHang.taiKhoan',
            'chiTietDatTours.khachHang.taiKhoan',
            'chiTietDatTours.nguoiDongHanh',
            'chiTietDichVus.dichVuThem',
            'datTourUuDai.voucher',
        ]);
    }

    private function timDonDatTourCuaKhach(string $maTaiKhoan, string $maDatTour): DonDatTour
    {
        $donDatTour = DonDatTour::where('ma_dat_tour', $maDatTour)->first();
        if (!$donDatTour) {
            throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
        }

        $khachHang = HoChieuSo::where('ma_tai_khoan', $maTaiKhoan)->first();
        if (!$khachHang || $donDatTour->ma_khach_hang !== $khachHang->ma_khach_hang) {
            throw AppException::forbidden("Bạn không có quyền áp voucher cho đơn này");
        }

        return $donDatTour;
    }

    /**
     * Lấy danh sách voucher trong ví của khách hàng
     *
     * @param string $maTaiKhoan
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    // UC52 | Nhân viên kinh doanh | Lấy danh sách voucher.
    public function layDanhSachVoucherCuaKhach(string $maTaiKhoan, int $perPage = 10)
    {
        $khachHang = HoChieuSo::where('ma_tai_khoan', $maTaiKhoan)->first();
        if (!$khachHang) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }

        return $this->khuyenMaiKHRepository->danhSachVoucherCuaKhach($khachHang->ma_khach_hang, $perPage);
    }

    // UC52 | Nhân viên kinh doanh | Lấy danh sách voucher (danhSachCoTheDoi).
    public function danhSachCoTheDoi(int $perPage = 20)
    {
        $now = Carbon::now();

        return Voucher::where('trang_thai', 'SAN_SANG')
            ->where('ngay_hieu_luc', '<=', $now)
            ->where('ngay_het_han', '>=', $now)
            ->orderBy('ngay_het_han', 'asc')
            ->paginate($perPage);
    }

    // UC52 | Nhân viên kinh doanh | Quy đổi voucher.
    public function doiDiem(string $maTaiKhoan, string $maVoucher): KhuyenMaiKh
    {
        return DB::transaction(function () use ($maTaiKhoan, $maVoucher) {
            $khachHang = HoChieuSo::where('ma_tai_khoan', $maTaiKhoan)->lockForUpdate()->first();
            if (!$khachHang) {
                throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
            }

            $voucher = Voucher::where('ma_voucher', $maVoucher)->lockForUpdate()->first();
            if (!$voucher) {
                throw AppException::notFound("Không tìm thấy voucher: " . $maVoucher);
            }

            if ($voucher->trang_thai !== 'SAN_SANG') {
                throw AppException::badRequest("Voucher không sẵn sàng để đổi điểm");
            }

            $now = Carbon::now();
            if ($voucher->ngay_hieu_luc && $now->lt(Carbon::parse($voucher->ngay_hieu_luc))) {
                throw AppException::badRequest("Voucher chưa đến thời gian hiệu lực");
            }

            if ($voucher->ngay_het_han && $now->gt(Carbon::parse($voucher->ngay_het_han))) {
                throw AppException::badRequest("Voucher đã hết hạn");
            }

            if ((int) $voucher->so_luot_da_dung >= (int) $voucher->so_luot_phat_hanh) {
                throw AppException::badRequest("Voucher đã hết lượt sử dụng");
            }

            $daCoTrongVi = KhuyenMaiKh::where('ma_khach_hang', $khachHang->ma_khach_hang)
                ->where('ma_voucher', $voucher->ma_voucher)
                ->where('trang_thai', 'CO_HIEU_LUC')
                ->exists();

            if ($daCoTrongVi) {
                throw AppException::badRequest("Khách hàng đã sở hữu voucher này");
            }

            $diemCanDoi = $this->tinhDiemCanDoi($voucher);
            if ((int) $khachHang->diem_xanh < $diemCanDoi) {
                throw AppException::badRequest("Không đủ điểm xanh. Cần: {$diemCanDoi}, Hiện có: {$khachHang->diem_xanh}");
            }

            $khachHang->diem_xanh = (int) $khachHang->diem_xanh - $diemCanDoi;
            $khachHang->save();

            $khuyenMaiKh = KhuyenMaiKh::create([
                'ma_khach_hang' => $khachHang->ma_khach_hang,
                'ma_voucher' => $voucher->ma_voucher,
                'ngay_het_han' => $voucher->ngay_het_han,
                'ngay_nhan' => $now,
                'trang_thai' => 'CO_HIEU_LUC',
            ]);

            NhatKyDoiDiem::create([
                'ma_nhat_ky_doi_diem' => 'NKDD_' . strtoupper(substr(Str::uuid()->toString(), 0, 8)),
                'ma_khach_hang' => $khachHang->ma_khach_hang,
                'ma_voucher' => $voucher->ma_voucher,
                'diem_quy_doi' => $diemCanDoi,
                'ngay_quy_doi' => $now,
            ]);

            return $khuyenMaiKh->load(['voucher', 'khachHang.taiKhoan']);
        });
    }

    public function tinhDiemCanDoi(Voucher $voucher): int
    {
        if (strtoupper((string) $voucher->loai_uu_dai) === 'SO_TIEN') {
            return (int) ceil((float) $voucher->gia_tri_giam);
        }

        if ($voucher->muc_giam_toi_da !== null) {
            return (int) ceil(((float) $voucher->muc_giam_toi_da * (float) $voucher->gia_tri_giam * 2) / 100);
        }

        return (int) ceil((float) $voucher->gia_tri_giam * 50);
    }

    // UC52 | Nhân viên kinh doanh | Lấy danh sách voucher (danhSachAdmin).
    public function danhSachAdmin($perPage = 10)
    {
        return Voucher::orderBy('ngay_hieu_luc', 'desc')->paginate($perPage);
    }

    public function taoVoucher(array $data)
    {
        $maTuDong = app(MaTuDongService::class);
        $voucher = new Voucher();
        $voucher->ma_voucher = $maTuDong->taoMaVoucher();
        $voucher->ma_code = $data['maCode'];
        $voucher->loai_uu_dai = $data['loaiUuDai'];
        $voucher->gia_tri_giam = $data['giaTriGiam'];
        $voucher->muc_giam_toi_da = $data['mucGiamToiDa'] ?? null;
        $voucher->dieu_kien_ap_dung = $data['dieuKienApDung'] ?? null;
        $voucher->so_luot_phat_hanh = $data['soLuotPhatHanh'];
        $voucher->so_luot_da_dung = 0;
        $voucher->ngay_hieu_luc = $data['ngayHieuLuc'];
        $voucher->ngay_het_han = $data['ngayHetHan'];
        $voucher->trang_thai = 'SAN_SANG';
        
        $voucher->save();
        return $voucher;
    }

    // UC52 | Nhân viên kinh doanh | Cập nhật voucher.
    public function capNhatVoucher($maVoucher, array $data)
    {
        $voucher = Voucher::find($maVoucher);
        if (!$voucher) throw AppException::notFound("Không tìm thấy voucher");

        $voucher->ma_code = $data['maCode'];
        $voucher->loai_uu_dai = $data['loaiUuDai'];
        $voucher->gia_tri_giam = $data['giaTriGiam'];
        $voucher->muc_giam_toi_da = $data['mucGiamToiDa'] ?? null;
        $voucher->dieu_kien_ap_dung = $data['dieuKienApDung'] ?? null;
        $voucher->so_luot_phat_hanh = $data['soLuotPhatHanh'];
        $voucher->ngay_hieu_luc = $data['ngayHieuLuc'];
        $voucher->ngay_het_han = $data['ngayHetHan'];
        
        $voucher->save();
        return $voucher;
    }

    public function voHieuHoaVoucher($maVoucher)
    {
        $voucher = Voucher::find($maVoucher);
        if (!$voucher) throw AppException::notFound("Không tìm thấy voucher");
        $voucher->trang_thai = 'VO_HIEU_HOA';
        $voucher->save();
        return $voucher;
    }

    public function phatHanhVoucher($maVoucher, $maKhachHang)
    {
        $voucher = Voucher::find($maVoucher);
        if (!$voucher) throw AppException::notFound("Không tìm thấy voucher");

        if ($voucher->trang_thai !== 'SAN_SANG') {
            throw AppException::badRequest("Voucher không sẵn sàng để phát hành");
        }

        $daPhatHanh = \App\Models\KhuyenMaiKh::where('ma_voucher', $maVoucher)->count();
        if ($daPhatHanh >= $voucher->so_luot_phat_hanh) {
            throw AppException::badRequest("Đã đạt giới hạn phát hành của voucher này");
        }

        $tonTai = \App\Models\KhuyenMaiKh::where('ma_voucher', $maVoucher)
            ->where('ma_khach_hang', $maKhachHang)->first();
        
        if ($tonTai) {
            throw AppException::badRequest("Khách hàng này đã nhận voucher này rồi");
        }

        $km = new \App\Models\KhuyenMaiKh();
        $km->ma_khach_hang = $maKhachHang;
        $km->ma_voucher = $maVoucher;
        $km->trang_thai = 'CO_HIEU_LUC';
        $km->ngay_nhan = Carbon::now();
        $km->ngay_het_han = $voucher->ngay_het_han;
        $km->save();

        return $km;
    }
}

