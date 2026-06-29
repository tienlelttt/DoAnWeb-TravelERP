export interface ApiResponsePageHoChieuSoResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageHoChieuSoResponse;
    error?: string;
}

export interface ApiResponseHoChieuSoResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: HoChieuSoResponse;
    error?: string;
}

export interface PageHoChieuSoResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: HoChieuSoResponse[];
    number?: number;
    numberOfElements?: number;
    pageable?: PageableObject;
    sort?: SortObject;
    first?: boolean;
    last?: boolean;
    empty?: boolean;
}

export interface HoChieuSoResponse {
    maKhachHang?: string;
    maTaiKhoan?: string;
    tenDangNhap?: string;
    hoTen?: string;
    email?: string;
    cccd?: string;
    ngaySinh?: string;
    soDienThoai?: string;
    diUng?: string;
    ghiChuYTe?: string;
    hangThanhVien?: string;
    diemXanh?: number;
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

export interface ComplaintHistory {
    id: string;
    code: string;
    date: string;
    description: string;
    status: 'pending' | 'processing' | 'resolved' | 'rejected';
}

export interface TourHistory {
    tourCode: string;
    tourName: string;
    startDate: string;
    status: 'completed' | 'cancelled';
    amount: number;
}

export interface Customer {
    id: string;
    code: string;
    name: string;
    email: string;
    phone: string;
    membershipTier: 'diamond' | 'gold' | 'silver' | 'bronze' | 'member';
    greenPoints: number;
    status: 'active' | 'locked';
    avatar?: string;
    birthday?: string;
    address?: string;
    gender?: string;
    idCard?: string;
    tourHistory: TourHistory[];
    complaints?: ComplaintHistory[];
}

export interface ApiResponseDonDatTourResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: DonDatTourResponse;
    error?: string;
}

export interface ApiResponsePageDonDatTourResponse {
    status?: number;
    success?: boolean;
    message?: string;
    data?: PageDonDatTourResponse;
    error?: string;
}

export interface DonDatTourResponse {
    maDatTour?: string;
    maTourThucTe?: string;
    tieuDeTour?: string;
    ngayKhoiHanh?: string;
    giaHienHanh?: number;
    thoiLuong?: number;
    maKhachHang?: string;
    tenKhachHang?: string;
    ngayDat?: string;
    tongTien?: number;
    tongTienGoc?: number;
    soTienUuDai?: number;
    maVoucher?: string;
    maCodeVoucher?: string;
    tenVoucher?: string;
    giaTriVoucher?: number;
    soTienGiam?: number;
    tienGiam?: number;
    soNguoiLon?: number;
    soTreEm?: number;
    soLuongVeTreEm?: number;
    tienVeTreEm?: number;
    diemXanh?: number;
    soDiemXanh?: number;
    diemXanhDuKien?: number;
    ghiChuDiemXanh?: string;
    trangThai?: string;
    maGiaoDich?: string;
    phuongThuc?: string;
    daBaoChuyenKhoan?: boolean;
    thoiGianHetHan?: string;
    ghiChu?: string;
    thoiDiemTao?: string;
    maHuongDanVien?: string;
    tenHuongDanVien?: string;
    soDienThoaiHuongDanVien?: string;
    danhGiaHuongDanVien?: number;
    soDanhGiaHuongDanVien?: number;
    capNhatVao?: string;
    chiTietKhach?: ChiTietDatTourResponse[];
    chiTietDichVu?: ChiTietDichVuResponse[];
}

export interface PageDonDatTourResponse {
    totalPages?: number;
    totalElements?: number;
    size?: number;
    content?: DonDatTourResponse[];
    number?: number;
    numberOfElements?: number;
    pageable?: PageableObject;
    sort?: SortObject;
    first?: boolean;
    last?: boolean;
    empty?: boolean;
}

export interface ChiTietDatTourResponse {
    maChiTietDat?: string;
    maKhachHang?: string;
    hoTen?: string;
    soDienThoai?: string;
    cccd?: string;
    soGiayTo?: string;
    loaiKhach?: string;
    loaiKhachHang?: string;
    loaiVe?: string;
    ngaySinh?: string;
    doTuoi?: number;
    tuoi?: number;
    age?: number;
    nhomTuoi?: string;
    doiTuong?: string;
    doiTuongKhach?: string;
    phanLoai?: string;
    laTreEm?: boolean;
    isTreEm?: boolean;
    isChild?: boolean;
    treEm?: boolean;
    maLoaiPhong?: string;
    tenLoaiPhong?: string;
    mucPhuThu?: number;
    giaTaiThoiDiemDat?: number;
    giaVeTreEm?: number;
}

export interface ChiTietDichVuResponse {
    maChiTietDichVu?: string;
    maDichVuThem?: string;
    tenDichVu?: string;
    donViTinh?: string;
    soLuong?: number;
    donGia?: number;
    thanhTien?: number;
}

export interface Passenger {
    name: string;
    ageGroup: 'Người lớn' | 'Trẻ em' | 'Em bé';
    gender: 'Nam' | 'Nữ';
    customerCode?: string;
    phone?: string;
    identityNumber?: string;
    roomType?: string;
    surcharge?: number;
    price?: number;
}

export interface Order {
    id: string;
    orderCode: string;
    customerName: string;
    customerPhone: string;
    email?: string;
    tourName: string;
    departureDate: string;
    bookingDate: string;
    totalAmount: number;
    originalAmount?: number;
    voucherCode?: string;
    voucherName?: string;
    voucherDiscount?: number;
    childTicketCount?: number;
    childTicketAmount?: number;
    greenPoints?: number;
    greenNote?: string;
    additionalServices?: string[];
    additionalServicesAmount?: number;
    adultCount?: number;
    transactionCode?: string;
    paymentMethod?: string;
    status: 'pending' | 'confirmed' | 'completed' | 'cancelled';
    paymentStatus: 'paid' | 'unpaid' | 'failed' | 'refunded';
    passengerCount: number;
    passengers?: Passenger[];
    isExpired?: boolean;
}
