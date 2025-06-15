@extends('layouts.main')
@section('title', 'Pesan Jasa')
@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Pesan Jasa Kebersihan</h2>
            <p class="text-gray-600">Pilih paket yang sesuai dengan kebutuhan Anda atau buat permintaan khusus</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Package Selection -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pilih Paket Layanan
                    </h3>
                    
                    <div class="grid md:grid-cols-2 gap-4 mb-6" id="packageSelection">
                        <!-- Paket Pembersihan Ruangan -->
                        <div class="package-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-300 card-hover" data-package="ruangan" data-price="150000" data-name="Bersih Ruangan">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Bersih Ruangan</h4>
                                    <p class="text-primary font-bold">Rp 150.000</p>
                                </div>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Membersihkan lantai</li>
                                <li>• Menyapu dan mengepel</li>
                                <li>• Membersihkan debu</li>
                                <li>• Mengatur barang</li>
                            </ul>
                        </div>

                        <!-- Paket Pembersihan Gudang -->
                        <div class="package-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-300 card-hover" data-package="gudang" data-price="300000" data-name="Bersih Gudang">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 11 5.16-1.26 9-5.45 9-11V7l-10-5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Bersih Gudang</h4>
                                    <p class="text-primary font-bold">Rp 300.000</p>
                                </div>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Pembersihan menyeluruh</li>
                                <li>• Penyortiran barang</li>
                                <li>• Pembersihan debu berat</li>
                                <li>• Pengaturan ulang</li>
                            </ul>
                        </div>

                        <!-- Paket Sapu Mengepel -->
                        <div class="package-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-300 card-hover" data-package="sapu-pel" data-price="75000" data-name="Sapu & Mengepel">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 7h-3V6a4 4 0 0 0-8 0v1H5a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V9h1a1 1 0 0 0 0-2zM10 6a2 2 0 0 1 4 0v1h-4V6zm4 14h-4v-7h4v7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Sapu & Mengepel</h4>
                                    <p class="text-primary font-bold">Rp 75.000</p>
                                </div>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Menyapu lantai</li>
                                <li>• Mengepel dengan pembersih</li>
                                <li>• Membersihkan sudut ruangan</li>
                                <li>• Durasi 1-2 jam</li>
                            </ul>
                        </div>

                        <!-- Paket Cuci Kaca -->
                        <div class="package-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-300 card-hover" data-package="cuci-kaca" data-price="100000" data-name="Cuci Kaca & Jendela">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Cuci Kaca & Jendela</h4>
                                    <p class="text-primary font-bold">Rp 100.000</p>
                                </div>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Cuci kaca dalam & luar</li>
                                <li>• Bersihkan frame jendela</li>
                                <li>• Pembersihan sela-sela</li>
                                <li>• Hasil jernih & bersih</li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <label class="flex items-center">
                            <input type="checkbox" id="customRequest" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                            <span class="ml-2 text-gray-700 font-medium">Saya ingin membuat permintaan khusus</span>
                        </label>
                    </div>
                </div>

                <!-- Custom Request Form -->
                <div class="bg-white rounded-2xl shadow-lg p-6" id="customRequestForm" style="display: none;">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                        </svg>
                        Permintaan Khusus
                    </h3>
                    <textarea id="customRequestText" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200" placeholder="Jelaskan detail permintaan kebersihan Anda..."></textarea>
                    <div id="customRequestImage" class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Gambar (opsional)</label>
                        <input type="file" id="imageInput" accept="image/*" class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                    </div>
                </div>
            </div>

            <!-- Order Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Pemesanan</h3>
                    
                    <form action="{{ route('pesan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="paket_id" id="selectedPackageId" value="{{ old('paket_id') }}">
                        
                        <!-- Selected Package Display -->
                        <div id="selectedPackageDisplay" class="bg-gray-50 rounded-lg p-3 {{ old('paket_id') ? '' : 'hidden' }}">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-800" id="selectedPackageName">{{ old('paket_id') ? 'Paket Terpilih' : '-' }}</p>
                                    <p class="text-sm text-gray-600" id="selectedPackagePrice">{{ old('paket_id') ? 'Rp -' : '-' }}</p>
                                </div>
                                <button type="button" id="removePackage" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lokasi <span class="text-red-500">*</span></label>
                            <input type="text" name="alamat_lokasi" required value="{{ old('alamat_lokasi') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200" placeholder="Masukkan alamat lengkap">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" required value="{{ old('tanggal') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Waktu <span class="text-red-500">*</span></label>
                                <input type="time" name="waktu" required value="{{ old('waktu') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                            </div>
                        </div>

                        <div id="customRequestInput" style="display: {{ old('custom_request') ? 'block' : 'none' }};">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permintaan Khusus</label>
                            <textarea name="custom_request" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200" placeholder="Detail permintaan...">{{ old('custom_request') }}</textarea>
                        </div>

                        <div id="imageUploadInput" style="display: {{ old('custom_request') ? 'block' : 'none' }};">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Gambar (opsional)</label>
                            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-3 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                        </div>

                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-lg hover:shadow-xl">
                            Kirim Pesanan
                        </button>
                    </form>

                    <!-- Estimated Price -->
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
        const customRequestInput = document.getElementById('customRequestInput');
        const imageUploadInput = document.getElementById('imageUploadInput');

        packageCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove previous selection
                packageCards.forEach(c => c.classList.remove('selected-package'));
                
                // Add selection to current card
                this.classList.add('selected-package');
                
                // Update form data
                const packageName = this.dataset.name;
                const packagePrice = this.dataset.price;
                const packageId = this.dataset.package;
                
                selectedPackageId.value = packageId;
                selectedPackageName.textContent = packageName;
                selectedPackagePrice.textContent = `Rp ${parseInt(packagePrice).toLocaleString('id-ID')}`;
                estimatedPrice.textContent = `Rp ${parseInt(packagePrice).toLocaleString('id-ID')}`;
                
                selectedPackageDisplay.classList.remove('hidden');
            });
        });

        removePackageBtn.addEventListener('click', function() {
            packageCards.forEach(c => c.classList.remove('selected-package'));
            selectedPackageDisplay.classList.add('hidden');
            selectedPackageId.value = '';
            estimatedPrice.textContent = 'Rp 0';
        });

        customRequestCheckbox.addEventListener('change', function() {
            if (this.checked) {
                customRequestForm.style.display = 'block';
                customRequestInput.style.display = 'block';
                imageUploadInput.style.display = 'block';
            } else {
                customRequestForm.style.display = 'none';
                customRequestInput.style.display = 'none';
                imageUploadInput.style.display = 'none';
            }
        });

        // Set minimum date to today
        const dateInput = document.querySelector('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const selectedPackage = selectedPackageId.value;
            const customRequest = document.querySelector('textarea[name="custom_request"]').value;
            
            if (!selectedPackage && !customRequest.trim()) {
                e.preventDefault();
                alert('Silakan pilih paket atau isi permintaan khusus!');
                return false;
            }
        });

        // Initialize with old values if any
        @if(old('paket_id'))
            const oldPackageId = '{{ old('paket_id') }}';
            const packageCard = document.querySelector(`[data-package="${oldPackageId}"]`);
            if (packageCard) {
                packageCard.click();
            }
        @endif

        @if(old('custom_request'))
            customRequestCheckbox.checked = true;
            customRequestForm.style.display = 'block';
            customRequestInput.style.display = 'block';
            imageUploadInput.style.display = 'block';
        @endif
    </script>

    <style>
        .card-hover:hover {
            border-color: #0ABAB5;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .selected-package {
            border-color: #0ABAB5;
            background-color: rgba(10, 186, 181, 0.05);
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
        .bg-primary:hover {
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
    </style>
@endsection