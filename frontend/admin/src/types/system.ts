export interface GanVaiTroRequest {
    maVaiTro: string;
}

export interface ApiResponseNhanVienResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: NhanVienResponse;
    error?: string;
}

export interface ApiResponseVoid {
    status?: number;
    success?: boolean;
    message?: string;
    data?: any;
    error?: string;
}

export interface DangKyNhanVienRequest {
    tenDangNhap: string;
    matKhau: string;
    hoTen: string;
    email?: string;
    soDienThoai?: string;
    maVaiTro: string;
}

export interface ApiResponsePageNhanVienResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageNhanVienResponse;
    error?: string;
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
    ngaySinh?: string;
    ngayVaoLam?: string;
    thoiDiemTao?: string;
    cccd?: string;
    diaChi?: string;
    tourHistory?: any[];
}

export interface PageNhanVienResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: NhanVienResponse[];
    number?: number;
    numberOfElements?: number;
    pageable?: PageableObject;
    sort?: SortObject;
    first?: boolean;
    last?: boolean;
    empty?: boolean;
}

export interface PageableObject {
    offset?: number;
    pageNumber?: number;
    pageSize?: number;
    paged?: boolean;
    sort?: SortObject;
    unpaged?: boolean;
}

export interface SortObject {
    empty?: boolean;
    sorted?: boolean;
    unsorted?: boolean;
}

export interface Account {
    id: string;
    code: string;
    name: string;
    email: string;
    phone: string;
    username: string;
    role: string;
    status: string;
    avatar?: string;
}

export interface ApiResponseNangLucResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: NangLucResponse;
    error?: string;
}

export interface NangLucRequest {
    ngonNgu?: string;
    chungChi?: string;
    chuyenMon?: string;
}

export interface NangLucResponse {
    maNangLucNhanVien?: string;
    maNhanVien?: string;
    ngonNgu?: string;
    chungChi?: string;
    chuyenMon?: string;
    danhGia?: number;
    soDanhGia?: number;
    capNhatVao?: string;
}

export interface Competency {
    id: number;
    type: 'Ngôn ngữ' | 'Chứng chỉ' | 'Thế mạnh';
    name: string;
    note?: string;
}

export interface TourHistory {
    tourCode?: string;
    tourName: string;
    startDate: string;
    status: 'completed' | 'upcoming' | 'cancelled';
    amount: number;
    guideName?: string;
}

export interface Staff {
    id: string;
    code: string;
    name: string;
    email: string;
    phone: string;
    role: string;
    avatar?: string;
    birthday?: string;
    gender?: string;
    address?: string;
    joinDate?: string;
    greenPoints?: number;
    tourHistory?: TourHistory[];
    rating?: number;
    cccd?: string;
}
