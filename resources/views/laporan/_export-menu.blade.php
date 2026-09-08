<details class="relative">
    <summary class="list-none cursor-pointer bg-gray-800 hover:bg-gray-900 text-white font-semibold text-sm px-4 py-2 rounded-lg">
        Export
    </summary>
    <div class="absolute right-0 z-50 mt-2 w-72 rounded-lg border border-gray-200 bg-white p-3 shadow-lg">
        <div class="space-y-3">
            <!-- PDF Export Options - hanya tampil untuk laporan selain custom -->
            @if (!isset($isCustom) || !$isCustom)
            <fieldset>
                <legend class="mb-2 text-sm font-semibold text-gray-800">Export PDF - Pilih Kolom</legend>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($pdfColumns as $column => $label)
                        <label class="flex items-center gap-2 text-xs text-gray-700">
                            <input type="checkbox" data-pdf-column="{{ $column }}" checked
                                   class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-500">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <fieldset>
                <legend class="mb-2 text-sm font-semibold text-gray-800">Isi PDF</legend>
                <label class="flex items-center gap-2 text-xs text-gray-700">
                    <input type="radio" name="pdf_table" value="all" checked class="border-gray-300 text-yellow-500 focus:ring-yellow-500">
                    Semua tabel
                </label>
                <label class="mt-1 flex items-center gap-2 text-xs text-gray-700">
                    <input type="radio" name="pdf_table" value="detail" class="border-gray-300 text-yellow-500 focus:ring-yellow-500">
                    Tabel data pengunjung saja
                </label>
            </fieldset>
            @endif

            <div class="flex gap-2">
                <button type="button" data-pdf-export class="flex-1 rounded-md bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-sm font-semibold text-gray-900 transition">
                    📄 PDF
                </button>
                <button type="button" data-excel-export data-excel-route="{{ $excelRouteName ?? '' }}" class="flex-1 rounded-md bg-green-600 hover:bg-green-700 px-3 py-2 text-sm font-semibold text-white transition">
                    📊 Excel
                </button>
            </div>
        </div>
    </div>
</details>

<script>
    document.querySelectorAll('[data-pdf-export]').forEach((button) => {
        button.addEventListener('click', () => {
            const menu = button.closest('details');
            const form = button.closest('form');
            const url = new URL(@json(route($routeName, $routeParams)), window.location.origin);
            const columns = Array.from(menu.querySelectorAll('[data-pdf-column]:checked'))
                .map((input) => input.dataset.pdfColumn);
            const tableRadio = menu.querySelector('[name="pdf_table"]:checked');
            const table = tableRadio ? tableRadio.value : 'all';

            if (form) {
                new FormData(form).forEach((value, key) => url.searchParams.set(key, value));
            }

            if (columns.length > 0) {
                url.searchParams.set('table', table);
                columns.forEach((column) => url.searchParams.append('columns[]', column));
            }
            window.open(url.toString(), '_blank', 'noopener,noreferrer');
        });
    });

    document.querySelectorAll('[data-excel-export]').forEach((button) => {
        button.addEventListener('click', () => {
            const excelRoute = button.getAttribute('data-excel-route');
            if (!excelRoute) {
                alert('Excel export tidak tersedia');
                return;
            }
            const currentUrl = new URL(window.location.href);
            const url = new URL(excelRoute, window.location.origin);
            const form = button.closest('form');

            if (form) {
                new FormData(form).forEach((value, key) => url.searchParams.set(key, value));
            }

            // Preserve existing query parameters
            currentUrl.searchParams.forEach((value, key) => {
                if (!url.searchParams.has(key)) {
                    url.searchParams.set(key, value);
                }
            });

            window.location.href = url.toString();
        });
    });
</script>