// Types for MauJahit.id

export type ProductionStatus =
  | 'ORDER_MASUK'
  | 'DP_PELUNASAN'
  | 'DESAIN'
  | 'BELI_BAHAN'
  | 'POTONG'
  | 'JAHIT'
  | 'QC'
  | 'PACKING'
  | 'KIRIM';

export const STATUS_LABELS: Record<ProductionStatus, string> = {
  ORDER_MASUK: 'Order Masuk',
  DP_PELUNASAN: 'DP/Pelunasan',
  DESAIN: 'Desain',
  BELI_BAHAN: 'Beli Bahan',
  POTONG: 'Potong',
  JAHIT: 'Jahit',
  QC: 'QC',
  PACKING: 'Packing',
  KIRIM: 'Kirim',
};

export const ALL_STAGES: ProductionStatus[] = [
  'ORDER_MASUK',
  'DP_PELUNASAN',
  'DESAIN',
  'BELI_BAHAN',
  'POTONG',
  'JAHIT',
  'QC',
  'PACKING',
  'KIRIM',
];

export interface TimelineItem {
  stage: ProductionStatus;
  label: string;
  status: 'done' | 'current' | 'pending';
  date: string | null;
  note: string | null;
  photo_url: string | null;
}

export interface Order {
  id: number;
  tracking_code: string;
  customer_name: string;
  whatsapp: string;
  company_name: string | null;
  product_type: string;
  quantity: number;
  color: string;
  notes: string | null;
  estimated_finish: string;
  current_status: ProductionStatus;
  current_status_label: string;
  progress_percentage: number;
  resi_number: string | null;
  created_at: string;
  updated_at: string;
  timeline?: TimelineItem[];
}

export interface OrdersResponse {
  success: boolean;
  data: {
    data: Order[];
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
    from: number;
    to: number;
  };
}

export interface TrackingResponse {
  success: boolean;
  data: Order;
  message?: string;
}

export interface StatsResponse {
  success: boolean;
  data: {
    total: number;
    in_progress: number;
    completed: number;
    wait_payment: number;
  };
}

export interface Admin {
  id: number;
  name: string;
}

export interface LoginResponse {
  success: boolean;
  message: string;
  data: {
    admin: Admin;
    token: string;
  };
}

export interface CreateOrderPayload {
  customer_name: string;
  whatsapp: string;
  company_name?: string;
  product_type: string;
  quantity: number;
  color: string;
  notes?: string;
  estimated_finish: string;
}
