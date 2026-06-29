export interface ApiResponseHanhDongXanhResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: HanhDongXanhResponse;
    error?: string;
}

export interface HanhDongXanhRequest {
    tenHanhDong: string;
    diemCong: number;
    trangThai?: string;
}

export interface ApiResponseVoid {
    status?: number;
    success?: boolean;
    message?: string;
    data?: any;
    error?: string;
}

export interface ApiResponseListHanhDongXanhResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: HanhDongXanhResponse[];
    error?: string;
}

export interface HanhDongXanhResponse {
    maHanhDongXanh?: string;
    tenHanhDong?: string;
    diemCong?: number;
    trangThai?: string;
}

export interface GreenAction {
    id: string;
    code: string;
    name: string;
    description: string;
    defaultPoints: number;
    status: 'active' | 'inactive';
}
