<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Pengaturan Keperluan</h2>
    </x-slot>

    <div class="p-8 space-y-4">

        @if (session('success'))
            <div class="bg-green-100 text-green-700 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="flex justify-between items-center">
            <form method="GET" class="flex gap-2">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama keperluan..."
                       class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <button class="bg-gray-800 text-white text-sm px-4 py-2 rounded-lg">Cari</button>
            </form>
            <a href="{{ route('keperluan.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold text-sm px-4 py-2 rounded-lg">
                + Tambah Keperluan
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 w-16">No</th>
                        <th class="px-4 py-3">Nama Keperluan</th>
                        <th class="px-4 py-3 w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($keperluans as $index => $item)
                        <tr>
                            <td class="px-4 py-3 text-gray-500">{{ $keperluans->firstItem() + $index }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->nama }}</td>
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('keperluan.edit', $item->getKey()) }}" class="text-blue-600 hover:underline text-xs font-medium">Edit</a>
                                <form action="{{ route('keperluan.destroy', $item->getKey()) }}" method="POST" onsubmit="return confirm('Yakin hapus keperluan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline text-xs font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada data keperluan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $keperluans->links() }}
    </div>
</x-app-layout>