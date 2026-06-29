<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

// Model lưu thông tin tài khoản người dùng.
class TaiKhoan extends BaseModel implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    protected $table = 'tai_khoans';
    protected $primaryKey = 'ma_tai_khoan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    protected $hidden = ['mat_khau'];


    /**
     * Tên cột chứa mật khẩu
     */
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    public function vaiTro() {
        return $this->belongsTo(VaiTro::class, 'vai_tro', 'ma_vai_tro'); 
    }

    /**
     * Lấy giá trị định danh cho JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Tức là ma_tai_khoan. Hoặc $this->ten_dang_nhap tuỳ ý, nhưng nên để getKey() để Auth::user() dễ tìm
    }

    /**
     * Thêm các thông tin tuỳ chỉnh vào token.
     */
    public function getJWTCustomClaims()
    {
        // Dùng trực tiếp cột FK vai_tro để tránh lazy-load quan hệ khi sinh token
        return [
            'roles'      => [$this->vai_tro],
            'maVaiTro'   => (string) ($this->vai_tro ?? ''),
            'tenHienThi' => $this->vai_tro ?? '',
            'hoTen'      => $this->ho_ten ?? '',
        ];
    }
}
