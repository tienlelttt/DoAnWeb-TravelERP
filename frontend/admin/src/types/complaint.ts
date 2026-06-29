export interface XuLyHoTroRequest {
    maNhanVienXuLy?: string;
    trangThai: string;
    ghiChu?: string;
}

export interface ApiResponseYeuCauHoTroResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: YeuCauHoTroResponse;
    error?: string;
}

export interface ApiResponsePageYeuCauHoTroResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageYeuCauHoTroResponse;
    error?: string;
}

export interface YeuCauHoTroResponse {
    maYeuCau?: string;
    maDatTour?: string;
    loaiYeuCau?: string;
    noiDung?: string;
    trangThai?: string;
    maNhanVienXuLy?: string;
    soTienHoan?: number;
    tiLeHoan?: number;
    thoiDiemTao?: string;
    tenKhachHang?: string;
    soDienThoai?: string;
    tenTour?: string;
}

export interface PageYeuCauHoTroResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: YeuCauHoTroResponse[];
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

export interface Complaint {
    id: string;
    code: string;
    customerName: string;
    maDatTour?: string;
    maTourThucTe?: string;
    customerPhone: string;
    tourName: string;
    guideName?: string;
    sentDate: string;
    severity: 'THAP' | 'SOS';
    status: 'pending' | 'processing' | 'pending_info' | 'pending_guide' | 'resolved' | 'rejected' | 'cancelled';
    description: string;
    attachments?: string[];
    timeline: { action: string; timestamp: string }[];
    resolution?: string;
    source: 'complaint' | 'incident';
}
