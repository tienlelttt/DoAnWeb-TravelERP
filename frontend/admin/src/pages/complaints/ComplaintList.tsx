import React, { useState } from 'react';
import MainLayout from '../../components/layouts/MainLayout';
import { Button } from '../../components/ui/Button';
import { Badge } from '../../components/ui/Badge';
import { SearchInput } from '../../components/ui/SearchInput';
import { Select } from '../../components/ui/Select';
import { Pagination } from '../../components/ui/Pagination';
import { ArrowRight, Eye } from 'lucide-react';
import ComplaintDrawer from './ComplaintDrawer';
import { Table } from '../../components/ui/Table';
import type { Column } from '../../components/ui/Table';
import type { YeuCauHoTroResponse, XuLyHoTroRequest } from '../../services/complaints';
import { complaintsService } from '../../services/complaints';
import type { NhatKySuCoResponse } from '../../services/incidents';
import { formatDate } from '../../utils/dateHelpers';
import { useAuth } from '../../context/AuthContext';
import { hasAccess } from '../../config/rolePermissions';
import type { Complaint  } from '../../types/complaint';

const mapStatus = (s?: string): Complaint['status'] => {
  switch (s?.toUpperCase()) {
    case 'DA_XU_LY': return 'resolved';
    case 'TU_CHOI': return 'rejected';
    case 'CHO_BO_SUNG': return 'pending_info';
    case 'CHO_GIAI_TRINH': return 'pending_guide';
    case 'CHUA_XU_LY': return 'pending';
    default: return 'pending';
  }
};


const ComplaintList: React.FC = () => {
  const itemsPerPage = 5;
  const [complaints, setComplaints] = useState<Complaint[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [search, setSearch] = useState('');
  const [selectedStatus, setSelectedStatus] = useState('all');
  const [selectedSeverity, setSelectedSeverity] = useState('all');
  const [currentPage, setCurrentPage] = useState(1);
  const [totalItems, setTotalItems] = useState(0);

  const [drawerOpen, setDrawerOpen] = useState(false);
  const [selectedComplaint, setSelectedComplaint] = useState<Complaint | null>(null);
  const [drawerMode, setDrawerMode] = useState<'edit' | 'view'>('view');

  const mapToUI = (api: YeuCauHoTroResponse): Complaint => {
    const savedResolution = localStorage.getItem(`complaint_res_${api.maYeuCau}`);
    
    const dynamicTimeline: { action: string, timestamp: string }[] = [];
    const contentStr = api.noiDung || '';
    
    // Match specific tags, ignoring preceding whitespace/newlines
    const regex = /\[(Yêu cầu KH bổ sung.*?|Yêu cầu HDV giải trình.*?|KHÁCH HÀNG BỔ SUNG.*?|HDV giải trình.*?)\]:?\s*(.*?)(?=\s*\[(?:Yêu cầu KH bổ sung|Yêu cầu HDV giải trình|KHÁCH HÀNG BỔ SUNG|HDV giải trình)|$)/gs;
    let match;
    while ((match = regex.exec(contentStr)) !== null) {
      let header = match[1];
      let text = match[2].trim();
      
      // If it's the old format [HDV giải trình: content] (no colon outside bracket)
      if (header.includes(':') && !text) {
         const parts = header.split(':');
         header = parts[0];
         text = parts.slice(1).join(':').trim();
      }

      let action = '';
      let timestamp = '';
      
      const lucIndex = header.lastIndexOf(' lúc ');
      if (lucIndex !== -1) {
         action = header.substring(0, lucIndex) + ': ' + text;
         timestamp = header.substring(lucIndex + 5);
      } else {
         action = header + ': ' + text;
      }
      
      if (/Yêu cầu KH bổ sung|Yêu cầu HDV giải trình|KHÁCH HÀNG BỔ SUNG|HDV giải trình/i.test(header)) {
        dynamicTimeline.push({ action, timestamp });
      }
    }

    const combinedTimeline = dynamicTimeline;

    return {
      id: api.maYeuCau || '',
      code: api.maYeuCau || '',
      maDatTour: api.maDatTour || '',
      customerName: api.tenKhachHang || '',
      customerPhone: api.soDienThoai || '',
      tourName: api.tenTour || '',
      guideName: api.maNhanVienXuLy || '',
      sentDate: api.thoiDiemTao ? formatDate(api.thoiDiemTao) : '',
      severity: 'THAP',
      status: mapStatus(api.trangThai),
      description: contentStr
        .replace(/\[(Yêu cầu KH bổ sung.*?|Yêu cầu HDV giải trình.*?|KHÁCH HÀNG BỔ SUNG.*?|HDV giải trình.*?)\]:?\s*(.*?)(?=(?:\n)?\[(?:Yêu cầu KH bổ sung|Yêu cầu HDV giải trình|KHÁCH HÀNG BỔ SUNG|HDV giải trình)|$)/gs, '')
        .trim(),
      resolution: savedResolution || undefined,
      timeline: combinedTimeline,
      source: 'complaint',
    };
  };

  const mapIncidentToUI = (api: NhatKySuCoResponse): Complaint => ({
    id: api.maNhatKySuCo || '',
    code: api.maNhatKySuCo || '',
    maDatTour: '',
    maTourThucTe: api.maTour || '',
    customerName: api.hoTenKhachHang || '',
    customerPhone: '',
    tourName: api.tenTour || '',
    guideName: api.maHdvBaoCao,
    sentDate: api.thoiGianBaoCao ? formatDate(api.thoiGianBaoCao) : '',
    severity: (api.mucDo as any) || 'THAP',
    status: 'pending',
    description: api.moTa || '',
    timeline: [],
    source: 'incident',
  });

  const { user } = useAuth();

  const getAll = async () => {
    if (!hasAccess(user?.maVaiTro, 'complaints')) return;
    setLoading(true);
    setError(null);
    try {
      const res = await complaintsService.danhSachTongHopKhieuNaiSuCo({
        page: currentPage - 1,
        size: itemsPerPage,
        search,
        trangThai: selectedStatus,
        mucDo: selectedSeverity
      });

      const mapped = (res?.content || []).map((item: any) => {
        if (item.sourceType === 'complaint' || item.source_type === 'complaint') {
          return mapToUI(item as YeuCauHoTroResponse);
        } else {
          return mapIncidentToUI(item as NhatKySuCoResponse);
        }
      });
      setComplaints(mapped);
      setTotalItems(res?.totalElements || 0);
    } catch (err: unknown) {
      const msg = err instanceof Error ? err.message : 'Lỗi khi tải dữ liệu';
      setError(msg);
    } finally {
      setLoading(false);
    }
  };

  React.useEffect(() => { 
    // Debounce search
    const timer = setTimeout(() => {
      getAll(); 
    }, 300);
    return () => clearTimeout(timer);
  }, [user, currentPage, search, selectedStatus, selectedSeverity]);

  // Reset page to 1 when filters change
  React.useEffect(() => {
    setCurrentPage(1);
  }, [search, selectedStatus, selectedSeverity]);

  const columns: Column<Complaint>[] = [
    {
      key: 'code',
      title: 'Mã KN',
      width: '12%',
      render: (record) => <span className="font-bold text-[#00668A]">{record.code}</span>
    },

    {
      key: 'description',
      title: 'Nội dung',
      width: '33%',
      render: (record) => {
        let content = record.description || '';
        const lines = content.split('\n');
        let subject = '';
        if (lines[0]?.startsWith('Danh mục: ')) lines.shift();
        if (lines[0]?.startsWith('Tiêu đề: ')) {
           subject = lines.shift()?.replace('Tiêu đề: ', '').trim() || '';
        }
        content = lines.join('\n').trim();

        return (
          <div className="flex flex-col" title={record.description}>
            {subject && <span className="font-semibold text-gray-800 text-sm mb-0.5">{subject}</span>}
            <span className="text-sm text-gray-500 line-clamp-1">{content || '—'}</span>
          </div>
        );
      }
    },
    {
      key: 'severity',
      title: 'Mức độ',
      width: '13%',
      render: (record) => {
        const isSOS = record.severity === 'SOS';
        return <Badge label={isSOS ? 'SOS' : 'Thấp'} variant={isSOS ? 'error' : 'warning'} />;
      }
    },
    {
      key: 'status',
      title: 'Trạng thái',
      width: '15%',
      render: (record) => {
        if (record.source === 'incident') {
          return <Badge label="Đã ghi nhận" variant="neutral" />;
        }
        let label = '';
        let variant: 'success' | 'warning' | 'error' | 'info' | 'neutral' = 'info';
        switch (record.status) {
          case 'pending': label = 'Chờ xử lý'; variant = 'info'; break;
          case 'processing': label = 'Đang xử lý'; variant = 'info'; break;
          case 'pending_info': label = 'Chờ bổ sung'; variant = 'warning'; break;
          case 'pending_guide': label = 'Chờ giải trình'; variant = 'warning'; break;
          case 'resolved': label = 'Đã giải quyết'; variant = 'success'; break;
          case 'rejected': label = 'Từ chối'; variant = 'error'; break;
          case 'cancelled': label = 'Đã hủy'; variant = 'neutral'; break;
          default: label = 'Chờ xử lý'; variant = 'info';
        }
        return <Badge label={label} variant={variant as 'success' | 'warning' | 'error' | 'info' | 'neutral'} />;
      }
    },
    {
      key: 'actions',
      title: 'Hành động',
      width: '12%',
      align: 'center',
      render: (record) => {
        if (record.source === 'incident') {
          return (
            <Button
              variant="secondary"
              size="sm"
              onClick={() => handleOpenDrawer(record, 'view')}
              icon={<Eye size={16} />}
            >
              Xem
            </Button>
          );
        }
        const isDone = record.status === 'resolved' || record.status === 'rejected' || record.status === 'cancelled';
        return (
          <Button
            variant={isDone ? 'secondary' : 'primary'}
            size="sm"
            onClick={() => handleOpenDrawer(record, isDone ? 'view' : 'edit')}
            icon={isDone ? <Eye size={16} /> : <ArrowRight size={16} />}
          >
            {isDone ? 'Xem' : 'Xử lý'}
          </Button>
        );
      }
    }
  ];

  const handleOpenDrawer = (complaint: Complaint, mode: 'edit' | 'view') => {
    setSelectedComplaint(complaint);
    setDrawerMode(mode);
    setDrawerOpen(true);
  };

  const handleCloseDrawer = () => {
    setDrawerOpen(false);
    setSelectedComplaint(null);
  };

  const handleComplaintUpdate = async (updatedComplaint: Complaint) => {
    try {
      let apiStatus = '';
      switch (updatedComplaint.status) {
        case 'resolved': apiStatus = 'DA_XU_LY'; break;
        case 'rejected': apiStatus = 'TU_CHOI'; break;
        case 'pending_info': apiStatus = 'CHO_BO_SUNG'; break;
        case 'pending_guide': apiStatus = 'CHO_GIAI_TRINH'; break;
        case 'pending': apiStatus = 'CHUA_XU_LY'; break;
        default: apiStatus = 'CHUA_XU_LY';
      }
      
      const payload: XuLyHoTroRequest = {
        trangThai: apiStatus,
        ghiChu: updatedComplaint.resolution,
      };
      
      if (updatedComplaint.status === 'pending_guide') {
        const lastAction = updatedComplaint.timeline[updatedComplaint.timeline.length - 1]?.action || '';
        const noiDung = lastAction.includes(':') ? lastAction.split(':').slice(1).join(':').trim() : lastAction;
        await complaintsService.yeuCauHdvGiaiTrinh(updatedComplaint.id, noiDung || 'Vui lòng giải trình yêu cầu hỗ trợ này.');
      } else if (updatedComplaint.status === 'pending_info') {
        const lastAction = updatedComplaint.timeline[updatedComplaint.timeline.length - 1]?.action || '';
        const noiDung = lastAction.includes(':') ? lastAction.split(':').slice(1).join(':').trim() : lastAction;
        await complaintsService.yeuCauKhachHangBoSung(updatedComplaint.id, noiDung || 'Vui lòng bổ sung thông tin cho yêu cầu hỗ trợ này.');
      } else {
        await complaintsService.xuLyYeuCauHoTro(updatedComplaint.id, payload);
      }

      if (updatedComplaint.resolution) {
        localStorage.setItem(`complaint_res_${updatedComplaint.id}`, updatedComplaint.resolution);
      }
      setSelectedComplaint(updatedComplaint);
      getAll();
    } catch (err: unknown) {
      const msg = err instanceof Error ? err.message : 'Lỗi khi cập nhật';
      alert('Lỗi: ' + msg);
    }
  };

  return (
    <MainLayout activeMenu="Quản lý Khiếu nại" breadcrumb={[{ label: 'Quản lý Khiếu nại' }]}>
      <div className="mb-6">
        <h1 className="text-2xl font-bold text-[#121C2C]">Danh sách Khiếu nại & Phản hồi</h1>
        {/* <p className="text-gray-500 mt-1">Quản lý và theo dõi tiến độ xử lý khiếu nại từ khách hàng.</p> */}
      </div>

      <div className="bg-white p-6 rounded-xl shadow-sm border border-[#E1F1FF] mb-6 flex flex-wrap gap-4 items-center">
        <div className="flex-1 min-w-[300px]">
          <SearchInput placeholder="Tìm mã khiếu nại, tên khách hàng..." value={search} onChange={setSearch} />
        </div>
        <div className="w-[160px]">
          <Select
            value={selectedSeverity}
            onChange={setSelectedSeverity}
            options={[
              { value: 'all', label: 'Mức độ: Tất cả' },
              { value: 'THAP', label: 'Thấp' },
              { value: 'SOS', label: 'SOS' }
            ]}
          />
        </div>
        <div className="w-[200px]">
          <Select
            value={selectedStatus}
            onChange={setSelectedStatus}
            options={[
              { value: 'all', label: 'Trạng thái: Tất cả' },
              { value: 'pending', label: 'Chờ xử lý' },
              { value: 'pending_info', label: 'Chờ bổ sung' },
              { value: 'pending_guide', label: 'Chờ giải trình' },
              { value: 'resolved', label: 'Đã giải quyết' },
              { value: 'rejected', label: 'Từ chối' }
            ]}
          />
        </div>
      </div>

      <div className="bg-white rounded-xl shadow-sm border border-[#E1F1FF] overflow-hidden relative min-h-[300px]">
        {loading ? (
          <div className="absolute inset-0 flex items-center justify-center bg-white bg-opacity-70 z-10">
            <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-[#00668A]"></div>
          </div>
        ) : error ? (
          <div className="flex items-center justify-center h-full text-red-500 p-8">{error}</div>
        ) : (
          <Table<Complaint> dataSource={complaints} columns={columns} />
        )}
        <div className="p-4 border-t border-[#E1F1FF]">
          <Pagination
            current={currentPage}
            total={totalItems}
            pageSize={itemsPerPage}
            onChange={setCurrentPage}
          />
        </div>
      </div>

      <ComplaintDrawer
        isOpen={drawerOpen}
        onClose={handleCloseDrawer}
        complaint={selectedComplaint}
        mode={drawerMode}
        onUpdate={handleComplaintUpdate}
      />
    </MainLayout>
  );
};

export default ComplaintList;

