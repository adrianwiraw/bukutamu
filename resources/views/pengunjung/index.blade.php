<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Daftar Pengunjung</h2>
    </x-slot>

    <div class="p-8 space-y-4">

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

            <div class="bg-yellow-500 px-4 py-3">
                <h3 class="font-semibold text-gray-900 text-sm">Daftar Pengunjung</h3>
            </div>

            <div class="p-4 space-y-4">

                <!-- Kontrol: Show entries & Search -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                    <form method="GET" class="flex items-center gap-2 text-sm text-gray-600">
                        Show
                        <select name="per_page" onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            @foreach ([10, 25, 50, 100] as $jumlah)
                                <option value="{{ $jumlah }}" {{ request('per_page', 10) == $jumlah ? 'selected' : '' }}>{{ $jumlah }}</option>
                            @endforeach
                        </select>
                        entries
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                    </form>

                    <form method="GET" class="flex items-center gap-2">
                        @if (request('per_page'))
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                        @endif
                        <label class="text-sm text-gray-600">Search:</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, instansi, keperluan..."
                               class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <button class="bg-gray-800 text-white text-sm px-3 py-1.5 rounded-lg">Cari</button>
                        @if (request('search'))
                            <a href="{{ route('pengunjung.index') }}" class="text-gray-500 text-sm hover:underline">Reset</a>
                        @endif
                    </form>
                </div>

                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama Pengunjung</th>
                                <th class="px-4 py-3">Alamat/Instansi</th>
                                <th class="px-4 py-3">Keperluan</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Tanggal Datang</th>
                                <th class="px-4 py-3">Jenis Kelamin</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($dataTamu as $index => $tamu)
                                <tr class="hover:bg-yellow-50/50">
                                    <td class="px-4 py-3 text-gray-500">{{ $dataTamu->firstItem() + $index }}</td>
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-gray-900">{{ $tamu->nama }}</p>
                                        <p class="text-xs text-gray-500">{{ $tamu->no_hp ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $tamu->instansi_alamat }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $tamu->keperluan }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $tamu->anda_sendirian === 'Rombongan' ? ($tamu->jumlah_rombongan ?? '-') . ' Orang' : '1 Orang' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $tamu->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $tamu->jenis_kelamin }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <a href="{{ route('pengunjung.edit', $tamu) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg">Edit</a>
                                            <form action="{{ route('pengunjung.destroy', $tamu) }}" method="POST" onsubmit="return confirm('Hapus data pengunjung ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded-lg">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                                        {{ request('search') ? 'Data tidak ditemukan.' : 'Belum ada data pengunjung.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Info & Pagination -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-3 text-sm text-gray-500">
                    <p>
                        Menampilkan {{ $dataTamu->firstItem() ?? 0 }} - {{ $dataTamu->lastItem() ?? 0 }}
                        dari {{ $dataTamu->total() }} data
                    </p>
                    {{ $dataTamu->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>     