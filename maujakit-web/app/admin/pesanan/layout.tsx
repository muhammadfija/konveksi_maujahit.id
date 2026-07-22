'use client';

import AdminDashboardLayout from '@/app/admin/dashboard/layout';

export default function PesananLayout({ children }: { children: React.ReactNode }) {
  return <AdminDashboardLayout>{children}</AdminDashboardLayout>;
}
