import type { Account } from '../../../types/system';

export const allRoles = [
  'Hướng dẫn viên',

  'Quản trị viên',
  'Nhân viên sản phẩm',
  'Nhân viên kinh doanh',
  'Nhân viên điều hành',
  'Nhân viên kế toán',
  'Khách hàng',
];

export const permissionsMap: Record<string, string[]> = {
  'Quản trị viên': [
    'Quản lý tour mẫu',
    'Quản lý tour thực tế',
    'Quản lý đơn hàng',
    'Quản lý khách hàng',
    'Quản lý khiếu nại',
    'Quản lý khuyến mãi',
    'Điều phối HDV',
    'Tài chính kế toán',
    'Quản trị hệ thống',
  ],
  'Nhân viên sản phẩm': [
    'Quản lý tour mẫu',
    'Quản lý tour thực tế',
    'Dịch vụ bổ sung',
    'Hành động xanh',
  ],
  'Nhân viên kinh doanh': [
    'Quản lý đơn hàng',
    'Quản lý khách hàng',
    'Quản lý khuyến mãi',
  ],
  'Nhân viên điều hành': ['Điều phối HDV', 'Quản lý khiếu nại'],
  'Nhân viên kế toán': ['Tài chính kế toán'],
  'Hướng dẫn viên': ['Quản lý tour thực tế'],
  'Khách hàng': [],
};

export const allPermissions = [
  'Quản lý tour mẫu',
  'Quản lý tour thực tế',
  'Quản lý đơn hàng',
  'Quản lý khách hàng',
  'Quản lý khiếu nại',
  'Quản lý khuyến mãi',
  'Điều phối HDV',
  'Tài chính kế toán',
  'Quản trị hệ thống',
];

export const initialAccounts: Account[] = [
  {
    id: '1',
    code: 'TK-001',
    name: 'Nguyễn Văn Admin',
    email: 'admin.nv@travelcorp.com',
    phone: '0901234567',
    username: 'admin',
    role: 'Quản trị viên',
    status: 'active',
  },
  {
    id: '2',
    code: 'TK-002',
    name: 'Trần Thị Kế Toán',
    email: 'ketoan.tt@travelcorp.com',
    phone: '0987654321',
    username: 'ketoan',
    role: 'Nhân viên kế toán',
    status: 'active',
  },
  {
    id: '3',
    code: 'TK-003',
    name: 'Lê Văn Điều Hành',
    email: 'dieuhanh.lv@travelcorp.com',
    phone: '0912345678',
    username: 'dieuhanh',
    role: 'Nhân viên điều hành',
    status: 'locked',
  },
  {
    id: '4',
    code: 'TK-004',
    name: 'Phạm Thị Sản Phẩm',
    email: 'sanpham.pt@travelcorp.com',
    phone: '0933334444',
    username: 'sanpham',
    role: 'Nhân viên sản phẩm',
    status: 'active',
  },
  {
    id: '5',
    code: 'TK-005',
    name: 'Khách Hàng A',
    email: 'khachhang.a@gmail.com',
    phone: '0955556666',
    username: 'khacha',
    role: 'Khách hàng',
    status: 'active',
  },
];
