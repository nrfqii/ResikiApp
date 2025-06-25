@extends('layouts.main')
@section('title', 'Pesan Jasa')
@section('subtitle', 'Pilih layanan sesuai keperluan anda!')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Pesan Jasa Kebersihan</h2>
            <p class="text-gray-600">Pilih paket yang sesuai dengan kebutuhan Anda atau buat permintaan khusus</p>
        </div>

        @if (session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="orderForm" action="{{ route('pesan.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pilih Paket Layanan
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4 mb-6" id="packageSelection">
                            @forelse($paketJasas as $paket)
                                <div class="package-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-300 card-hover"
                                    data-package-id="{{ $paket->id }}" data-package-price="{{ $paket->harga }}"
                                    data-package-name="{{ $paket->nama_paket }}">
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="w-12 h-12 rounded-lg flex items-center justify-center mr-3
                                        @if (stripos($paket->nama_paket, 'ruangan') !== false) bg-blue-100 text-blue-600
                                        @elseif(stripos($paket->nama_paket, 'gudang') !== false) bg-orange-100 text-orange-600
                                        @elseif(stripos($paket->nama_paket, 'sapu') !== false || stripos($paket->nama_paket, 'pel') !== false) bg-green-100 text-green-600
                                        @elseif(stripos($paket->nama_paket, 'kaca') !== false || stripos($paket->nama_paket, 'jendela') !== false) bg-purple-100 text-purple-600
                                        @elseif(stripos($paket->nama_paket, 'kamar mandi') !== false || stripos($paket->nama_paket, 'toilet') !== false) bg-cyan-100 text-cyan-600
                                        @elseif(stripos($paket->nama_paket, 'dapur') !== false) bg-red-100 text-red-600
                                        @elseif(stripos($paket->nama_paket, 'taman') !== false || stripos($paket->nama_paket, 'halaman') !== false) bg-emerald-100 text-emerald-600
                                        @elseif(stripos($paket->nama_paket, 'furniture') !== false || stripos($paket->nama_paket, 'mebel') !== false) bg-amber-100 text-amber-600
                                        @elseif(stripos($paket->nama_paket, 'general') !== false || stripos($paket->nama_paket, 'umum') !== false) bg-indigo-100 text-indigo-600
                                        @else bg-gray-100 text-gray-600 @endif
                                    ">
                                            {{-- Icons based on service type --}}
                                            @if (stripos($paket->nama_paket, 'ruangan') !== false)
                                                {{-- Room cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm0 2.5l6 6V19h-2v-6H8v6H6v-7.5l6-6z" />
                                                </svg>
                                            @elseif(stripos($paket->nama_paket, 'gudang') !== false)
                                                {{-- Warehouse cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2L2 7v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7L12 2zm6 15H6v-8l6-3 6 3v8z" />
                                                </svg>
                                            @elseif(stripos($paket->nama_paket, 'sapu') !== false || stripos($paket->nama_paket, 'pel') !== false)
                                                {{-- Sweeping and mopping icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M19.36 2.72L20.78 4.14l-1.42 1.42c-.45-.51-1.12-.75-1.74-.49L6.5 9.5c-.69.26-1.04 1.03-.78 1.72L7.14 14l-4.92 4.92c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0L8.56 15.3c.69.26 1.46-.09 1.72-.78l4.43-11.12c.26-.62.02-1.29-.49-1.74l1.42-1.42zM9.5 10.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5z" />
                                                </svg>
                                            @elseif(stripos($paket->nama_paket, 'kaca') !== false || stripos($paket->nama_paket, 'jendela') !== false)
                                                {{-- Window cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM11 19H4V5h7v14zm9 0h-7V5h7v14zm-6-12h4v2h-4V7zm0 4h4v2h-4v-2z" />
                                                </svg>
                                            @elseif(stripos($paket->nama_paket, 'kamar mandi') !== false || stripos($paket->nama_paket, 'toilet') !== false)
                                                {{-- Bathroom cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M6,2V8H4V7H2V8C2,9.11 2.89,10 4,10H6C7.11,10 8,9.11 8,8V7H6V2M9,12A3,3 0 0,1 12,9A3,3 0 0,1 15,9A3,3 0 0,1 18,12V13H22V20C22,21.11 21.11,22 20,22H4C2.89,22 2,21.11 2,20V13H6V12A3,3 0 0,1 9,12M12,11A1,1 0 0,0 11,12V13H13V12A1,1 0 0,0 12,11Z" />
                                                </svg>
                                            @elseif(stripos($paket->nama_paket, 'dapur') !== false)
                                                {{-- Kitchen cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M18,3H6A3,3 0 0,0 3,6V18A3,3 0 0,0 6,21H18A3,3 0 0,0 21,18V6A3,3 0 0,0 18,3M18,19H6A1,1 0 0,1 5,18V8H19V18A1,1 0 0,1 18,19M19,6H5V6A1,1 0 0,1 6,5H18A1,1 0 0,1 19,6M12,10A2,2 0 0,0 10,12A2,2 0 0,0 12,14A2,2 0 0,0 14,12A2,2 0 0,0 12,10Z" />
                                                </svg>
                                            @elseif(stripos($paket->nama_paket, 'taman') !== false || stripos($paket->nama_paket, 'halaman') !== false)
                                                {{-- Garden/yard cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M15.4,9.02L16.78,10.4L12,15.18L7.22,10.4L8.6,9.02L12,12.42L15.4,9.02Z" />
                                                </svg>
                                            @elseif(stripos($paket->nama_paket, 'furniture') !== false || stripos($paket->nama_paket, 'mebel') !== false)
                                                {{-- Furniture cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M3,9V15H4V19H6V15H18V19H20V15H21V9H3M5,11H8V13H5V11M10,11H14V13H10V11M16,11H19V13H16V11Z" />
                                                </svg>
                                            @elseif(stripos($paket->nama_paket, 'general') !== false || stripos($paket->nama_paket, 'umum') !== false)
                                                {{-- General cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M19.36,2.72L20.78,4.14L12,12.92L3.22,4.14L4.64,2.72L12,10.08L19.36,2.72M6,16V18H18V16C18,15.65 17.9,15.31 17.71,15.03L16.83,13.86C16.28,13.12 15.39,12.68 14.45,12.68H9.55C8.61,12.68 7.72,13.12 7.17,13.86L6.29,15.03C6.1,15.31 6,15.65 6,16Z" />
                                                </svg>
                                            @else
                                                {{-- Default cleaning icon --}}
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,6H13V14H11V6M11,16H13V18H11V16Z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $paket->nama_paket }}</h4>
                                            <p class="text-primary font-bold">Rp
                                                {{ number_format($paket->harga, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                    <ul class="text-sm text-gray-600 space-y-1">
                                        {{-- Display service description as list items (example based on your request) --}}
                                        @if (stripos($paket->nama_paket, 'kaca') !== false || stripos($paket->nama_paket, 'jendela') !== false)
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Cuci kaca dalam & luar
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Bersihkan frame jendela
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Pembersihan sela-sela
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Hasil jernih & bersih
                                            </li>
                                        @elseif(stripos($paket->nama_paket, 'ruangan') !== false)
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Sapu & Pel Lantai
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Bersihkan Debu
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Rapikan Barang
                                            </li>
                                        @elseif(stripos($paket->nama_paket, 'kamar mandi') !== false || stripos($paket->nama_paket, 'toilet') !== false)
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Sikat Toilet & Wastafel
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Pel Lantai Kamar Mandi
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Bersihkan Kaca Cermin
                                            </li>
                                        @elseif(stripos($paket->nama_paket, 'dapur') !== false)
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Bersihkan Meja Dapur
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Cuci Piring (Opsional)
                                            </li>
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Buang Sampah Dapur
                                            </li>
                                            {{-- Add more elseif blocks for other specific package types --}}
                                        @else
                                            {{-- Default description if no specific match or if $paket->deskripsi exists --}}
                                            @if ($paket->deskripsi)
                                                @foreach (explode("\n", $paket->deskripsi) as $item)
                                                    @if (trim($item))
                                                        <li class="flex items-center">
                                                            <svg class="w-3 h-3 text-green-500 mr-2 flex-shrink-0"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            {{ str_replace('•', '', trim($item)) }}
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li class="flex items-center text-gray-500">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2 flex-shrink-0"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Tidak ada deskripsi untuk paket ini
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            @empty
                                <div class="col-span-2 text-center p-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,6H13V14H11V6M11,16H13V18H11V16Z" />
                                    </svg>
                                    <p class="text-gray-600">Tidak ada paket jasa yang tersedia saat ini</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="border-t pt-4">
                            <label class="flex items-center">
                                <input type="checkbox" id="customRequest"
                                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                                <span class="ml-2 text-gray-700 font-medium">Saya ingin membuat permintaan khusus</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6" id="customRequestForm"
                        style="display: {{ old('is_custom_request') == 1 ? 'block' : 'none' }};">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Permintaan Khusus
                        </h3>
                        <textarea id="customRequestText" name="custom_request" rows="4"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200"
                            placeholder="Jelaskan detail permintaan kebersihan Anda...">{{ old('custom_request') }}</textarea>
                        <div id="customRequestImage" class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Gambar (opsional)</label>
                            <input type="file" id="imageInput" name="image" accept="image/*"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Pemesanan</h3>

                        <form id="orderForm" action="{{ route('pesan.store') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <input type="hidden" name="paket_id" id="selectedPackageId" value="{{ old('paket_id') }}">
                            <input type="hidden" name="is_custom_request" id="isCustomRequest"
                                value="{{ old('is_custom_request', 0) }}">

                            <div id="selectedPackageDisplay"
                                class="bg-gray-50 rounded-lg p-3 {{ old('paket_id') ? '' : 'hidden' }}">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-800" id="selectedPackageName">
                                            {{ old('paket_id') ? 'Paket Terpilih' : '-' }}</p>
                                        <p class="text-sm text-gray-600" id="selectedPackagePrice">
                                            {{ old('paket_id') ? 'Rp -' : '-' }}</p>
                                    </div>
                                    <button type="button" id="removePackage" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lokasi <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="alamat_lokasi" required value="{{ old('alamat_lokasi') }}"
                                    class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200"
                                    placeholder="Masukkan alamat lengkap">
                            </div>
                            <div id="map" class="h-64 mb-4 rounded-lg"></div>

                            <input type="hidden" id="lat" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="lng" name="longitude" value="{{ old('longitude') }}">


                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal" required value="{{ old('tanggal') }}"
                                        class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu <span
                                            class="text-red-500">*</span></label>
                                    <input type="time" name="waktu" required value="{{ old('waktu') }}"
                                        class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                                </div>
                            </div>

                            {{-- Hidden inputs for custom request details, will be populated by JS --}}
                            <div id="customRequestFormInputs"
                                style="display: {{ old('is_custom_request') == 1 ? 'block' : 'none' }};">
                                <input type="hidden" name="custom_request" id="hiddenCustomRequestText">
                                <input type="hidden" name="custom_image_uploaded" id="hiddenCustomImageUploaded">
                                {{-- To track if an image was selected --}}
                            </div>
                            <br>
                            <button type="button" id="submitOrderBtn"
                                class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-lg hover:shadow-xl">
                                Kirim Pesanan
                            </button>
                        </form>

                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Estimasi Biaya:</span>
                                <span class="font-bold text-primary" id="estimatedPrice">Rp 0</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">*Harga dapat berubah sesuai kondisi lapangan</p>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div id="confirmationModal"
        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-8 max-w-sm mx-auto shadow-xl">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Konfirmasi Pesanan</h3>
            <p class="text-gray-700 mb-6">Anda yakin ingin mengirim pesanan ini?</p>
            <div class="flex justify-end space-x-4">
                <button type="button" id="cancelOrderBtn"
                    class="px-6 py-2 rounded-lg text-gray-600 border border-gray-300 hover:bg-gray-100 transition duration-200">Batal</button>
                <button type="button" id="confirmOrderBtn"
                    class="px-6 py-2 rounded-lg bg-primary text-white hover:bg-primary-dark transition duration-200">Ya,
                    Kirim</button>
            </div>
        </div>
    </div>

    <script>
        // Package selection functionality
        const packageCards = document.querySelectorAll('.package-card');
        const selectedPackageDisplay = document.getElementById('selectedPackageDisplay');
        const selectedPackageId = document.getElementById('selectedPackageId');
        const selectedPackageName = document.getElementById('selectedPackageName');
        const selectedPackagePrice = document.getElementById('selectedPackagePrice');
        const estimatedPrice = document.getElementById('estimatedPrice');
        const removePackageBtn = document.getElementById('removePackage');

        // Custom request functionality
        const customRequestCheckbox = document.getElementById('customRequest');
        const customRequestForm = document.getElementById('customRequestForm');
        const customRequestTextarea = document.getElementById('customRequestText');
        const imageInput = document.getElementById('imageInput');
        const isCustomRequestInput = document.getElementById('isCustomRequest'); // Hidden input untuk status custom request

        // Modal elements
        const confirmationModal = document.getElementById('confirmationModal');
        const submitOrderBtn = document.getElementById('submitOrderBtn');
        const cancelOrderBtn = document.getElementById('cancelOrderBtn');
        const confirmOrderBtn = document.getElementById('confirmOrderBtn');
        const orderForm = document.getElementById('orderForm');

        // Set minimum date to today
        const dateInput = document.querySelector('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;

        // Function to format currency
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Function to update estimated price
        function updateEstimatedPrice() {
            const packagePrice = selectedPackageId.value ? parseInt(document.querySelector(
                `[data-package-id="${selectedPackageId.value}"]`).dataset.packagePrice) : 0;
            // Jika custom request dicentang, harga awal tetap 0 (atau harga paket jika ada)
            // Karena custom request tidak mengubah harga otomatis dari sisi frontend
            estimatedPrice.textContent = formatRupiah(packagePrice);
        }

        // Event listener for package card clicks
        packageCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove previous selection visual from other cards
                packageCards.forEach(c => c.classList.remove('selected-package'));

                // Add selection visual to current card
                this.classList.add('selected-package');

                // Update form data with selected package details
                const packageId = this.dataset.packageId;
                const packageName = this.dataset.packageName;
                const packagePrice = this.dataset.packagePrice;

                selectedPackageId.value = packageId;
                selectedPackageName.textContent = packageName;
                selectedPackagePrice.textContent = formatRupiah(parseInt(packagePrice));

                updateEstimatedPrice(); // Update estimated price based on package selection

                selectedPackageDisplay.classList.remove('hidden');

                // Tidak ada perubahan pada customRequestCheckbox atau form-nya di sini
                // isCustomRequestInput tetap mencerminkan status checkbox
                isCustomRequestInput.value = customRequestCheckbox.checked ? 1 : 0;
            });
        });

        // Event listener for removing selected package
        removePackageBtn.addEventListener('click', function() {
            packageCards.forEach(c => c.classList.remove('selected-package'));
            selectedPackageDisplay.classList.add('hidden');
            selectedPackageId.value = '';
            updateEstimatedPrice
                (); // Update estimated price after removing package (akan jadi 0 jika tidak ada custom request)
        });

        // Event listener for custom request checkbox
        customRequestCheckbox.addEventListener('change', function() {
            if (this.checked) {
                customRequestForm.style.display = 'block';
                isCustomRequestInput.value = 1; // Set ke custom request
                // Tidak ada perubahan pada paket yang dipilih atau harganya di sini
                updateEstimatedPrice(); // Update estimated price (akan menampilkan harga paket jika ada, atau 0)
            } else {
                customRequestForm.style.display = 'none';
                customRequestTextarea.value = ''; // Clear textarea when unchecked
                imageInput.value = ''; // Clear file input when unchecked
                isCustomRequestInput.value = 0; // Set to not custom request
                updateEstimatedPrice(); // Update estimated price (akan menampilkan harga paket jika ada, atau 0)
            }
        });

        // Handle form submission via modal
        submitOrderBtn.addEventListener('click', function() {
            // Validasi client-side
            const alamatLokasi = document.querySelector('input[name="alamat_lokasi"]').value.trim();
            const tanggal = document.querySelector('input[name="tanggal"]').value;
            const waktu = document.querySelector('input[name="waktu"]').value;
            const selectedPackage = selectedPackageId.value;
            const isCustomChecked = customRequestCheckbox.checked;
            const customRequestDetail = customRequestTextarea.value.trim();
            const hasImage = imageInput.files.length > 0;

            // Validasi field wajib
            if (!alamatLokasi || !tanggal || !waktu) {
                alert('Harap lengkapi semua data yang wajib diisi (Alamat Lokasi, Tanggal, Waktu).');
                return;
            }

            // Validasi paket atau custom request
            if (!selectedPackage && !isCustomChecked) {
                alert('Silakan pilih paket layanan atau centang "Permintaan Khusus".');
                return;
            }

            // Jika custom request dicentang tapi tidak ada detail
            if (isCustomChecked && !customRequestDetail && !hasImage) {
                alert('Harap isi detail permintaan khusus (teks atau gambar) jika memilih permintaan khusus.');
                return;
            }

            // Set nilai hidden fields sebelum submit
            if (isCustomChecked) {
                document.getElementById('hiddenCustomRequestText').value = customRequestDetail;
                document.getElementById('hiddenCustomImageUploaded').value = hasImage ? '1' : '0';
            }

            confirmationModal.classList.remove('hidden');
        });

        cancelOrderBtn.addEventListener('click', function() {
            confirmationModal.classList.add('hidden');
        });

        confirmOrderBtn.addEventListener('click', function() {
            confirmationModal.classList.add('hidden');
            orderForm.submit();
        });

        // Auto-hide success alert
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 1s ease-out';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 1000); // Remove after fade out
            }, 5000); // Hide after 5 seconds
        }

        // Initialize with old values if any (for package selection and custom request)
        // Pastikan status checkbox custom request terisi kembali
        @if (old('is_custom_request_checkbox') == 1) // Sesuaikan nama input checkbox jika berbeda
            customRequestCheckbox.checked = true;
            customRequestForm.style.display = 'block';
            isCustomRequestInput.value = 1;
            // Tidak perlu mengosongkan paket di sini, karena bisa koeksisten
        @endif

        // Isi ulang custom_request_detail jika ada validasi error
        @if (old('custom_request'))
            customRequestTextarea.value = '{{ old('custom_request') }}';
            // Pastikan form custom request terlihat jika ada old custom_request
            customRequestForm.style.display = 'block';
            customRequestCheckbox.checked = true;
            isCustomRequestInput.value = 1;
        @endif

        @if (old('paket_id'))
            const oldPackageId = '{{ old('paket_id') }}';
            const packageCard = document.querySelector(`[data-package-id="${oldPackageId}"]`);
            if (packageCard) {
                packageCard.classList.add('selected-package');
                selectedPackageId.value = oldPackageId;
                selectedPackageName.textContent = packageCard.dataset.packageName;
                selectedPackagePrice.textContent = formatRupiah(parseInt(packageCard.dataset.packagePrice));
                // Update estimated price based on restored package
                updateEstimatedPrice();
                selectedPackageDisplay.classList.remove('hidden');
            }
        @endif

        // Panggil updateEstimatedPrice saat halaman dimuat untuk menampilkan harga yang benar
        // jika ada data old() yang mengisi paket atau custom request
        updateEstimatedPrice();
    </script>

    <style>
        /* Enhanced styling for service cards */
        .card-hover:hover {
            border-color: #0ABAB5;
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(10, 186, 181, 0.15);
        }

        .selected-package {
            border-color: #0ABAB5;
            background-color: rgba(10, 186, 181, 0.08);
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(10, 186, 181, 0.12);
        }

        .package-card {
            position: relative;
            overflow: hidden;
        }

        .package-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .package-card:hover::before {
            left: 100%;
        }

        input[type="file"] {
            cursor: pointer;
        }

        .text-primary {
            color: #0ABAB5;
        }

        .bg-primary {
            background-color: #0ABAB5;
        }

        .bg-primary:hover,
        .bg-primary-dark {
            background-color: #089490;
        }

        .border-primary {
            border-color: #0ABAB5;
        }

        .focus\:border-primary:focus {
            border-color: #0ABAB5;
        }

        .focus\:ring-primary:focus {
            --tw-ring-color: rgba(10, 186, 181, 0.5);
        }

        /* Animation for service icons */
        .package-card:hover .w-12 {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        /* Smooth transitions for all interactive elements */
        .package-card,
        .package-card .w-12,
        button,
        input,
        textarea {
            transition: all 0.3s ease;
        }

        /* Enhanced button styling */
        #submitOrderBtn:hover {
            box-shadow: 0 8px 25px rgba(10, 186, 181, 0.3);
        }

        /* Improved list styling */
        .package-card ul li {
            display: flex;
            align-items: flex-start;
            line-height: 1.4;
        }

        .package-card ul li svg {
            margin-top: 2px;
        }
    </style>
@endsection
