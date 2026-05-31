<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('CHIPHITHUCTE', function (Blueprint $table) {
            $table->string('MaChiPhiThucTe', 50)->primary();
            $table->string('MaTourThucTe', 50);
            $table->string('MaNhanVien', 50);
            $table->string('DanhMuc', 200);
            $table->decimal('ThanhTien', 18, 2);
            $table->string('HoaDonAnh', 1000)->nullable();
            $table->string('TrangThaiDuyet', 20);
            $table->dateTime('NgayKhai');
            $table->timestamps();
        });

        Schema::create('CHITIETDATTOUR', function (Blueprint $table) {
            $table->string('MaChiTietDat', 50)->primary();
            $table->string('MaDatTour', 50);
            $table->string('MaKhachHang', 50)->nullable();
            $table->string('MaNguoiDongHanh', 50)->nullable();
            $table->string('LoaiKhach', 30);
            $table->decimal('GiaTaiThoiDiemDat', 18, 2);
            $table->timestamps();
        });

        Schema::create('CHITIETDICHVU', function (Blueprint $table) {
            $table->string('MaChiTietDichVu', 50)->primary();
            $table->string('MaDatTour', 50);
            $table->string('MaDichVuThem', 50);
            $table->bigInteger('SoLuong');
            $table->decimal('DonGia', 18, 2);
            $table->decimal('ThanhTien', 18, 2);
            $table->timestamps();
        });

        Schema::create('DANHGIAKH', function (Blueprint $table) {
            $table->string('MaDanhGiaKhachHang', 50)->primary();
            $table->string('MaTourThucTe', 50);
            $table->string('MaKhachHang', 50);
            $table->integer('SoSao');
            $table->string('NhanXet', 255)->nullable();
            $table->dateTime('NgayDanhGia');
            $table->timestamps();
        });

        Schema::create('DATTOUR_UUDAI', function (Blueprint $table) {
            $table->string('MaDatTour', 50)->nullable();
            $table->string('MaVoucher', 50)->nullable();
            $table->decimal('SoTienUuDai', 18, 2);
            $table->dateTime('NgayApDung');
            $table->timestamps();
        });

        Schema::create('DICHVUTHEM', function (Blueprint $table) {
            $table->string('MaDichVuThem', 50)->primary();
            $table->string('Ten', 200);
            $table->string('DonViTinh', 100)->nullable();
            $table->decimal('DonGia', 18, 2);
            $table->timestamps();
        });

        Schema::create('DICHVU_TOURTHUCTE', function (Blueprint $table) {
            $table->string('MaTourThucTe', 50)->nullable();
            $table->string('MaDichVuThem', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('DIEMDANH', function (Blueprint $table) {
            $table->string('MaDiemDanh', 50)->primary();
            $table->string('MaTourThucTe', 50);
            $table->string('MaKhachHang', 50)->nullable();
            $table->string('MaNguoiDongHanh', 50)->nullable();
            $table->string('LoaiKhach', 30);
            $table->string('MaNhanVien', 50);
            $table->dateTime('ThoiGian');
            $table->string('DiaDiem', 500)->nullable();
            $table->string('TrangThai', 30);
            $table->timestamps();
        });

        Schema::create('DONDATTOUR', function (Blueprint $table) {
            $table->string('MaDatTour', 50)->primary();
            $table->string('MaTourThucTe', 50);
            $table->string('MaKhachHang', 50);
            $table->dateTime('NgayDat');
            $table->decimal('TongTien', 18, 2);
            $table->string('TrangThai', 30);
            $table->dateTime('ThoiGianHetHan')->nullable();
            $table->string('GhiChu', 2000)->nullable();
            $table->string('HanhDongXanh', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('DSNGUOIDONGHANH', function (Blueprint $table) {
            $table->string('MaNguoiDongHanh', 50)->primary();
            $table->string('MaDatTour', 50);
            $table->string('HoTen', 200);
            $table->string('CCCD', 20)->nullable();
            $table->string('SoDienThoai', 20)->nullable();
            $table->dateTime('NgaySinh')->nullable();
            $table->string('GioiTinh', 20)->nullable();
            $table->string('GhiChu', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('GIAODICH', function (Blueprint $table) {
            $table->string('MaGiaoDich', 50)->primary();
            $table->string('MaDatTour', 50);
            $table->string('LoaiGiaoDich', 50);
            $table->string('PhuongThuc', 50);
            $table->decimal('SoTien', 18, 2);
            $table->string('MaGDNH', 200)->nullable();
            $table->string('TrangThai', 30);
            $table->dateTime('NgayThanhToan')->nullable();
            $table->timestamps();
        });

        Schema::create('HANHDONG', function (Blueprint $table) {
            $table->string('MaGhiNhanHanhDong', 50)->primary();
            $table->string('MaTourThucTe', 50);
            $table->string('MaKhachHang', 50);
            $table->string('MaHanhDongXanh', 50);
            $table->string('MaNhanVienXacMinh', 50);
            $table->dateTime('ThoiGian');
            $table->string('MinhChung', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('HANHDONGXANH', function (Blueprint $table) {
            $table->string('MaHanhDongXanh', 50)->primary();
            $table->string('TenHanhDong', 200);
            $table->bigInteger('DiemCong');
            $table->timestamps();
        });

        Schema::create('HDX_TOURTHUCTE', function (Blueprint $table) {
            $table->string('MaTourThucTe', 50)->nullable();
            $table->string('MaHanhDongXanh', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('HOCHIEUSO', function (Blueprint $table) {
            $table->string('MaKhachHang', 50)->primary();
            $table->string('MaTaiKhoan', 50);
            $table->string('GhiChuYTe', 255)->nullable();
            $table->string('DiUng', 1000)->nullable();
            $table->string('HangThanhVien', 20);
            $table->bigInteger('DiemXanh');
            $table->timestamps();
        });

        Schema::create('KHUYENMAI_KH', function (Blueprint $table) {
            $table->string('MaKhachHang', 50)->nullable();
            $table->string('MaVoucher', 50)->nullable();
            $table->dateTime('NgayHetHan')->nullable();
            $table->dateTime('NgayNhan');
            $table->string('TrangThai', 20);
            $table->timestamps();
        });

        Schema::create('LICHSUTOUR', function (Blueprint $table) {
            $table->string('MaLichSuTour', 50)->primary();
            $table->string('MaKhachHang', 50);
            $table->string('MaTourThucTe', 50);
            $table->string('MaChiTietDat', 50)->nullable();
            $table->dateTime('NgayThamGia')->nullable();
            $table->timestamps();
        });

        Schema::create('LICHTRINHTOUR', function (Blueprint $table) {
            $table->string('MaLichTrinhTour', 50)->primary();
            $table->string('MaTourMau', 50);
            $table->integer('NgayThu');
            $table->string('HoatDong', 1000)->nullable();
            $table->string('MoTa', 255)->nullable();
            $table->string('ThucDon', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('NANGLUCNHANVIEN', function (Blueprint $table) {
            $table->string('MaNangLucNhanVien', 50)->primary();
            $table->string('MaNhanVien', 50);
            $table->string('NgonNgu', 200)->nullable();
            $table->string('ChungChi', 500)->nullable();
            $table->string('ChuyenMon', 500)->nullable();
            $table->decimal('DanhGia', 18, 2)->nullable();
            $table->integer('SoDanhGia')->nullable();
            $table->timestamps();
        });

        Schema::create('NHANVIEN', function (Blueprint $table) {
            $table->string('MaNhanVien', 50)->primary();
            $table->string('MaTaiKhoan', 50);
            $table->string('LoaiNhanVien', 50)->nullable();
            $table->dateTime('NgayVaoLam')->nullable();
            $table->string('TrangThaiLamViec', 20);
            $table->timestamps();
        });

        Schema::create('NHATKYDOIDIEM', function (Blueprint $table) {
            $table->string('MaNhatKyDoiDiem', 50)->primary();
            $table->string('MaKhachHang', 50);
            $table->string('MaVoucher', 50);
            $table->bigInteger('DiemQuyDoi');
            $table->dateTime('NgayQuyDoi');
            $table->timestamps();
        });

        Schema::create('NHATKYHETHONG', function (Blueprint $table) {
            $table->string('MaNhatKyHeThong', 50)->primary();
            $table->string('MaTaiKhoan', 50)->nullable();
            $table->string('HanhDong', 100);
            $table->string('DoiTuong', 100)->nullable();
            $table->string('MaDoiTuong', 50)->nullable();
            $table->string('GhiChu', 255)->nullable();
            $table->dateTime('ThoiGian');
            $table->timestamps();
        });

        Schema::create('NHATKYSUCO', function (Blueprint $table) {
            $table->string('MaNhatKySuCo', 50)->primary();
            $table->string('MaTourThucTe', 50);
            $table->string('MaNhanVienBaoCao', 50);
            $table->string('MaKhachHang', 50)->nullable();
            $table->string('MaNguoiDongHanh', 50)->nullable();
            $table->string('MoTa', 255);
            $table->string('GiaiPhap', 255)->nullable();
            $table->string('MucDo', 20);
            $table->string('LoaiSuCo', 30);
            $table->dateTime('ThoiGianBaoCao');
            $table->timestamps();
        });

        Schema::create('PHANCONGTOUR', function (Blueprint $table) {
            $table->string('MaPhanCongTour', 50)->primary();
            $table->string('MaTourThucTe', 50);
            $table->string('MaNhanVien', 50);
            $table->dateTime('NgayPhanCong');
            $table->dateTime('NgayPhanHoi')->nullable();
            $table->string('TrangThaiChapNhan', 20)->default('CHO_PHAN_HOI');
            $table->timestamps();
        });

        Schema::create('QUYETTOAN', function (Blueprint $table) {
            $table->string('MaQuyetToan', 50)->primary();
            $table->string('MaTourThucTe', 50);
            $table->decimal('TongDoanhThu', 18, 2);
            $table->decimal('TongChiPhi', 18, 2);
            $table->decimal('GiaCamKet', 18, 2)->nullable();
            $table->decimal('LoiNhuan', 18, 2);
            $table->string('MaNhanVien', 50);
            $table->dateTime('NgayQuyetToan');
            $table->string('TrangThai', 20);
            $table->string('GhiChu', 255)->nullable();
            $table->string('HoaDonAnh', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('TAIKHOAN', function (Blueprint $table) {
            $table->string('MaTaiKhoan', 50)->primary();
            $table->string('TenDangNhap', 100)->unique();
            $table->string('MatKhau', 255);
            $table->string('HoTen', 200);
            $table->string('CCCD', 20)->nullable()->unique();
            $table->dateTime('NgaySinh')->nullable();
            $table->string('Email', 200)->nullable()->unique();
            $table->string('SoDienThoai', 20)->nullable();
            $table->string('VaiTro', 50);
            $table->string('TrangThai', 20);
            $table->timestamps();
        });

        Schema::create('TOURMAU', function (Blueprint $table) {
            $table->string('MaTourMau', 50)->primary();
            $table->string('TieuDe', 500);
            $table->string('MoTa', 255)->nullable();
            $table->integer('ThoiLuong');
            $table->decimal('GiaSan', 18, 2);
            $table->decimal('DanhGia', 18, 2)->nullable();
            $table->integer('SoDanhGia')->nullable();
            $table->timestamps();
        });

        Schema::create('TOURTHUCTE', function (Blueprint $table) {
            $table->string('MaTourThucTe', 50)->primary();
            $table->string('MaTourMau', 50);
            $table->dateTime('NgayKhoiHanh');
            $table->decimal('GiaHienHanh', 18, 2);
            $table->integer('SoKhachToiDa');
            $table->integer('SoKhachToiThieu');
            $table->integer('ChoConLai');
            $table->string('TrangThai', 20);
            $table->timestamps();
        });

        Schema::create('VAITRO', function (Blueprint $table) {
            $table->string('MaVaiTro', 50)->primary();
            $table->string('TenHienThi', 100);
            $table->timestamps();
        });

        Schema::create('VOUCHER', function (Blueprint $table) {
            $table->string('MaVoucher', 50)->primary();
            $table->string('MaCode', 50)->unique();
            $table->string('LoaiUuDai', 20);
            $table->decimal('GiaTriGiam', 18, 2);
            $table->decimal('MucGiamToiDa', 18, 2)->nullable();
            $table->string('DieuKienApDung', 2000)->nullable();
            $table->integer('SoLuotPhatHanh');
            $table->integer('SoLuotDaDung');
            $table->dateTime('NgayHieuLuc');
            $table->dateTime('NgayHetHan');
            $table->string('TrangThai', 20);
            $table->timestamps();
        });

        Schema::create('YEUCAUHOTRO', function (Blueprint $table) {
            $table->string('MaYeuCauHoTro', 50)->primary();
            $table->string('MaDatTour', 50)->nullable();
            $table->string('MaKhachHang', 50);
            $table->string('LoaiYeuCau', 100);
            $table->string('NoiDung', 255);
            $table->string('TrangThai', 20);
            $table->string('MaNhanVienXuLy', 50)->nullable();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('CHIPHITHUCTE');
        Schema::dropIfExists('CHITIETDATTOUR');
        Schema::dropIfExists('CHITIETDICHVU');
        Schema::dropIfExists('DANHGIAKH');
        Schema::dropIfExists('DATTOUR_UUDAI');
        Schema::dropIfExists('DICHVUTHEM');
        Schema::dropIfExists('DICHVU_TOURTHUCTE');
        Schema::dropIfExists('DIEMDANH');
        Schema::dropIfExists('DONDATTOUR');
        Schema::dropIfExists('DSNGUOIDONGHANH');
        Schema::dropIfExists('GIAODICH');
        Schema::dropIfExists('HANHDONG');
        Schema::dropIfExists('HANHDONGXANH');
        Schema::dropIfExists('HDX_TOURTHUCTE');
        Schema::dropIfExists('HOCHIEUSO');
        Schema::dropIfExists('KHUYENMAI_KH');
        Schema::dropIfExists('LICHSUTOUR');
        Schema::dropIfExists('LICHTRINHTOUR');
        Schema::dropIfExists('NANGLUCNHANVIEN');
        Schema::dropIfExists('NHANVIEN');
        Schema::dropIfExists('NHATKYDOIDIEM');
        Schema::dropIfExists('NHATKYHETHONG');
        Schema::dropIfExists('NHATKYSUCO');
        Schema::dropIfExists('PHANCONGTOUR');
        Schema::dropIfExists('QUYETTOAN');
        Schema::dropIfExists('TAIKHOAN');
        Schema::dropIfExists('TOURMAU');
        Schema::dropIfExists('TOURTHUCTE');
        Schema::dropIfExists('VAITRO');
        Schema::dropIfExists('VOUCHER');
        Schema::dropIfExists('YEUCAUHOTRO');
        Schema::enableForeignKeyConstraints();
    }
};
