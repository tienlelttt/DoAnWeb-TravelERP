export const MENU_KEYS = [
  'dashboard', 'tour-template', 'tour-instance',
  'orders', 'customers', 'complaints', 'promotions',
  'dispatch', 'finance', 'accounts', 'hr', 'logs'
] as const;

export type MenuKey = typeof MENU_KEYS[number];

export const ROLE_MENU_ACCESS: Record<string, string[]> = {
  ADMIN: [...MENU_KEYS],
  SANPHAM: ['tour-template', 'tour-instance'],
  KINHDOANH: ['orders', 'customers', 'complaints', 'promotions'],
  SALES: ['orders', 'customers', 'complaints', 'promotions'],
  DIEUHANH: ['tour-instance', 'dispatch', 'hr'],
  MANAGER: ['tour-instance', 'dispatch', 'hr'],
  KETOAN: ['dashboard', 'orders', 'finance'],
};

export const hasAccess = (role: string | undefined, menuKey: string): boolean => {
  if (!role) {
    return false;
  }

  // Standardize role by removing potential prefixes like "ROLE_"
  const standardizedRole = role.trim().toUpperCase().replace(/^ROLE_/, '');

  if (standardizedRole === 'ADMIN') {
    return true;
  }

  const permissions = ROLE_MENU_ACCESS[standardizedRole];
  if (!permissions) {
    return false;
  }

  if (permissions.includes('*')) {
    return true;
  }

  return permissions.includes(menuKey);
};

export const getRoleLabel = (role: string | undefined): string => {
  if (!role) return 'Không xác định';
  
  const standardizedRole = role.trim().toUpperCase().replace(/^ROLE_/, '');
  
  const labels: Record<string, string> = {
    ADMIN: 'Quản trị viên',
    SANPHAM: 'Sản phẩm',
    KINHDOANH: 'Kinh doanh',
    SALES: 'Sales',
    DIEUHANH: 'Điều hành',
    MANAGER: 'Quản lý',
    KETOAN: 'Kế toán',
  };
  
  return labels[standardizedRole] || standardizedRole;
};
