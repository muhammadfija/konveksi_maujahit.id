@extends('layouts.admin')

@section('title', 'Profil Admin - MauJahit.id')

@section('content')
<div class="p-4 lg:p-6 animate-fade-in-up">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-black text-gray-900">Profil Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Avatar Card --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col items-center text-center h-fit">
            <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-[#1e3a6e] to-[#2b5299] text-white flex items-center justify-center text-4xl font-black shadow-lg mb-4">
                {{ strtoupper(substr($admin->name, 0, 1)) }}
            </div>
            <h3 class="text-lg font-bold text-gray-900">{{ $admin->name }}</h3>
            <p class="text-sm text-gray-400 mt-1">Administrator</p>
            <div class="mt-4 w-full pt-4 border-t border-gray-100">
                <div class="flex items-center justify-center gap-2 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Kode Login: <span class="font-mono font-semibold text-gray-700">{{ $admin->login_code }}</span></span>
                </div>
            </div>
        </div>

        {{-- Right: Edit Form --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h2 class="font-bold text-gray-900">Edit Informasi Akun</h2>
                <p class="text-xs text-gray-400 mt-0.5">Perubahan akan langsung berlaku setelah disimpan.</p>
            </div>

            <form action="{{ url('/admin/profile') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name', $admin->name) }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] focus:bg-white transition-all @error('name') border-red-300 @enderror"
                            required placeholder="Masukkan nama Anda">
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kode Login -->
                    <div>
                        <label for="login_code" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode Login (PIN) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="login_code" name="login_code"
                                value="{{ old('login_code', $admin->login_code) }}"
                                class="w-full px-4 py-3 pr-11 bg-gray-50 border border-gray-200 rounded-xl text-sm font-mono tracking-wider focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]/20 focus:border-[#1e3a6e] focus:bg-white transition-all @error('login_code') border-red-300 @enderror"
                                required placeholder="Masukkan kode login / PIN">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400">Kode ini digunakan sebagai PIN untuk masuk ke sistem admin. Jangan bagikan ke orang lain.</p>
                        @error('login_code')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ url('/admin/dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors rounded-xl hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#1e3a6e] hover:bg-[#132848] text-white text-sm font-semibold rounded-xl transition-all shadow-sm active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
