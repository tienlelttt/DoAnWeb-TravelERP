export interface PhanCongHdvRequest {
    maTourThucTe: string;
    maNhanVien: string;
    ghiChu?: string;
}

export interface ApiResponsePhanCongResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PhanCongResponse;
    error?: string;
}

export interface ApiResponseListNhanVienResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: NhanVienResponse[];
    error?: string;
}

export interface ApiResponseVoid {
    status?: number;
    success?: boolean;
    message?: string;
    data?: any;
    error?: string;
}

export interface PhanCongResponse {
    maPhanCong?: string;
    maTourThucTe?: string;
    tenTour?: string;
    maNhanVien?: string;
    tenNhanVien?: string;
    trangThaiChapNhan?: string;
    trangThaiTour?: string;
    trangThai?: string;
    ngayPhanCong?: string;
    ngayKhoiHanh?: string;
    ngayKetThuc?: string;
    soKhachToiDa?: number;
    choConLai?: number;
    danhSachHanhKhach?: ThanhVienDoanResponse[];
}

export interface ThanhVienDoanResponse {
    maDatTour?: string;
    loaiKhach?: string;
    maKhachHang?: string;
    maNguoiDongHanh?: string;
    hoTenKhachHang?: string;
    soDienThoai?: string;
    hangThanhVien?: string;
    ghiChuYTe?: string;
    ghiChuDatTour?: string;
    hanhDongXanh?: string;
    diemXanh?: number;
    trangThai?: string;
    ghiChuDiemDanh?: string;
}

export interface NhanVienResponse {
    maNhanVien?: string;
    maTaiKhoan?: string;
    tenDangNhap?: string;
    hoTen?: string;
    email?: string;
    soDienThoai?: string;
    maVaiTro?: string;
    trangThaiTaiKhoan?: string;
    trangThaiLamViec?: string;
    loaiNhanVien?: string;
    ngayVaoLam?: string;
    thoiDiemTao?: string;
}

export interface TourNeedGuide {
    id: string;
    code: string;
    name: string;
    startDate: string;
    endDate: string;
    duration: string;
    passengers: number;
    requiredSkills: string[];
    status: 'pending' | 'assigned';
    location?: string;
    assignedGuide?: {
        id: string;
        name: string;
        avatar?: string;
        };
}

export interface Guide {
    id: string;
    code: string;
    name: string;
    avatar?: string;
    languages: string[];
    skills: string[];
    rating: number;
    status: string;
    completedTours: number;
    matchPercent?: number;
    biography?: string;
    certificates?: string[];
    strengths?: string[];
    experience?: string;
    schedule?: { tour: string; start: string; end: string }[];
    phone?: string;
}
