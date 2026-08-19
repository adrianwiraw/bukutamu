<details class="relative">
    <summary class="list-none cursor-pointer bg-gray-800 hover:bg-gray-900 text-white font-semibold text-sm px-4 py-2 rounded-lg">
        Export PDF
    </summary>
    <div class="absolute right-0 z-10 mt-2 w-72 rounded-lg border border-gray-200 bg-white p-3 shadow-lg">
        <div class="space-y-3">
            <fieldset>
                <legend class="mb-2 text-sm font-semibold text-gray-800">Kolom PDF</legend>
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

            <button type="button" data-pdf-export class="w-full rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-900">
                Buat PDF
            </button>
        </div>
    </div>
</details>

<script>
    document.querySelectorAll('[data-pdf-export]').forEach((button) => {
        button.addEventListener('click', () => {
            const menu = button.closest('details');
            const url = new URL(@json(route($routeName, $routeParams)), window.location.origin);
            const columns = Array.from(menu.querySelectorAll('[data-pdf-column]:checked'))
                .map((input) => input.dataset.pdfColumn);
            const table = menu.querySelector('[name="pdf_table"]:checked').value;

            url.searchParams.set('table', table);
            columns.forEach((column) => url.searchParams.append('columns[]', column));
            window.open(url.toString(), '_blank', 'noopener,noreferrer');
        });
    });
</script>