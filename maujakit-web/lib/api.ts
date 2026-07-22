const BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';

async function request<T>(
  path: string,
  options: RequestInit = {}
): Promise<T> {
  const token = typeof window !== 'undefined' ? localStorage.getItem('admin_token') : null;

  const headers: HeadersInit = {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    ...(token ? { Authorization: `Bearer ${token}` } : {}),
    ...options.headers,
  };

  const res = await fetch(`${BASE_URL}${path}`, {
    ...options,
    headers,
  });

  if (!res.ok) {
    const errData = await res.json().catch(() => ({ message: 'Terjadi kesalahan.' }));
    throw new Error(errData.message || `HTTP ${res.status}`);
  }

  return res.json();
}

// ── Auth ────────────────────────────────────────────────────────────────────

export const authApi = {
  login: (login_code: string) =>
    request('/auth/login', {
      method: 'POST',
      body: JSON.stringify({ login_code }),
    }),

  logout: () =>
    request('/auth/logout', { method: 'POST' }),

  me: () => request('/auth/me'),
};

// ── Public Tracking ─────────────────────────────────────────────────────────

export const trackingApi = {
  check: (code: string) =>
    request(`/track/${encodeURIComponent(code)}`),
};

// ── Admin Orders ─────────────────────────────────────────────────────────────

export const ordersApi = {
  list: (params?: { page?: number; status?: string; search?: string; per_page?: number }) => {
    const qs = new URLSearchParams();
    if (params?.page) qs.set('page', String(params.page));
    if (params?.status) qs.set('status', params.status);
    if (params?.search) qs.set('search', params.search);
    if (params?.per_page) qs.set('per_page', String(params.per_page));
    return request(`/admin/orders?${qs}`);
  },

  stats: () => request('/admin/orders/stats'),

  get: (id: number) => request(`/admin/orders/${id}`),

  create: (data: Record<string, unknown>) =>
    request('/admin/orders', {
      method: 'POST',
      body: JSON.stringify(data),
    }),

  update: (id: number, data: Record<string, unknown>) =>
    request(`/admin/orders/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    }),

  delete: (id: number) =>
    request(`/admin/orders/${id}`, { method: 'DELETE' }),

  updateStatus: (id: number, status: string, note?: string) =>
    request(`/admin/orders/${id}/status`, {
      method: 'PUT',
      body: JSON.stringify({ status, note }),
    }),

  uploadPhoto: (id: number, formData: FormData) => {
    const token = typeof window !== 'undefined' ? localStorage.getItem('admin_token') : null;
    return fetch(`${BASE_URL}/admin/orders/${id}/photos`, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        ...(token ? { Authorization: `Bearer ${token}` } : {}),
      },
      body: formData,
    }).then((r) => r.json());
  },
};
