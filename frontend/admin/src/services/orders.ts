import api from './api';
import { unwrapApiData, type PageQueryParams } from '../utils/apiHelpers';
import type { ApiResponseDonDatTourResponse, ApiResponsePageDonDatTourResponse, DonDatTourResponse, PageDonDatTourResponse, ChiTietDatTourResponse, ChiTietDichVuResponse  } from '../types/booking';
import type { PageableObject, SortObject  } from '../types/system';

export type {
  DonDatTourResponse,
  PageDonDatTourResponse,
  ChiTietDatTourResponse,
  ChiTietDichVuResponse,
  ApiResponseDonDatTourResponse,
  ApiResponsePageDonDatTourResponse,
  PageableObject,
  SortObject,
};

export interface DatTourListParams extends PageQueryParams {
  trangThai?: string;
  maTourThucTe?: string;
}

export const ordersService = {
  danhSachTatCa: async (params?: DatTourListParams): Promise<PageDonDatTourResponse | undefined> => {
    const queryParams: Record<string, string | number> = {
      page: params?.page ?? 0,
      size: params?.size ?? 200,
      sort: params?.sort ?? 'khachHang,desc',
    };
    if (params?.trangThai) queryParams.trangThai = params.trangThai;
    if (params?.maTourThucTe) queryParams.maTourThucTe = params.maTourThucTe;

    const response = await api.get<ApiResponsePageDonDatTourResponse>('/api/kinh-doanh/dat-tour', {
      params: queryParams,
    });
    return unwrapApiData(response);
  },

  chiTietDatTour: async (maDatTour: string): Promise<DonDatTourResponse> => {
    const response = await api.get<ApiResponseDonDatTourResponse>(`/api/kinh-doanh/dat-tour/${maDatTour}`);
    const data = unwrapApiData(response);
    if (!data) throw new Error(`Không tìm thấy đơn đặt tour: ${maDatTour}`);
    return data;
  },

  xacNhanDon: async (maDatTour: string): Promise<DonDatTourResponse | undefined> => {
    const response = await api.put<ApiResponseDonDatTourResponse>(
      `/api/kinh-doanh/dat-tour/${maDatTour}/xac-nhan`,
      {}
    );
    return unwrapApiData(response);
  },

  tuChoiThanhToan: async (maDatTour: string): Promise<DonDatTourResponse | undefined> => {
    const response = await api.put<ApiResponseDonDatTourResponse>(
      `/api/kinh-doanh/dat-tour/${maDatTour}/tu-choi-thanh-toan`,
      {}
    );
    return unwrapApiData(response);
  },
};

