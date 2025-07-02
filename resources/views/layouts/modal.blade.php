<div id="orderDetailModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 p-4 z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800">
                Detail Pesanan
            </h3>
            <button onclick="hideOrderDetails()" class="text-gray-400 hover:text-gray-600 transition p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="flex-1 overflow-y-auto p-6">
            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary border-t-transparent"></div>
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="hidden text-center py-12">
                <div class="text-red-500 text-lg font-medium">Gagal memuat detail pesanan. Silakan coba lagi.</div>
            </div>

            <!-- Modal Content -->
            <div id="modalContent" class="hidden space-y-6">
                <!-- Informasi Konsumen dan Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Konsumen:</label>
                        <p id="modalCustomerName" class="text-lg text-gray-800 font-medium"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Status:</label>
                        <span id="modalStatus" class="px-3 py-1 inline-flex text-sm font-semibold rounded-full"></span>
                    </div>
                </div>

                <!-- Petugas -->
                <div id="modalPetugasContainer" class="hidden">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Petugas:</label>
                    <p id="modalPetugasName" class="text-lg text-gray-800"></p>
                </div>

                <!-- Layanan dan Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Layanan:</label>
                        <p id="modalService" class="text-lg text-gray-800"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal & Waktu:</label>
                        <p id="modalDateTime" class="text-lg text-gray-800"></p>
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat:</label>
                    <p id="modalAddress" class="text-lg text-gray-800 leading-relaxed"></p>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Catatan:</label>
                    <p id="modalNotes" class="text-gray-800 italic leading-relaxed"></p>
                </div>

                <!-- Gambar -->
                <div id="modalImageContainer" class="hidden">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Gambar:</label>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <img id="modalImage" class="w-full h-auto max-h-64 object-contain bg-gray-50" alt="Order Image"
                            onerror="this.alt='Gambar tidak tersedia';">
                    </div>
                </div>

                <!-- Peta Lokasi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Peta Lokasi:</label>
                    <div id="lokasiMap" class="w-full h-64 rounded-lg border border-gray-300"></div>
                </div>

                <!-- Ulasan -->
                <div id="modalReviewSection" class="hidden pt-4 border-t mt-6 space-y-3">
                    <h4 class="text-lg font-bold text-gray-800">Ulasan</h4>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Rating:</span>
                        <div id="modalRating" class="flex items-center space-x-1 text-yellow-400"></div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Komentar:</p>
                        <p id="modalComment" class="text-gray-800 italic"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 p-6">
            <div class="flex justify-end">
                <button onclick="hideOrderDetails()"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-semibold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
