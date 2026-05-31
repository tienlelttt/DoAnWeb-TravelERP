<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaiKhoan;
use App\Models\VaiTro;
use App\Models\HoChieuSo;
use App\Services\MaTuDongService;
use App\Exceptions\AppException;
use App\Traits\ApiResponse;
use App\Http\Requests\DangKyRequest;
use App\Http\Requests\DangNhapRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponse;

    protected MaTuDongService $maTuDongService;

    public function __construct(MaTuDongService $maTuDongService)
    {
        $this->maTuDongService = $maTuDongService;
    }

    /**
     * Xử lý đăng ký tài khoản khách hàng mới
     */
    public function dangKy(DangKyRequest $request)
    {
        if ($request->matKhau !== $request->xacNhanMatKhau) {
            throw AppException::badRequest("Mật khẩu và xác nhận mật khẩu không khớp");
        }
        
        if (TaiKhoan::where('TenDangNhap', $request->tenDangNhap)->exists()) {
            throw AppException::badRequest("Tên đăng nhập đã tồn tại");
        }
        
        if (!empty($request->email) && TaiKhoan::where('Email', $request->email)->exists()) {
            throw AppException::badRequest("Email đã được sử dụng");
        }
        
        if (!empty($request->cccd) && TaiKhoan::where('CCCD', $request->cccd)->exists()) {
            throw AppException::badRequest("CCCD đã được sử dụng");
        }

        $vaiTroKhach = VaiTro::find('KHACHHANG');
        if (!$vaiTroKhach) {
            throw AppException::notFound("Không tìm thấy vai trò KHÁCH HÀNG");
        }

        DB::transaction(function () use ($request, $vaiTroKhach) {
            $taiKhoan = new TaiKhoan();
            $taiKhoan->MaTaiKhoan = $this->maTuDongService->taoMaTaiKhoanTheoVaiTro('KHACHHANG');
            $taiKhoan->TenDangNhap = $request->tenDangNhap;
            $taiKhoan->MatKhau = Hash::make($request->matKhau);
            $taiKhoan->HoTen = $request->hoTen;
            $taiKhoan->Cccd = $request->cccd;
            $taiKhoan->NgaySinh = $request->ngaySinh;
            $taiKhoan->Email = $request->email;
            $taiKhoan->SoDienThoai = $request->soDienThoai;
            $taiKhoan->VaiTro = $vaiTroKhach->MaVaiTro;
            $taiKhoan->TrangThai = 'HOAT_DONG';
            $taiKhoan->save();

            $hoChieuSo = new HoChieuSo();
            $hoChieuSo->MaKhachHang = $this->maTuDongService->taoMaHoChieuSo();
            $hoChieuSo->MaTaiKhoan = $taiKhoan->MaTaiKhoan;
            $hoChieuSo->HangThanhVien = 'THANH_VIEN';
            $hoChieuSo->DiemXanh = 0;
            $hoChieuSo->save();
        });

        // Tự động đăng nhập sau khi đăng ký
        $credentials = [
            'TenDangNhap' => $request->tenDangNhap,
            'password' => $request->matKhau
        ];
        
        $token = Auth::guard('api')->attempt($credentials);
        $user = Auth::guard('api')->user();
        $vaiTro = $user->vaiTro;

        return $this->created([
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'maVaiTro' => $vaiTro ? $vaiTro->MaVaiTro : null,
            'tenHienThi' => $vaiTro ? $vaiTro->TenHienThi : null,
            'hoTen' => $user->HoTen
        ]);
    }

    /**
     * Xử lý đăng nhập và sinh JWT
     */
    public function dangNhap(DangNhapRequest $request)
    {
        // Ghi chú: password ở đây tương ứng với hàm getAuthPassword() trả về $this->MatKhau
        $credentials = [
            'TenDangNhap' => $request->tenDangNhap,
            'password' => $request->matKhau
        ];

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            throw AppException::unauthorized("Sai tên đăng nhập hoặc mật khẩu", "BAD_CREDENTIALS");
        }

        $user = Auth::guard('api')->user();
        if ($user->TrangThai !== 'HOAT_DONG') {
            throw new AppException(403, "FORBIDDEN", "Tài khoản không ở trạng thái HOAT_DONG");
        }

        $vaiTro = $user->vaiTro;

        return $this->ok("Đăng nhập thành công", [
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'maVaiTro' => $vaiTro ? $vaiTro->MaVaiTro : null,
            'tenHienThi' => $vaiTro ? $vaiTro->TenHienThi : null,
            'hoTen' => $user->HoTen
        ]);
    }

    /**
     * Đổi mật khẩu cho người dùng đang đăng nhập
     */
    public function doiMatKhau(Request $request)
    {
        $request->validate([
            'matKhauCu' => 'required',
            'matKhauMoi' => 'required|min:6',
            'xacNhanMatKhau' => 'required'
        ]);

        if ($request->matKhauMoi !== $request->xacNhanMatKhau) {
            throw AppException::badRequest("Mật khẩu mới và xác nhận không khớp");
        }

        $user = Auth::guard('api')->user();
        if (!Hash::check($request->matKhauCu, $user->MatKhau)) {
            throw AppException::unauthorized("Mật khẩu cũ không đúng", "UNAUTHORIZED");
        }

        $user->MatKhau = Hash::make($request->matKhauMoi);
        $user->save();

        return $this->noContent("Đổi mật khẩu thành công");
    }

    /**
     * Hủy token và đăng xuất
     */
    public function dangXuat()
    {
        Auth::guard('api')->logout();
        return $this->noContent("Đăng xuất thành công");
    }

    /**
     * Kiểm tra mật khẩu (để xác thực trước khi thực hiện tác vụ nhạy cảm)
     */
    public function kiemTraMatKhau(Request $request)
    {
        $request->validate([
            'matKhauCu' => 'required'
        ]);

        $user = Auth::guard('api')->user();
        if (!Hash::check($request->matKhauCu, $user->MatKhau)) {
            throw AppException::unauthorized("Mật khẩu cũ không đúng", "UNAUTHORIZED");
        }

        return $this->noContent("Mật khẩu cũ chính xác");
    }

    /**
     * Quên mật khẩu
     */
    public function quenMatKhau(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $taiKhoan = TaiKhoan::where('Email', $request->email)->first();
        if (!$taiKhoan) {
            throw AppException::notFound("Không tìm thấy tài khoản với email này");
        }

        // Tạo token JWT tuỳ chỉnh dành cho reset mật khẩu
        // Ở thực tế, bạn có thể gửi email có chứa link reset kèm theo resetToken.
        $resetToken = JWTAuth::customClaims(['is_reset_token' => true])->fromUser($taiKhoan);
        
        // TODO: Gửi email chứa resetToken cho người dùng
        return $this->ok("Đã gửi hướng dẫn đặt lại mật khẩu vào email của bạn", null);
    }

    /**
     * Đặt lại mật khẩu (dùng token từ quen mật khẩu)
     */
    public function datLaiMatKhau(Request $request)
    {
        $request->validate([
            'resetToken' => 'required|string',
            'matKhauMoi' => 'required|min:6',
            'xacNhanMatKhau' => 'required'
        ]);

        if ($request->matKhauMoi !== $request->xacNhanMatKhau) {
            throw AppException::badRequest("Mật khẩu mới và xác nhận không khớp");
        }

        try {
            // Lấy payload từ JWT token mà không gán auth() login.
            $payload = JWTAuth::setToken($request->resetToken)->getPayload();
            
            // Check custom claim
            if (!$payload->get('is_reset_token')) {
                throw AppException::unauthorized("Token không hợp lệ để reset mật khẩu", "UNAUTHORIZED");
            }
            
            // Tìm user từ token subject
            $taiKhoan = JWTAuth::setToken($request->resetToken)->toUser();
            
            if (!$taiKhoan) {
                throw AppException::notFound("Không tìm thấy tài khoản");
            }

            $taiKhoan->MatKhau = Hash::make($request->matKhauMoi);
            $taiKhoan->save();

            // Huỷ token reset sau khi xài xong
            JWTAuth::invalidate($request->resetToken);

            return $this->noContent("Đặt lại mật khẩu thành công");
        } catch (\Exception $e) {
            throw AppException::unauthorized("Token không hợp lệ hoặc đã hết hạn", "UNAUTHORIZED");
        }
    }
}
