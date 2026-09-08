<div class="overflow-x-auto">
    <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-200">
            <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Instansi/Alamat</th>
                <th class="px-4 py-3">Keperluan</th>
                <th class="px-4 py-3">Jumlah</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($dataTamu as $index => $tamu)
                <tr class="hover:bg-yellow-50/50">
                    <td class="px-4 py-3 text-gray-500">{{ $dataTamu->firstItem() + $index }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $tamu->nama_pengunjung ?? $tamu->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $tamu->alamat_pengunjung ?? $tamu->instansi_alamat ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $tamu->keperluan_pengunjung ?? $tamu->keperluan ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $tamu->anda_sendirian === 'Rombongan' ? ($tamu->jumlah ?? '-') . ' Orang' : '1 Orang' }}
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ optional($tamu->created)->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $tamu->jenis_kelamin ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">Tidak ada data pengunjung pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex justify-between items-center mt-4 text-sm text-gray-500">
    <p>Menampilkan {{ $dataTamu->firstItem() ?? 0 }} - {{ $dataTamu->lastItem() ?? 0 }} dari {{ $dataTamu->total() }} data</p>
    {{ $dataTamu->links() }}
</div>