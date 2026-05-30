<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class TaiKhoan extends BaseModel implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    protected $table = 'TAIKHOAN';
    protected $primaryKey = 'MaTaiKhoan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];



    /**
     * Tên cột chứa mật khẩu
     */
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }

    public function vaiTro() {
        return $this->belongsTo(VaiTro::class, 'VaiTro', 'MaVaiTro'); 
    }

    /**
     * Lấy giá trị định danh cho JWT (Tương đương getUsername() bên Java)
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Tức là MaTaiKhoan. Hoặc $this->TenDangNhap tuỳ ý, nhưng nên để getKey() để Auth::user() dễ tìm
    }

    /**
     * Thêm các thông tin (claims) tuỳ chỉnh vào token giống hệt JwtUtil.java
     */
    public function getJWTCustomClaims()
    {
        return [
            'roles' => [$this->VaiTro],
            'maVaiTro' => $this->vaiTro ? $this->vaiTro->MaVaiTro : '',
            'tenHienThi' => $this->vaiTro ? $this->vaiTro->TenHienThi : '',
            'hoTen' => $this->HoTen
        ];
    }
}
