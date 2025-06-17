<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <h4 class="font-medium text-gray-900">Informasi Pesanan</h4>
        <dl class="mt-2 space-y-2">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">ID Pesanan</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">#{{ $order->id }}</dd>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ \Carbon\Carbon::parse($order->tanggal)->format('d M Y') }}</dd>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Waktu</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->waktu }}</dd>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($order->status == 'pending')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Menunggu Konfirmasi
                        </span>
                    @elseif($order->status == 'dikonfirmasi')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            Dikonfirmasi
                        </span>
                    @elseif($order->status == 'diproses')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            Diproses
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            {{ ucfirst($order->status) }}
                        </span>
                    @endif
                </dd>
            </div>
        </dl>
    </div>

    <div>
        <h4 class="font-medium text-gray-900">Informasi Pelanggan</h4>
        <dl class="mt-2 space-y-2">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Nama</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->user->name ?? 'N/A' }}</dd>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->user->phone ?? 'N/A' }}</dd>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->alamat_lokasi ?? 'N/A' }}</dd>
            </div>
        </dl>
    </div>

    <div class="md:col-span-2">
        <h4 class="font-medium text-gray-900">Detail Layanan</h4>
        <div class="mt-2">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h5 class="font-medium">{{ $order->paketJasa->nama_paket ?? 'N/A' }}</h5>
                <p class="text-sm text-gray-600 mt-1">{{ $order->paketJasa->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                <p class="text-sm font-medium mt-2">Harga: Rp {{ number_format($order->paketJasa->harga ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    @if($order->custom_request)
    <div class="md:col-span-2">
        <h4 class="font-medium text-gray-900">Permintaan Khusus</h4>
        <p class="mt-2 text-sm text-gray-600">{{ $order->custom_request }}</p>
    </div>
    @endif

    @if($order->catatan)
    <div class="md:col-span-2">
        <h4 class="font-medium text-gray-900">Catatan Petugas</h4>
        <p class="mt-2 text-sm text-gray-600">{{ $order->catatan }}</p>
    </div>
    @endif
</div>