<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Laporan Tahun</h2>
    </x-slot>

    <div class="p-8 space-y-4">

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-yellow-500 px-4 py-3">
                <h3 class="font-semibold text-gray-900 text-sm">Laporan Tahun</h3>
            </div>

            <div class="p-4 space-y-4">
                <div class="bg-cyan-50 text-cyan-800 text-sm px-4 py-3 rounded-lg">
                    Data pengunjung yang muncul sesuai dengan tahun yang dipilih.
                </div>

                <form method="GET" class="flex flex-wrap items-end gap-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
                        <select name="tahun" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            @foreach ($tahunTersedia as $t)
                                <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold text-sm px-4 py-2 rounded-lg">
                        Tampilkan
                    </button>
                    @include('laporan._export-menu', [
                        'routeName' => 'laporan.tahunan.pdf',
                        'routeParams' => ['tahun' => $tahun],
                        'excelRouteName' => route('laporan.tahunan.excel', ['tahun' => $tahun]),
                        'pdfColumns' => \App\Http\Controllers\LaporanController::pdfColumnLabels(),
                    ])
                </form>

                @include('laporan._tabel')
            </div>
        </div>

    </div>
</x-app-layout>