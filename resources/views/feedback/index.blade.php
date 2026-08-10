<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Semua Feedback
        </h2>
    </x-slot>

    <div class="p-8 space-y-6">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div
                class="bg-linear-to-r from-yellow-500 to-yellow-400 px-5 py-4 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900 text-base">Daftar Semua Feedback</h3>
                    <p class="text-sm text-gray-700">Kelola penilaian, status, dan komentar pengunjung secara terpusat.
                    </p>
                </div>
                <span
                    class="inline-flex items-center rounded-full bg-white/80 px-3 py-1 text-xs font-semibold text-gray-800">
                    {{ $feedbacks->count() }} entri
                </span>
            </div>

            <div class="p-5 space-y-4">
                @forelse ($feedbacks as $feedback)
                    <div class="rounded-xl border border-gray-200 bg-gray-50 shadow-sm" x-data="{ open: false }">
                        <div class="flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="text-base font-semibold text-gray-900">
                                        {{ $feedback->bukuTamu->nama ?? 'Pengunjung' }}
                                    </h4>
                                    <span
                                        class="rounded-full bg-white px-2.5 py-1 text-xs font-medium text-gray-600 border border-gray-200">
                                        {{ ucfirst($feedback->status ?? 'baru') }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm leading-6 text-gray-600">
                                    {{ $feedback->feedback ?: 'Tidak ada komentar.' }}
                                </p>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                <div
                                    class="min-w-45 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="{{ $i <= ($feedback->rating ?? 0) ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                    <p class="mt-2">Tanggal: <span
                                            class="font-medium text-gray-800">{{ optional($feedback->created_at)->format('d M Y H:i') }}</span>
                                    </p>
                                </div>

                                <div class="flex gap-2">
                                    <button type="button" @click="open = !open"
                                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                                        <span x-show="!open">Lihat</span>
                                        <span x-show="open" x-cloak>Tutup</span>
                                    </button>
                                    <form action="{{ route('dashboard.feedback.destroy', $feedback) }}" method="POST"
                                        onsubmit="return confirm('Hapus feedback ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg bg-red-500 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-600">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div x-show="open" x-collapse class="border-t border-gray-200 bg-white p-4">
                            <form action="{{ route('dashboard.feedback.update', $feedback) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div class="grid gap-3 md:grid-cols-3">
                                    <label class="text-sm text-gray-700">
                                        <span class="mb-1 block font-medium">Rating</span>
                                        <select name="rating"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ ($feedback->rating ?? 0) == $i ? 'selected' : '' }}>
                                                    {{ $i }} Bintang
                                                </option>
                                            @endfor
                                        </select>
                                    </label>
                                    <label class="text-sm text-gray-700">
                                        <span class="mb-1 block font-medium">Status</span>
                                        <select name="status"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                            @foreach (['baru', 'diproses', 'selesai'] as $status)
                                                <option value="{{ $status }}" {{ ($feedback->status ?? 'baru') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="text-sm text-gray-700">
                                        <span class="mb-1 block font-medium">Tanggal</span>
                                        <input type="text" value="{{ optional($feedback->created_at)->format('d M Y') }}"
                                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm"
                                            disabled>
                                    </label>
                                </div>
                                <label class="block text-sm text-gray-700">
                                    <span class="mb-1 block font-medium">Komentar</span>
                                    <textarea name="feedback" rows="3"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">{{ old('feedback', $feedback->feedback) }}</textarea>
                                </label>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="rounded-lg bg-yellow-500 px-4 py-2 font-semibold text-gray-900 transition hover:bg-yellow-600">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div
                        class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center text-sm text-gray-600">
                        Belum ada feedback.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>