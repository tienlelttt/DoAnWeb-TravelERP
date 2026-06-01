import React from 'react';
import MainLayout from '../../../components/layouts/MainLayout';

const SystemLogList: React.FC = () => {
  return (
    <MainLayout
      activeMenu="Nhật ký hệ thống"
      expandedMenus={["Hệ thống"]}
      breadcrumb={[{ label: 'Hệ thống' }, { label: 'Nhật ký hệ thống' }]}
    >
      <div className="flex flex-col gap-6">
        <h1 className="text-[32px] font-bold text-[#121C2C]">Nhật ký hệ thống</h1>
        <div className="bg-white p-6 rounded-[16px] shadow-[0px_4px_20px_rgba(137,212,255,0.08)]">
          <p className="text-gray-500">Chức năng đang được phát triển...</p>
        </div>
      </div>
    </MainLayout>
  );
};

export default SystemLogList;
