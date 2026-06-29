# Tổng Hợp Các Công Thức Tính Toán Toàn Hệ Thống (Calculation Formulas Audit)

Tài liệu này rà soát và tổng hợp lại tất cả các công thức tính toán/nghiệp vụ quan trọng nhất trong hệ thống Digital Travel ERP. Nó thể hiện sự đồng nhất giữa **Frontend** và **Backend** dựa trên nguyên tắc Backend là nguồn quyậ¿t định cuối cùng (Single Source of Truth).

---

## 1. Công thức tính Giá Vé (Pricing Formula)
**Mục đích**: Tính tổng tiền khi khách hàng đặt tour dựa trên độ tuổi, dịch vụ thêm và khuyậ¿n mÃi.

*   **Giá trị vé người lớn**: Lấy nguyên giá (`don_gia`).
*   **Giá trị vé trậ» em**: Giảm 50% (`don_gia / 2`). Điều kiện: Khách hàng <= 11 tuổi so với ngày khởi hành.
*   **Backend**: `DatTourService::tinhGiaVeTheoNgaySinh()` sử dụng `Carbon::parse()->diffInYears()`.
*   **Frontend**: `CuaSoDatTour.tsx` sử dụng `parseApiDate()`.
*   **Sự đồng nhất**: **âœ… Đồng nhất**. Hai bên đang tính toán khớp 100%.

## 2. Công thức tính Giảm giá Voucher (Discount Formula)
**Mục đích**: Tính số tiền được trừ khi áp dụng mÝgiảm giá.

*   **Voucher theo Số Tiền**: Tiền giảm = `gia_tri_giam`.
*   **Voucher theo %**: Tiền giảm = `Tổng_tiền * (gia_tri_giam / 100)`. Bị giới hạn không vượt quá mức trần: `Tiền giảm = MIN(Tiền giảm, muc_giam_toi_da)`.
*   **Backend**: `VoucherService::tinhTienUuDai()`.
*   **Frontend**: `CuaSoDatTour.tsx` hàm `tinhTongTien()`.
*   **Sự đồng nhất**: **âœ… Đồng nhất**. Cả hai phía đều kiểm soát đúng mức trần giảm giá.

## 3. Công thức Phạt Hủy Tour (Cancellation Penalty Formula)
**Mục đích**: Tính phần trăm phí phạt và số tiền hoàn trả khi khách yêu cầu hủy tour (Tỷ lệ bậc thang theo số ngày còn lại đậ¿n lúc khởi hành).

*   **Quy tắc phạt**:
    *   Hủy trước > 15 ngày: Phạt **10%** tổng tiền. (Hoàn 90%)
    *   Hủy từ 7 - 15 ngày: Phạt **30%** tổng tiền. (Hoàn 70%)
    *   Hủy từ 3 - 6 ngày: Phạt **50%** tổng tiền. (Hoàn 50%)
    *   Hủy < 3 ngày: Phạt **100%** tổng tiền. (Không hoàn tiền)
*   **Backend**: `HuyDonService::tinhPhiHuyTour()` và `HuyDonService::tinhTiLeHoan()`.
*   **Frontend**: UI Frontend chỉ nhận và show trạng thái. Thông điệp marketing "Hủy tour dễ dàng, hoàn tiền minh bạch".
*   **Sự đồng nhất**: **âœ… Đồng nhất**. UI hiển thị minh bạch và gọi API hủy để backend tự động tính toán.

## 4. Công thức Xậ¿p Hạng & Điểm Xanh (Loyalty Points Formula)
**Mục đích**: Tích lũy điểm khi đi tour, nâng/hạ hạng và quy đổi ra Voucher.

### 4.1. Cộng điểm và Nâng hạng
*   **Công thức**: `Điểm khách hàng += Tổng (Điểm_hành_động_xanh * Số_lượng)`.
*   **Các mức hạng**: `ĐỒNG` (500), `Bậ C` (1000), `VÀNG` (2000), `KIM CƯƠNG` (5000).
*   **Backend**: `VanHanhService.php` (tự động tính khi tour kậ¿t thúc).

### 4.2. Trừ điểm và Hạ hạng (Inactivity Penalty)
*   **Công thức**: Nậ¿u khách hàng không có hoạt động trong 6 tháng, bị hạ 1 bậc. Đồng thời điểm sậ½ bị gọt về mức "trần" của bậc mới.
    *   VD: Đang Kim Cương (6000 điểm) -> Hạ xuống Vàng, điểm reset về 4999 (Max của Vàng).
*   **Backend**: `Console/Commands/DowngradeMembership.php` (Chạy Cronjob).

### 4.3. Điểm cần để đổi Voucher (Redemption Formula)
*   **Công thức**: Dựa vào `tinhDiemCanDoi` ở `VoucherService`. 
    *   Voucher tiền mặt: 1 VNĐ = 1 Điểm. 
    *   Voucher %: `Mức_giảm_tối_đa * Phần_trăm * 2 / 100` (hoặc nhân 50 nậ¿u không có trần).
*   **Sự đồng nhất toàn luồng loyalty**: **âœ… Rất Đồng Nhất**. Frontend hiển thị mọi điểm số thông qua Response của Backend, không tự tính điểm.

## 5. Công thức Xậ¿p Hạng Đánh Giá (Rating Average Formula)
**Mục đích**: Tính điểm trung bình (Số sao) cho Tour và Hướng Dẫn Viên.

*   **Công thức (Rolling Average)**: `New_Avg = (Old_Avg * Old_Count + New_Rating) / (Old_Count + 1)`
*   **Backend**: `DanhGiaService.php`
*   **Sự đồng nhất**: **âœ… Đồng nhất**. Hệ thống dùng Moving Average để giảm thiểu tài nguyên CPU phải sum lại từ đầu. Frontend chỉ render dựa trên kậ¿t quả.

## 6. Công thức Tính Lợi Nhuận Kậ¿ Toán (Profit Formula)
**Mục đích**: Tính lÃi/lỗ của một tour sau khi đÝvận hành xong.

*   **Doanh Thu**: Tổng `tong_tien` của các đơn đặt tour có `trang_thai` trong danh sách: `[DA_XAC_NHAN, CHO_HUY, CHO_HOAN_TIEN, TU_CHOI_HOAN_TIEN, HOAN_THANH]`.
*   **Chi Phí**: Tổng `thanh_tien` từ bảng `ChiPhiThucTe` có `trang_thai_duyet = DA_DUYET`.
*   **Lợi nhuận**: `Doanh Thu - Chi Phí`
*   **Backend**: `QuyetToanService.php`. Frontend Admin Dashboard chỉ gọi API lấy báo cáo.
*   **Sự đồng nhất**: **âœ… Tuyệt đối**. Logic tài chính nội bộ được niêm phong hoàn toàn trong Backend.

---

### Kậ¿t luận
Toàn bộ hệ thống hiện đang sử dụng chung bộ công thức **rất chặt chậ½ và đồng nhất**, không có sự xung đột logic nào làm lệch dữ liệu Database. Frontend thực hiện tốt vai trò hiển thị và trải nghiệm người dùng, nhường toàn quyền quyậ¿t định logic nghiệp vụ cốt lõi cho Backend xử lý.
