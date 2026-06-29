import api from '../services/api';
import type { XuLyHoTroRequest, ApiResponseYeuCauHoTroResponse, ApiResponsePageYeuCauHoTroResponse, YeuCauHoTroResponse, PageYeuCauHoTroResponse  } from '../types/complaint';
import type { PageableObject, SortObject  } from '../types/system';

export type {
    XuLyHoTroRequest,
    YeuCauHoTroResponse,
    PageYeuCauHoTroResponse,
    ApiResponseYeuCauHoTroResponse,
    ApiResponsePageYeuCauHoTroResponse,
    PageableObject,
    SortObject,
};


export const complaintsService = {
    xuLyYeuCauHoTro: async (maYeuCau: string, data: XuLyHoTroRequest) => {
        const response = await api.put<ApiResponseYeuCauHoTroResponse>(`/api/kinh-doanh/yeu-cau-ho-tro/${maYeuCau}`, data);
        return response.data.data;
    },
    yeuCauHdvGiaiTrinh: async (maYeuCau: string, noiDung: string) => {
        const response = await api.post<ApiResponseYeuCauHoTroResponse>(
            `/api/kinh-doanh/yeu-cau-ho-tro/${maYeuCau}/yeu-cau-hdv-giai-trinh`,
            { noiDung }
        );
        return response.data.data;
    },
    yeuCauKhachHangBoSung: async (maYeuCau: string, noiDung: string) => {
        const response = await api.post<ApiResponseYeuCauHoTroResponse>(
            `/api/kinh-doanh/yeu-cau-ho-tro/${maYeuCau}/yeu-cau-khach-hang-bo-sung`,
            { noiDung }
        );
        return response.data.data;
    },
    danhSachYeuCauHoTro: async (params?: Record<string, any>) => {
        const response = await api.get<ApiResponsePageYeuCauHoTroResponse>('/api/kinh-doanh/yeu-cau-ho-tro', { params: { page: 0, size: 1000, ...params } });
        return response.data.data;
    },
    danhSachTongHopKhieuNaiSuCo: async (params?: Record<string, any>) => {
        const response = await api.get('/api/kinh-doanh/tong-hop-khieu-nai-su-co', { params });
        return response.data.data;
    }
};
