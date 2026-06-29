export interface LoaiPhongRequest {
    tenLoai: string;
    mucPhuThu?: number;
    trangThai?: string;
}

export interface ApiResponseLoaiPhongResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: LoaiPhongResponse;
    error?: string;
}

export interface ApiResponseVoid {
    status?: number;
    success?: boolean;
    message?: string;
    data?: unknown;
    error?: string;
}

export interface DichVuThemRequest {
    ten: string;
    donViTinh?: string;
    donGia: number;
    trangThai?: string;
}

export interface ApiResponseDichVuThemResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: DichVuThemResponse;
    error?: string;
}

export interface ApiResponseListLoaiPhongResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: LoaiPhongResponse[];
    error?: string;
}

export interface ApiResponseListDichVuThemResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: DichVuThemResponse[];
    error?: string;
}

export interface LoaiPhongResponse {
    maLoaiPhong?: string;
    tenLoai?: string;
    mucPhuThu?: number;
    trangThai?: string;
}

export interface DichVuThemResponse {
    maDichVuThem?: string;
    ten?: string;
    donViTinh?: string;
    donGia?: number;
    trangThai?: string;
}

export interface Service {
    id: string;
    code: string;
    name: string;
    category: 'room' | 'extra';
    price: number;
    unit: string;
    status: 'active' | 'inactive';
}

export interface ApiResponseTourThucTeResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: TourThucTeResponse;
    error?: string;
}

export interface CapNhatTourThucTeRequest {
    giaHienHanh?: number;
    soKhachToiDa?: number;
    soKhachToiThieu?: number;
    trangThai?: string;
    maDichVuThem?: string[];
    maHanhDongXanh?: string[];
}

export interface ApiResponsePageTourThucTeResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageTourThucTeResponse;
    error?: string;
}

export interface TaoTourThucTeRequest {
    maTourMau?: string;
    ngayKhoiHanh?: string;
    soKhachToiDa?: number;
    soKhachToiThieu?: number;
    giaHienHanh?: number;
    trangThai?: string;
    maDichVuThem?: string[];
    maHanhDongXanh?: string[];
}

export interface TourThucTeResponse {
    maTourThucTe?: string;
    maTourMau?: string;
    tieuDeTour?: string;
    ngayKhoiHanh?: string;
    ngayKetThuc?: string;
    giaHienHanh?: number;
    soKhachToiDa?: number;
    soKhachToiThieu?: number;
    choConLai?: number;
    trangThai?: string;
    thoiDiemTao?: string;
    capNhatVao?: string;
    taoBoi?: string;
    dichVu?: any[];
    hanhDongXanh?: any[];
}

export interface PageTourThucTeResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: TourThucTeResponse[];
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

export interface TourInstance {
    id: string;
    code: string;
    name: string;
    startDate: string;
    endDate: string;
    departureDate: string;
    vehicle: string;
    maxSeats: number;
    minSeats?: number;
    bookedSeats: number;
    currentPrice: number;
    basePrice: number;
    status: string;
    templateId: string;
    schedule: DaySchedule[];
    services?: any[];
    greenActions?: any[];
}

export interface ApiResponseTourMauChiTietResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: TourMauChiTietResponse;
    error?: string;
}

export interface CapNhatTourMauRequest {
    tieuDe?: string;
    moTa?: string;
    thoiLuong?: number;
    giaSan?: number;
    trangThai?: string;
    lichTrinh?: LichTrinhRequest[];
    dichVu?: any[];
}

export interface ApiResponseTourMauResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: TourMauResponse;
    error?: string;
}

export interface LichTrinhRequest {
    ngayThu: number;
    hoatDong: string;
    moTa?: string;
    thucDon?: string;
}

export interface ApiResponseLichTrinhResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: LichTrinhResponse;
    error?: string;
}

export interface ApiResponsePageTourMauResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageTourMauResponse;
    error?: string;
}

export interface TaoTourMauRequest {
    tieuDe: string;
    moTa?: string;
    thoiLuong: number;
    giaSan: number;
    lichTrinh?: LichTrinhRequest[];
}

export interface TourMauChiTietResponse {
    maTourMau?: string;
    tieuDe?: string;
    moTa?: string;
    thoiLuong?: number;
    giaSan?: number;
    danhGia?: number;
    soDanhGia?: number;
    trangThai?: string;
    thoiDiemTao?: string;
    capNhatVao?: string;
    taoBoi?: string;
    lichTrinh?: LichTrinhResponse[];
}

export interface TourMauResponse {
    maTourMau?: string;
    tieuDe?: string;
    moTa?: string;
    thoiLuong?: number;
    giaSan?: number;
    danhGia?: number;
    soDanhGia?: number;
    trangThai?: string;
    thoiDiemTao?: string;
    capNhatVao?: string;
    taoBoi?: string;
}

export interface LichTrinhResponse {
    maLichTrinhTour?: string;
    ngayThu?: number;
    hoatDong?: string;
    moTa?: string;
    thucDon?: string;
}

export interface PageTourMauResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: TourMauResponse[];
    number?: number;
    numberOfElements?: number;
    pageable?: PageableObject;
    sort?: SortObject;
    first?: boolean;
    last?: boolean;
    empty?: boolean;
}

export interface DaySchedule {
    id?: string;
    title: string;
    description: string;
    meals: {
        breakfast: string;
        lunch: string;
        dinner: string;
        };
}

export interface TourTemplate {
    id: string;
    code: string;
    title: string;
    description: string;
    duration: {
        days: number;
        nights: number;
        };
    basePrice: number;
    status: string;
    tags: string;
    image: string;
    schedule: DaySchedule[];
    services?: any[];
}
