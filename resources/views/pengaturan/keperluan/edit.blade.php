<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Keperluan</h2>
    </x-slot>

    <div class="p-8">
        <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-xl">
            <form action="{{ route('keperluan.update', $keperluan->getKey()) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Keperluan</label>
                    <input type="text" name="nama" value="{{ old('nama', $keperluan->nama) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold text-sm px-5 py-2 rounded-lg">Update</button>
                    <a href="{{ route('keperluan.index') }}" class="text-gray-600 text-sm px-5 py-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>