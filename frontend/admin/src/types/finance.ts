export interface ApiResponseQuyetToanResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: QuyetToanResponse;
    error?: string;
}

export interface ApiResponseThanhToanResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: ThanhToanResponse;
    error?: string;
}

export interface ApiResponseChiPhiThucTeResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: ChiPhiThucTeResponse;
    error?: string;
}

export interface QuyetToanRequest {
    giaCamKet?: number;
    ghiChu?: string;
    hoaDonAnh?: string;
}

export interface ApiResponsePageQuyetToanResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageQuyetToanResponse;
    error?: string;
}

export interface ApiResponsePageThanhToanResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageThanhToanResponse;
    error?: string;
}

export interface ApiResponsePageChiPhiThucTeResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageChiPhiThucTeResponse;
    error?: string;
}

export interface QuyetToanResponse {
    maQuyetToan?: string;
    maTour?: string;
    tenTour?: string;
    tongDoanhThu?: number;
    tongChiPhi?: number;
    giaCamKet?: number;
    loiNhuan?: number;
    trangThai?: string;
    ghiChu?: string;
    hoaDonAnh?: string;
    ngayQuyetToan?: string;
    maNhanVien?: string;
    tenNhanVien?: string;
}

export interface ThanhToanResponse {
    maGiaoDich?: string;
    maDatTour?: string;
    trangThai?: string;
    phuongThuc?: string;
    soTien?: number;
    ngayThanhToan?: string;
    payUrl?: string;
    thongBao?: string;
    noiDung?: string;
}

export interface ChiPhiThucTeResponse {
    maChiPhi?: string;
    maTour?: string;
    tenTour?: string;
    maNhanVien?: string;
    tenNhanVien?: string;
    soDienThoai?: string;
    danhMuc?: string;
    thanhTien?: number;
    hoaDonAnh?: string;
    ghiChu?: string;
    trangThaiDuyet?: string;
    ngayKhai?: string;
}

export interface PageQuyetToanResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: QuyetToanResponse[];
    number?: number;
    numberOfElements?: number;
    pageable?: PageableObject;
    sort?: SortObject;
    first?: boolean;
    last?: boolean;
    empty?: boolean;
}

export interface PageThanhToanResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: ThanhToanResponse[];
    number?: number;
    numberOfElements?: number;
    pageable?: PageableObject;
    sort?: SortObject;
    first?: boolean;
    last?: boolean;
    empty?: boolean;
}

export interface PageChiPhiThucTeResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: ChiPhiThucTeResponse[];
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

export interface CostItem {
    id: string;
    tourCode: string;
    tourName: string;
    guideName: string;
    category: string;
    amount: number;
    submittedDate: string;
    status: 'pending' | 'warning' | 'error' | 'approved' | 'rejected' | 'pending_info';
    warningType?: 'over_limit' | 'missing_docs' | null;
    warningMessage?: string;
    resolutionNote?: string;
    receiptImage?: string;
    guideId?: string;
    guidePhone?: string;
    budgetLimit?: number;
}

export interface RefundRequest {
    id: string;
    code: string;
    orderCode: string;
    customerName: string;
    customerPhone: string;
    amount: number;
    reason: string;
    status: 'pending' | 'completed' | 'rejected' | 'CHO_THANH_TOAN' | 'CHO_HOAN_TIEN' | 'THANH_CONG' | 'DA_HOAN_TIEN' | 'TU_CHOI';
    refundMethod?: 'gateway' | 'manual';
    bankAccount?: string;
    bankName?: string;
    transactionCode?: string;
    attachments?: string[];
}

export interface SettlementTour {
    id: string;
    code: string;
    name: string;
    endDate: string;
    startDate: string;
    totalRevenue: number;
    totalAllotmentCost: number;
    totalActualCost: number;
    passengerCount: number;
    guideName: string;
    guideCode: string;
    status: 'pending' | 'completed' | 'pending_info' | 'pending_over_budget';
    settlementNote?: string;
    receiptImage?: string;
    approverName?: string;
    actualCostItems: {
        category: string;
        amount: number;
        status: 'approved' | 'pending';
        warning?: string;
        }[];
    giaCamKet?: number;
}
