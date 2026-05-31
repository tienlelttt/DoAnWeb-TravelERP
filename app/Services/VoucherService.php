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
        $loaiUuDai = strtoupper($voucher->LoaiUuDai);
        $tienGiam = 0.0;

        if (in_array($loaiUuDai, ['PHAN_TRAM', 'PERCENTAGE', 'PERCENT'])) {
            // Giảm theo phần trăm
            $tienGiam = $tongTien * ($voucher->GiaTriGiam / 100);
        } else {
            // Giảm theo số tiền trực tiếp
            $tienGiam = (float) $voucher->GiaTriGiam;
        }

        // Khống chế theo trần giảm tối đa (nếu có cấu hình)
        if ($voucher->MucGiamToiDa > 0 && $tienGiam > $voucher->MucGiamToiDa) {
            $tienGiam = (float) $voucher->MucGiamToiDa;
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
    public function apDungVoucher(string $maVoucher, DonDatTour $donDatTour, float $tongTien): float
    {
        // 1. Kiểm tra đơn hàng phải ở trạng thái CHO_XAC_NHAN
        if ($donDatTour->TrangThai !== 'CHO_XAC_NHAN') {
            throw AppException::badRequest("Chỉ có thể áp dụng voucher cho đơn hàng ở trạng thái 'Chờ xác nhận'");
        }

        // 2. Tìm kiếm Voucher qua Repository (hỗ trợ cả tìm theo MaVoucher và MaCode)
        $voucher = $this->voucherRepository->timTheoMaHoacCodeCoKhoa($maVoucher);

        if (!$voucher) {
            throw AppException::badRequest("Voucher không hợp lệ hoặc đã hết hạn");
        }

        // 3. Kiểm tra tính hợp lệ của Voucher gốc
        if ($voucher->TrangThai !== 'SAN_SANG') {
            throw AppException::badRequest("Voucher không ở trạng thái sẵn sàng sử dụng");
        }

        $now = Carbon::now();
        if ($now->lt(Carbon::parse($voucher->NgayHieuLuc)) || $now->gt(Carbon::parse($voucher->NgayHetHan))) {
            throw AppException::badRequest("Voucher không hợp lệ hoặc đã hết hạn");
        }

        if ($voucher->SoLuotDaDung >= $voucher->SoLuotPhatHanh) {
            throw AppException::badRequest("Voucher đã hết lượt sử dụng");
        }

        // 4. Kiểm tra ví voucher của khách hàng qua Repository
        $khuyenMaiKh = $this->khuyenMaiKHRepository->timVoucherTrongViCoKhoa($donDatTour->MaKhachHang, $voucher->MaVoucher);

        if (!$khuyenMaiKh) {
            throw AppException::badRequest("Bạn không sở hữu voucher này");
        }

        if ($khuyenMaiKh->TrangThai !== 'CO_HIEU_LUC') {
            throw AppException::badRequest("Voucher đã được sử dụng hoặc không còn hiệu lực");
        }

        if ($khuyenMaiKh->NgayHetHan && $now->gt(Carbon::parse($khuyenMaiKh->NgayHetHan))) {
            throw AppException::badRequest("Voucher không hợp lệ hoặc đã hết hạn");
        }

        // 5. Kiểm tra ràng buộc: Mỗi đơn hàng chỉ áp dụng tối đa 1 voucher
        $uuDaiDaCo = DatTourUuDai::where('MaDatTour', $donDatTour->MaDatTour)->exists();
        if ($uuDaiDaCo) {
            throw AppException::badRequest("Đơn đặt tour này đã được áp dụng voucher từ trước");
        }

        // 6. Tính số tiền giảm
        $tienGiam = $this->tinhTienUuDai($voucher, $tongTien);

        // 7. Tạo bản ghi DATTOUR_UUDAI
        DatTourUuDai::create([
            'MaDatTour' => $donDatTour->MaDatTour,
            'MaVoucher' => $voucher->MaVoucher,
            'SoTienUuDai' => $tienGiam,
            'NgayApDung' => $now,
        ]);

        // 8. Cập nhật trạng thái ví voucher của khách hàng qua Repository (dùng composite key update an toàn)
        $this->khuyenMaiKHRepository->capNhatTrangThaiDaSuDung($donDatTour->MaKhachHang, $voucher->MaVoucher);

        // 9. Tăng SoLuotDaDung của Voucher gốc qua Repository
        $this->voucherRepository->tangSoLuotDaDung($voucher);

        return $tienGiam;
    }

    public function apVoucherTheoContract(string $maTaiKhoan, array $data): Voucher
    {
        return DB::transaction(function () use ($maTaiKhoan, $data) {
            $donDatTour = $this->timDonDatTourCuaKhach($maTaiKhoan, $data['maDatTour']);

            $tienGiam = $this->apDungVoucher($data['maVoucher'], $donDatTour, (float) $donDatTour->TongTien);
            $donDatTour->TongTien = (float) $donDatTour->TongTien - $tienGiam;
            $donDatTour->save();

            return Voucher::where('MaVoucher', $data['maVoucher'])
                ->orWhere('MaCode', $data['maVoucher'])
                ->firstOrFail();
        });
    }

    public function apDungVoucherChoDon(string $maTaiKhoan, array $data): DonDatTour
    {
        $donDatTour = DB::transaction(function () use ($maTaiKhoan, $data) {
            $don = $this->timDonDatTourCuaKhach($maTaiKhoan, $data['maDatTour']);
            $tienGiam = $this->apDungVoucher($data['maVoucher'], $don, (float) $don->TongTien);

            $don->TongTien = (float) $don->TongTien - $tienGiam;
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
        $donDatTour = DonDatTour::where('MaDatTour', $maDatTour)->first();
        if (!$donDatTour) {
            throw AppException::notFound("Không tìm thấy đơn đặt tour: " . $maDatTour);
        }

        $khachHang = HoChieuSo::where('MaTaiKhoan', $maTaiKhoan)->first();
        if (!$khachHang || $donDatTour->MaKhachHang !== $khachHang->MaKhachHang) {
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
    public function layDanhSachVoucherCuaKhach(string $maTaiKhoan, int $perPage = 10)
    {
        $khachHang = HoChieuSo::where('MaTaiKhoan', $maTaiKhoan)->first();
        if (!$khachHang) {
            throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
        }

        return $this->khuyenMaiKHRepository->danhSachVoucherCuaKhach($khachHang->MaKhachHang, $perPage);
    }

    public function danhSachCoTheDoi(int $perPage = 20)
    {
        $now = Carbon::now();

        return Voucher::where('TrangThai', 'SAN_SANG')
            ->where('NgayHieuLuc', '<=', $now)
            ->where('NgayHetHan', '>=', $now)
            ->orderBy('NgayHetHan', 'asc')
            ->paginate($perPage);
    }

    public function doiDiem(string $maTaiKhoan, string $maVoucher): KhuyenMaiKh
    {
        return DB::transaction(function () use ($maTaiKhoan, $maVoucher) {
            $khachHang = HoChieuSo::where('MaTaiKhoan', $maTaiKhoan)->lockForUpdate()->first();
            if (!$khachHang) {
                throw AppException::notFound("Không tìm thấy hồ sơ khách hàng");
            }

            $voucher = Voucher::where('MaVoucher', $maVoucher)->lockForUpdate()->first();
            if (!$voucher) {
                throw AppException::notFound("Không tìm thấy voucher: " . $maVoucher);
            }

            if ($voucher->TrangThai !== 'SAN_SANG') {
                throw AppException::badRequest("Voucher không sẵn sàng để đổi điểm");
            }

            $now = Carbon::now();
            if ($voucher->NgayHieuLuc && $now->lt(Carbon::parse($voucher->NgayHieuLuc))) {
                throw AppException::badRequest("Voucher chưa đến thời gian hiệu lực");
            }

            if ($voucher->NgayHetHan && $now->gt(Carbon::parse($voucher->NgayHetHan))) {
                throw AppException::badRequest("Voucher đã hết hạn");
            }

            if ((int) $voucher->SoLuotDaDung >= (int) $voucher->SoLuotPhatHanh) {
                throw AppException::badRequest("Voucher đã hết lượt sử dụng");
            }

            $daCoTrongVi = KhuyenMaiKh::where('MaKhachHang', $khachHang->MaKhachHang)
                ->where('MaVoucher', $voucher->MaVoucher)
                ->where('TrangThai', 'CO_HIEU_LUC')
                ->exists();

            if ($daCoTrongVi) {
                throw AppException::badRequest("Khách hàng đã sở hữu voucher này");
            }

            $diemCanDoi = $this->tinhDiemCanDoi($voucher);
            if ((int) $khachHang->DiemXanh < $diemCanDoi) {
                throw AppException::badRequest("Không đủ điểm xanh. Cần: {$diemCanDoi}, Hiện có: {$khachHang->DiemXanh}");
            }

            $khachHang->DiemXanh = (int) $khachHang->DiemXanh - $diemCanDoi;
            $khachHang->save();

            $khuyenMaiKh = KhuyenMaiKh::create([
                'MaKhachHang' => $khachHang->MaKhachHang,
                'MaVoucher' => $voucher->MaVoucher,
                'NgayHetHan' => $voucher->NgayHetHan,
                'NgayNhan' => $now,
                'TrangThai' => 'CO_HIEU_LUC',
            ]);

            NhatKyDoiDiem::create([
                'MaNhatKyDoiDiem' => 'NKDD_' . strtoupper(substr(Str::uuid()->toString(), 0, 8)),
                'MaKhachHang' => $khachHang->MaKhachHang,
                'MaVoucher' => $voucher->MaVoucher,
                'DiemQuyDoi' => $diemCanDoi,
                'NgayQuyDoi' => $now,
            ]);

            return $khuyenMaiKh->load(['voucher', 'khachHang.taiKhoan']);
        });
    }

    public function tinhDiemCanDoi(Voucher $voucher): int
    {
        if (strtoupper((string) $voucher->LoaiUuDai) === 'SO_TIEN') {
            return (int) ceil((float) $voucher->GiaTriGiam);
        }

        if ($voucher->MucGiamToiDa !== null) {
            return (int) ceil(((float) $voucher->MucGiamToiDa * (float) $voucher->GiaTriGiam * 2) / 100);
        }

        return (int) ceil((float) $voucher->GiaTriGiam * 50);
    }

    public function danhSachAdmin($perPage = 10)
    {
        return Voucher::orderBy('NgayHieuLuc', 'desc')->paginate($perPage);
    }

    public function taoVoucher(array $data)
    {
        $maTuDong = app(MaTuDongService::class);
        $voucher = new Voucher();
        $voucher->MaVoucher = $maTuDong->taoMaVoucher();
        $voucher->MaCode = $data['maCode'];
        $voucher->LoaiUuDai = $data['loaiUuDai'];
        $voucher->GiaTriGiam = $data['giaTriGiam'];
        $voucher->MucGiamToiDa = $data['mucGiamToiDa'] ?? null;
        $voucher->DieuKienApDung = $data['dieuKienApDung'] ?? null;
        $voucher->SoLuotPhatHanh = $data['soLuotPhatHanh'];
        $voucher->SoLuotDaDung = 0;
        $voucher->NgayHieuLuc = $data['ngayHieuLuc'];
        $voucher->NgayHetHan = $data['ngayHetHan'];
        $voucher->TrangThai = 'SAN_SANG';
        
        $voucher->save();
        return $voucher;
    }

    public function capNhatVoucher($maVoucher, array $data)
    {
        $voucher = Voucher::find($maVoucher);
        if (!$voucher) throw AppException::notFound("Không tìm thấy voucher");

        $voucher->MaCode = $data['maCode'];
        $voucher->LoaiUuDai = $data['loaiUuDai'];
        $voucher->GiaTriGiam = $data['giaTriGiam'];
        $voucher->MucGiamToiDa = $data['mucGiamToiDa'] ?? null;
        $voucher->DieuKienApDung = $data['dieuKienApDung'] ?? null;
        $voucher->SoLuotPhatHanh = $data['soLuotPhatHanh'];
        $voucher->NgayHieuLuc = $data['ngayHieuLuc'];
        $voucher->NgayHetHan = $data['ngayHetHan'];
        
        $voucher->save();
        return $voucher;
    }

    public function voHieuHoaVoucher($maVoucher)
    {
        $voucher = Voucher::find($maVoucher);
        if (!$voucher) throw AppException::notFound("Không tìm thấy voucher");
        $voucher->TrangThai = 'VO_HIEU_HOA';
        $voucher->save();
        return $voucher;
    }

    public function phatHanhVoucher($maVoucher, $maKhachHang)
    {
        $voucher = Voucher::find($maVoucher);
        if (!$voucher) throw AppException::notFound("Không tìm thấy voucher");

        if ($voucher->TrangThai !== 'SAN_SANG') {
            throw AppException::badRequest("Voucher không sẵn sàng để phát hành");
        }

        $daPhatHanh = \App\Models\KhuyenMaiKh::where('MaVoucher', $maVoucher)->count();
        if ($daPhatHanh >= $voucher->SoLuotPhatHanh) {
            throw AppException::badRequest("Đã đạt giới hạn phát hành của voucher này");
        }

        $tonTai = \App\Models\KhuyenMaiKh::where('MaVoucher', $maVoucher)
            ->where('MaKhachHang', $maKhachHang)->first();
        
        if ($tonTai) {
            throw AppException::badRequest("Khách hàng này đã nhận voucher này rồi");
        }

        $km = new \App\Models\KhuyenMaiKh();
        $km->MaKhachHang = $maKhachHang;
        $km->MaVoucher = $maVoucher;
        $km->TrangThai = 'CO_HIEU_LUC';
        $km->NgayNhan = Carbon::now();
        $km->NgayHetHan = $voucher->NgayHetHan;
        $km->save();

        return $km;
    }
}

