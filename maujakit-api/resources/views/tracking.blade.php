@extends('layouts.app')

@section('title', 'Cek Progres Pesanan - MauJahit.id')

@section('content')
<div x-data="trackingApp()" class="min-h-screen flex flex-col bg-gray-50">
  <!-- Hero & Search -->
  <section class="relative bg-[#0d1f3c] text-white overflow-hidden">
    <div class="absolute inset-0">
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMyMDQwNzAiIGZpbGwtb3BhY2l0eT0iMC4xNSI+PHBhdGggZD0iTTM2IDM0djZoNnYtNmgtNnptMCAwdjZoNnYtNmg2em0tNiAwdjZoNnYtNmgtNnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
      <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 left-0 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="text-center mb-10">
        <h1 class="text-4xl lg:text-5xl font-black mb-4 leading-tight">
          Cek Progres Pesanan Anda
        </h1>
        <p class="text-white/70 text-lg max-w-xl mx-auto">
          Pantau setiap tahap produksi pesanan Anda secara real-time dan transparan.
        </p>
      </div>

      <!-- Search Box -->
      <div class="bg-white rounded-2xl p-8 shadow-2xl max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-2">
          <div class="w-10 h-10 bg-[#1e3a6e] rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-gray-900">Masukkan Kode Tracking</h2>
            <p class="text-xs text-gray-400">Masukkan kode tracking yang telah diberikan oleh admin kami.</p>
          </div>
        </div>

        <form @submit.prevent="checkTracking" class="mt-5">
          <input
            type="text"
            x-model="code"
            @input="code = code.toUpperCase()"
            placeholder="Contoh: MJK-9X2L7Q"
            class="w-full border border-gray-200 rounded-xl px-4 py-3.5 text-gray-800 text-base font-medium focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-transparent placeholder:text-gray-300 tracking-wider"
            autocomplete="off"
          />
          <button
            type="submit"
            :disabled="loading || code.trim() === ''"
            class="w-full mt-3 bg-[#1e3a6e] hover:bg-[#132848] disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-base"
          >
            <template x-if="loading">
              <div class="flex items-center gap-2">
                <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full spinner"></div>
                Memverifikasi...
              </div>
            </template>
            <template x-if="!loading">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cek Progres
              </div>
            </template>
          </button>
        </form>

        <div class="mt-4 flex items-center gap-2 justify-center text-xs text-gray-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
          Data pesanan Anda aman dan hanya dapat diakses dengan kode tracking.
        </div>
      </div>
    </div>
  </section>

  <!-- Result Area -->
  <div class="max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Error -->
    <template x-if="error">
      <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-6 flex items-start gap-4 animate-fade-in-up">
        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
          <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
        </div>
        <div>
          <h3 class="font-bold text-red-800 mb-1">Kode Tracking Tidak Ditemukan</h3>
          <p class="text-red-600 text-sm" x-text="error"></p>
        </div>
      </div>
    </template>

    <!-- Order Result -->
    <template x-if="order">
      <div class="animate-fade-in-up">
        <!-- Success header -->
        <div class="flex items-center gap-3 mb-6">
          <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <div>
            <h2 class="text-xl font-black text-gray-900">Kode Tracking Ditemukan!</h2>
            <p class="text-gray-500 text-sm">Berikut adalah progres pesanan Anda.</p>
          </div>
        </div>

        <!-- Tracking summary bar -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
          <div class="grid grid-cols-2 lg:grid-cols-4 divide-x divide-y lg:divide-y-0 divide-gray-100">
            <div class="p-5">
              <div class="flex items-center gap-2 mb-1">
                <div class="w-8 h-8 bg-[#1e3a6e] rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                  </svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Kode Tracking</span>
              </div>
              <div class="text-xl font-black text-[#1e3a6e]" x-text="order.tracking_code"></div>
              <div class="text-xs text-gray-400">Dibuat pada <span x-text="order.created_at"></span></div>
            </div>
            <div class="p-5">
              <div class="flex items-center gap-1 text-xs text-gray-400 font-medium mb-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Tanggal Pesan
              </div>
              <div class="font-bold text-gray-800" x-text="order.created_at"></div>
            </div>
            <div class="p-5">
              <div class="flex items-center gap-1 text-xs text-gray-400 font-medium mb-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Estimasi Selesai
              </div>
              <div class="font-bold text-gray-800" x-text="order.estimated_finish"></div>
            </div>
            <div class="p-5 bg-[#1e3a6e] text-white">
              <div class="text-xs text-white/60 font-medium mb-1">Status Saat Ini</div>
              <div class="flex items-center gap-2">
                <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                </svg>
                <div>
                  <div class="font-black text-lg leading-tight" x-text="order.current_status_label"></div>
                  <div class="text-white/60 text-xs"><span x-text="order.progress_percentage"></span>% Selesai</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Details + Timeline -->
        <div class="grid lg:grid-cols-5 gap-6">
          <!-- Order Info -->
          <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-5 text-base">Informasi Pesanan</h3>
            <dl class="space-y-4">
              
              <div class="flex items-start gap-3">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <div class="min-w-0">
                  <dt class="text-xs text-gray-400 mb-0.5">Nama Pemesan</dt>
                  <dd class="text-sm font-semibold text-gray-800 break-words" x-text="order.company_name || order.customer_name"></dd>
                </div>
              </div>

              <div class="flex items-start gap-3">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <div class="min-w-0">
                  <dt class="text-xs text-gray-400 mb-0.5">Produk</dt>
                  <dd class="text-sm font-semibold text-gray-800 break-words" x-text="order.product_type"></dd>
                </div>
              </div>

              <div class="flex items-start gap-3">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                </svg>
                <div class="min-w-0">
                  <dt class="text-xs text-gray-400 mb-0.5">Jumlah</dt>
                  <dd class="text-sm font-semibold text-gray-800 break-words" x-text="order.quantity + ' Pcs'"></dd>
                </div>
              </div>

              <div class="flex items-start gap-3">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
                <div class="min-w-0">
                  <dt class="text-xs text-gray-400 mb-0.5">Warna</dt>
                  <dd class="text-sm font-semibold text-gray-800 break-words" x-text="order.color"></dd>
                </div>
              </div>

              <template x-if="order.notes">
                <div class="flex items-start gap-3">
                  <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <div class="min-w-0">
                    <dt class="text-xs text-gray-400 mb-0.5">Catatan</dt>
                    <dd class="text-sm font-semibold text-gray-800 break-words" x-text="order.notes"></dd>
                  </div>
                </div>
              </template>

              <template x-if="order.resi_number">
                <div class="flex items-start gap-3">
                  <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                  </svg>
                  <div class="min-w-0">
                    <dt class="text-xs text-gray-400 mb-0.5">No. Resi</dt>
                    <dd class="text-sm font-semibold text-gray-800 break-words" x-text="order.resi_number"></dd>
                  </div>
                </div>
              </template>
            </dl>
          </div>

          <!-- Timeline -->
          <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-5 text-base">Progres Produksi</h3>
            
            <div class="mb-6">
              <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-600">Progress Produksi</span>
                <span class="text-sm font-bold text-[#1e3a6e]" x-text="order.progress_percentage + '%'"></span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div
                  class="h-3 rounded-full bg-gradient-to-r from-[#1e3a6e] to-[#2e5090] transition-all duration-1000"
                  :style="`width: ${order.progress_percentage}%`"
                ></div>
              </div>
            </div>

            <div class="space-y-1">
              <template x-for="(item, index) in order.timeline" :key="item.stage">
                <div class="relative flex gap-4 pb-4 timeline-item" :class="item.status === 'done' ? 'done' : ''">
                  
                  <div class="flex-shrink-0 relative z-10">
                    <template x-if="item.status === 'done'">
                      <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    </template>
                    <template x-if="item.status === 'current'">
                      <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center shadow-md relative">
                        <svg viewBox="0 0 24 24" class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                        </svg>
                      </div>
                    </template>
                    <template x-if="item.status === 'late'">
                      <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center shadow-md relative">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </div>
                    </template>
                    <template x-if="item.status === 'pending'">
                      <div class="w-8 h-8 rounded-full bg-gray-100 border-2 border-gray-200 flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                      </div>
                    </template>
                  </div>

                  <div class="flex-1 min-w-0 pt-1" :class="item.status === 'pending' ? 'opacity-50' : ''">
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                      <div class="flex items-center gap-2">
                        <span class="text-sm font-bold"
                              :class="item.status === 'done' ? 'text-green-700' : (item.status === 'current' ? 'text-blue-700' : (item.status === 'late' ? 'text-red-700' : 'text-gray-500'))"
                              x-text="item.label">
                        </span>
                        <template x-if="item.status === 'current'">
                          <span class="text-[10px] bg-blue-500 text-white px-2 py-0.5 rounded-full font-medium">
                            Sedang Dikerjakan
                          </span>
                        </template>
                        <template x-if="item.status === 'late'">
                          <span class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-full font-medium">
                            Terlambat
                          </span>
                        </template>
                      </div>
                      <template x-if="item.date">
                        <span class="text-xs text-gray-400 flex-shrink-0" x-text="item.date"></span>
                      </template>
                    </div>
                    <template x-if="item.note">
                      <p class="text-xs text-gray-500 mt-0.5" x-text="item.note"></p>
                    </template>
                    <template x-if="item.photo_url">
                      <div class="mt-2">
                        <img :src="item.photo_url" :alt="'Foto progres ' + item.label" class="h-24 w-auto rounded-lg border border-gray-200 object-cover cursor-pointer hover:opacity-90 transition-opacity">
                      </div>
                    </template>
                  </div>
                </div>
              </template>
            </div>
            
          </div>
        </div>

        <!-- Security notice -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3">
          <svg class="w-5 h-5 text-[#1e3a6e] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
          <div>
            <p class="text-sm font-semibold text-[#1e3a6e]">Data pesanan Anda aman dan hanya dapat diakses dengan kode tracking.</p>
            <p class="text-xs text-blue-600 mt-0.5">Jangan bagikan kode tracking kepada orang lain.</p>
          </div>
        </div>
      </div>
    </template>

    <!-- Idle state -->
    <template x-if="!order && !error && !loading">
      <div class="mt-4">
        <h2 class="text-xl font-black text-gray-800 text-center mb-8">Kenapa Cek Progres di MauJahit.id?</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="text-3xl mb-3">🕐</div>
            <h3 class="font-bold text-gray-800 text-sm mb-1">Real-time Update</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Dapatkan informasi terbaru setiap tahap produksi.</p>
          </div>
          <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="text-3xl mb-3">🔍</div>
            <h3 class="font-bold text-gray-800 text-sm mb-1">Transparan</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Lihat proses produksi dengan jelas dan terbuka.</p>
          </div>
          <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="text-3xl mb-3">🛡️</div>
            <h3 class="font-bold text-gray-800 text-sm mb-1">Aman</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Data pesanan aman dan terjamin kerahasiaannya.</p>
          </div>
          <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="text-3xl mb-3">✨</div>
            <h3 class="font-bold text-gray-800 text-sm mb-1">Mudah</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Cukup masukkan kode tracking dan lihat progresnya.</p>
          </div>
        </div>
      </div>
    </template>
  </div>
</div>

<script>
function trackingApp() {
  return {
    code: '',
    loading: false,
    error: '',
    order: null,
    async checkTracking() {
      const trimmed = this.code.trim().toUpperCase();
      if (!trimmed) return;
      
      this.loading = true;
      this.error = '';
      this.order = null;

      try {
        const response = await fetch(`/api/track/${trimmed}`);
        const result = await response.json();
        
        if (response.ok && result.success) {
          this.order = result.data;
        } else {
          this.error = result.message || 'Kode tracking tidak ditemukan.';
        }
      } catch (error) {
        this.error = 'Tidak dapat terhubung ke server. Coba lagi nanti.';
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>
@endsection
