@extends('layouts.main')

@section('title', 'Ulasan Pelanggan')
@section('subtitle', 'Lihat dan berikan ulasan Anda')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="border-t border-gray-200 pt-6 mt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                </svg>
                Berikan Ulasan Anda
            </h3>

            {{-- Tampilkan pesan error validasi di sini --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops! Ada masalah:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tampilkan pesan success atau error dari controller --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('ulasan.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="order_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Pesanan</label>
                    <select id="order_id" name="order_id" class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                        <option value="">-- Pilih Pesanan Anda --</option>
                        {{-- LOOPING PESANAN PENGGUNA DI SINI --}}
                        @foreach($userOrders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                Pesanan {{ $order->nama_paket ?? 'Custom - '.$order->custom_request}} ({{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->format('d F Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('order_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ rating: {{ old('rating', 0) }} }" class="pb-2"> {{-- Pertahankan rating yang dipilih sebelumnya --}}
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="flex items-center space-x-1">
                        <template x-for="i in 5" :key="i">
                            <svg class="w-8 h-8 cursor-pointer transition-colors duration-200"
                                 :class="i <= rating ? 'text-yellow-500' : 'text-gray-300 hover:text-yellow-400'"
                                 @click="rating = i"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.122-6.545L.487 7.41l6.572-.955L10 1l2.941 5.455 6.572.955-4.757 4.635 1.122 6.545L10 15z"/>
                            </svg>
                        </template>
                        <input type="hidden" name="rating" :value="rating">
                    </div>
                    @error('rating')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Komentar Anda</label>
                    <textarea id="comment" name="comment" rows="4" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200" placeholder="Tulis ulasan Anda tentang layanan kami...">{{ old('comment') }}</textarea> {{-- Pertahankan komentar yang ditulis sebelumnya --}}
                    @error('comment')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-lg hover:shadow-xl">
                    Kirim Ulasan
                </button>
            </form>
        </div>
    </div>
@endsection