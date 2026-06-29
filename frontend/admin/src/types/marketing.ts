export interface ApiResponseVoucherResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: VoucherResponse;
    error?: string;
}

export interface VoucherRequest {
    maCode: string;
    loaiUuDai: string;
    giaTriGiam: number;
    mucGiamToiDa?: number;
    dieuKienApDung?: string;
    soLuotPhatHanh: number;
    ngayHieuLuc: string;
    ngayHetHan: string;
}

export interface ApiResponsePageVoucherResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageVoucherResponse;
    error?: string;
}

export interface PhatHanhVoucherRequest {
    maKhachHang: string;
}

export interface ApiResponseKhuyenMaiKhResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: KhuyenMaiKhResponse;
    error?: string;
}

export interface VoucherResponse {
    maVoucher?: string;
    maCode?: string;
    loaiUuDai?: string;
    giaTriGiam?: number;
    mucGiamToiDa?: number;
    diemCanDoi?: number;
    dieuKienApDung?: string;
    soLuotPhatHanh?: number;
    soLuotDaDung?: number;
    soLuotDaPhanBo?: number;
    ngayHieuLuc?: string;
    ngayHetHan?: string;
    trangThai?: string;
    thoiDiemTao?: string;
    taoBoi?: string;
}

export interface PageVoucherResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: VoucherResponse[];
    number?: number;
    numberOfElements?: number;
    pageable?: PageableObject;
    sort?: SortObject;
    first?: boolean;
    last?: boolean;
    empty?: boolean;
}

export interface KhuyenMaiKhResponse {
    maKhachHang?: string;
    hoTenKhachHang?: string;
    emailKhachHang?: string;
    soDienThoaiKhachHang?: string;
    hangThanhVien?: string;
    maVoucher?: string;
    maCode?: string;
    loaiUuDai?: string;
    giaTriGiam?: number;
    dieuKienApDung?: string;
    trangThai?: string;
    ngayHetHan?: string;
    ngayNhan?: string;
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

export interface Voucher {
    id: string;
    code: string;
    name: string;
    discountType: 'percent' | 'amount';
    discountValue: number;
    maxDiscount?: number;
    minOrderValue?: number;
    quantity: number;
    distributed: number;
    startDate?: string;
    expiryDate: string;
    status: string;
    applicableTours?: string[];
    applicableTiers?: ('diamond' | 'gold' | 'silver' | 'bronze')[];
}

export interface CustomerTarget {
    id: string;
    name: string;
    email: string;
    tier: string;
    phone: string;
    hasVoucher?: boolean;
    voucherStatus?: string;
}
