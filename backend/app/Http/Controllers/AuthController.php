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
use Illuminate\Support\Facades\Mail;
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
        
        if (TaiKhoan::where('ten_dang_nhap', $request->tenDangNhap)->exists()) {
            throw AppException::badRequest("Tên đăng nhập đã tồn tại");
        }
        
        if (!empty($request->email) && TaiKhoan::where('email', $request->email)->exists()) {
            throw AppException::badRequest("email đã được sử dụng");
        }
        
        if (!empty($request->cccd) && TaiKhoan::where('cccd', $request->cccd)->exists()) {
            throw AppException::badRequest("cccd đã được sử dụng");
        }

        $vaiTroKhach = VaiTro::find('KHACHHANG');
        if (!$vaiTroKhach) {
            throw AppException::notFound("Không tìm thấy vai trò KHÁCH HÀNG");
        }

        DB::transaction(function () use ($request, $vaiTroKhach) {
            $taiKhoan = new TaiKhoan();
            $taiKhoan->ma_tai_khoan = $this->maTuDongService->taoMaTaiKhoanTheoVaiTro('KHACHHANG');
            $taiKhoan->ten_dang_nhap = $request->tenDangNhap;
            $taiKhoan->mat_khau = Hash::make($request->matKhau);
            $taiKhoan->ho_ten = $request->hoTen;
            $taiKhoan->cccd = $request->cccd;
            $taiKhoan->ngay_sinh = $request->ngaySinh;
            $taiKhoan->email = $request->email;
            $taiKhoan->so_dien_thoai = $request->soDienThoai;
            $taiKhoan->vai_tro = $vaiTroKhach->ma_vai_tro;
            $taiKhoan->trang_thai = 'HOAT_DONG';
            $taiKhoan->save();

            $hoChieuSo = new HoChieuSo();
            $hoChieuSo->ma_khach_hang = $this->maTuDongService->taoMaHoChieuSo();
            $hoChieuSo->ma_tai_khoan = $taiKhoan->ma_tai_khoan;
            $hoChieuSo->hang_thanh_vien = 'THANH_VIEN';
            $hoChieuSo->diem_xanh = 0;
            $hoChieuSo->save();
        });

        // Tự động đăng nhập sau khi đăng ký
        $credentials = [
            'ten_dang_nhap' => $request->tenDangNhap,
            'password' => $request->matKhau
        ];
        
        $token = Auth::guard('api')->attempt($credentials);
        $user = Auth::guard('api')->user();
        $vaiTro = $user->vaiTro;

        return $this->created([
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'maVaiTro' => $vaiTro ? $vaiTro->ma_vai_tro : null,
            'tenHienThi' => $vaiTro ? $vaiTro->ten_hien_thi : null,
            'hoTen' => $user->ho_ten
        ]);
    }

    /**
     * Xử lý đăng nhập và sinh JWT
     */
    public function dangNhap(DangNhapRequest $request)
    {
        // Ghi chú: password ở đây tương ứng với hàm getAuthPassword() trả về $this->mat_khau
        $credentials = [
            'ten_dang_nhap' => $request->tenDangNhap,
            'password' => $request->matKhau
        ];

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            throw AppException::unauthorized("Sai tên đăng nhập hoặc mật khẩu", "BAD_CREDENTIALS");
        }

        $user = Auth::guard('api')->user();
        if ($user->trang_thai !== 'HOAT_DONG') {
            throw new AppException(403, "FORBIDDEN", "Tài khoản không ở trạng thái HOAT_DONG");
        }

        $vaiTro = $user->vaiTro;

        return $this->ok("Đăng nhập thành công", [
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'maVaiTro' => $vaiTro ? $vaiTro->ma_vai_tro : null,
            'tenHienThi' => $vaiTro ? $vaiTro->ten_hien_thi : null,
            'hoTen' => $user->ho_ten
        ]);
    }

    /**
     * Lấy thông tin tài khoản đang đăng nhập để frontend/PWA hydrate session.
     */
    public function me()
    {
        $user = Auth::guard('api')->user();
        $vaiTro = $user->vaiTro;

        return $this->ok("Lấy thông tin người dùng thành công", [
            'maTaiKhoan' => $user->ma_tai_khoan,
            'tenDangNhap' => $user->ten_dang_nhap,
            'hoTen' => $user->ho_ten,
            'email' => $user->email,
            'soDienThoai' => $user->so_dien_thoai,
            'maVaiTro' => $vaiTro ? $vaiTro->ma_vai_tro : $user->vai_tro,
            'tenHienThi' => $vaiTro ? $vaiTro->ten_hien_thi : null,
            'trangThai' => $user->trang_thai,
        ]);
    }

    /**
     * Gia hạn JWT mà không yêu cầu frontend đăng nhập lại.
     */
    public function refresh()
    {
        $token = JWTAuth::parseToken()->refresh();
        $user = JWTAuth::setToken($token)->toUser();
        $vaiTro = $user->vaiTro;

        return $this->ok("Gia hạn phiên đăng nhập thành công", [
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'maVaiTro' => $vaiTro ? $vaiTro->ma_vai_tro : null,
            'tenHienThi' => $vaiTro ? $vaiTro->ten_hien_thi : null,
            'hoTen' => $user->ho_ten
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
        if (!Hash::check($request->matKhauCu, $user->mat_khau)) {
            throw AppException::unauthorized("Mật khẩu cũ không đúng", "UNAUTHORIZED");
        }

        $user->mat_khau = Hash::make($request->matKhauMoi);
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
        if (!Hash::check($request->matKhauCu, $user->mat_khau)) {
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

        $taiKhoan = TaiKhoan::where('email', $request->email)->first();
        if (!$taiKhoan) {
            throw AppException::notFound("Không tìm thấy tài khoản với email này");
        }

        // Tạo token JWT tuỳ chỉnh dành cho reset mật khẩu
        // Ở thực tế, bạn có thể gửi email có chứa link reset kèm theo resetToken.
        $resetToken = JWTAuth::customClaims(['is_reset_token' => true])->fromUser($taiKhoan);
        
        // Gửi email chứa resetToken cho người dùng
        Mail::to($taiKhoan->email)->send(new \App\Mail\ResetPasswordMail($resetToken));
        // Trả về resetToken để frontend dùng cho bước đặt lại mật khẩu
        return $this->ok("Đã gửi hướng dẫn đặt lại mật khẩu vào email của bạn", $resetToken);

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
            
            // Kiểm tra claim tùy chỉnh
            if (!$payload->get('is_reset_token')) {
                throw AppException::unauthorized("Token không hợp lệ để reset mật khẩu", "UNAUTHORIZED");
            }
            
            // Tìm user từ token subject
            $taiKhoan = JWTAuth::setToken($request->resetToken)->toUser();
            
            if (!$taiKhoan) {
                throw AppException::notFound("Không tìm thấy tài khoản");
            }

            $taiKhoan->mat_khau = Hash::make($request->matKhauMoi);
            $taiKhoan->save();

            // Huỷ token reset sau khi xài xong
            JWTAuth::invalidate($request->resetToken);

            return $this->noContent("Đặt lại mật khẩu thành công");
        } catch (\Exception $e) {
            throw AppException::unauthorized("Token không hợp lệ hoặc đã hết hạn", "UNAUTHORIZED");
        }
    }
}
