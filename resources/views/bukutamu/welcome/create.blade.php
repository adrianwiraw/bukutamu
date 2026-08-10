<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Buku Tamu Elektronik - Dinas Arpus Jateng</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #111827;
            min-height: 100vh;
            background: radial-gradient(circle at top left, rgba(254, 240, 138, 0.2), transparent 23%),
                radial-gradient(circle at top right, rgba(250, 204, 21, 0.12), transparent 26%),
                linear-gradient(180deg, #fffef7 0%, #f8fafc 100%);
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            display: inline-block;
            animation: marquee 35s linear infinite;
        }

        /* ===== Animasi entrance ===== */
        @keyframes bg-zoom {
            from {
                transform: scale(1.12);
            }

            to {
                transform: scale(1);
            }
        }

        @keyframes card-enter {
            from {
                opacity: 0;
                transform: translateY(24px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes bar-enter {
            from {
                opacity: 0;
                transform: translateY(-14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes kb-slide-up {
            from {
                transform: translateY(100%);
            }

            to {
                transform: translateY(0);
            }
        }

        .bg-enter {
            animation: bg-zoom 1.4s cubic-bezier(.16, 1, .3, 1) forwards;
        }

        .card-enter {
            opacity: 0;
            animation: card-enter .8s cubic-bezier(.16, 1, .3, 1) forwards;
            animation-delay: .1s;
        }

        .bar-enter {
            opacity: 0;
            animation: bar-enter .6s cubic-bezier(.16, 1, .3, 1) forwards;
            animation-delay: .35s;
        }

        .title-enter {
            opacity: 0;
            animation: fade-up .6s cubic-bezier(.16, 1, .3, 1) forwards;
            animation-delay: .5s;
        }

        .field-enter {
            opacity: 0;
            animation: fade-up .55s cubic-bezier(.16, 1, .3, 1) forwards;
        }

        .btn-enter {
            opacity: 0;
            animation: fade-up .55s cubic-bezier(.16, 1, .3, 1) forwards;
        }

        .back-enter {
            opacity: 0;
            animation: fade-up .5s cubic-bezier(.16, 1, .3, 1) forwards;
        }

        .kb-show {
            animation: kb-slide-up .25s ease-out forwards;
        }

        .kb-input {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            transition: border-color .25s ease, box-shadow .25s ease, transform .25s ease;
            font-size: 1rem;
            line-height: 1.8;
            min-height: 3.5rem;
            border-radius: 1.25rem;
            padding: 1rem 1.1rem;
        }

        .kb-input:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.12);
            outline: none;
        }

        .kb-input::placeholder {
            color: #9ca3af;
        }

        .field-enter label {
            display: block;
            font-size: 0.85rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }

        .field-enter span {
            font-size: 0.8rem;
            font-style: italic;
            color: #dc2626;
        }

        .star-btn {
            width: 3.6rem;
            height: 3.6rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s ease, color .2s ease, background .2s ease;
            background: rgba(249, 250, 251, 0.9);
        }

        .star-btn:hover {
            transform: translateY(-2px);
            color: #f59e0b;
        }

        .btn-enter {
            background: linear-gradient(90deg, #facc15, #f59e0b);
            color: #111827;
            box-shadow: 0 18px 50px rgba(250, 204, 21, 0.24);
            border: none;
            border-radius: 9999px;
            padding: 1.1rem 1.4rem;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .btn-enter:hover {
            transform: translateY(-1px);
            background: linear-gradient(90deg, #fbbf24, #f59e0b);
            box-shadow: 0 22px 60px rgba(250, 204, 21, 0.28);
        }

        .back-enter {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(229, 231, 235, 0.9);
        }

        .card-enter {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(243, 244, 246, 0.9);
            backdrop-filter: blur(18px);
            box-shadow: 0 32px 90px rgba(15, 23, 42, 0.12);
        }

        .bar-enter {
            background: linear-gradient(90deg, #fde68a, #fcd34d);
            border-radius: 9999px;
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.18);
            letter-spacing: 0.02em;
        }

        @media (max-width: 768px) {
            .card-enter {
                padding: 1.5rem;
            }

            .field-enter label {
                font-size: 0.9rem;
            }

            .kb-input {
                font-size: 0.98rem;
            }

            .btn-enter {
                font-size: 1rem;
                padding: 1rem 1.25rem;
            }

            .bar-enter {
                font-size: 1rem;
                padding: 1rem 1.25rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .bg-enter,
            .card-enter,
            .bar-enter,
            .title-enter,
            .field-enter,
            .btn-enter,
            .back-enter,
            .kb-show {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* ===== End animasi entrance ===== */

        #customKeyboard {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #customKeyboard .kb-key {
            background: #27272a;
            border: 1px solid #3f3f46;
            color: #f4f4f5;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 6px;
            transition: all 0.08s ease;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #customKeyboard .kb-key:hover {
            background: #3f3f46;
            border-color: #52525b;
        }

        #customKeyboard .kb-key:active,
        #customKeyboard .kb-key.kb-pressed {
            background: #facc15;
            color: #18181b;
            border-color: #eab308;
            transform: scale(0.96);
        }

        #customKeyboard .kb-key-enter {
            background: #eab308;
            color: #18181b;
            border-color: #ca8a04;
            font-weight: 700;
        }

        #customKeyboard .kb-key-enter:hover {
            background: #facc15;
        }

        #customKeyboard .kb-key-bksp,
        #customKeyboard .kb-key-shift {
            background: #3f3f46;
            color: #f4f4f5;
        }

        /* Tombol keyboard yang dinonaktifkan saat field numerik aktif */
        #customKeyboard .kb-key.kb-disabled {
            opacity: 0.35;
            pointer-events: none;
        }
    </style>
</head>

<body class="relative min-h-screen">

    <!-- Tombol Back -->
    <a href="{{ route('welcome') }}"
        class="back-enter fixed top-14 left-4 z-50 flex items-center gap-3 bg-white/90 hover:bg-white text-gray-900 font-bold text-lg px-6 py-3 rounded-xl shadow-lg transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    <!-- Foto background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <img src="{{ asset('images/darpus.jpg') }}" alt="Gedung Arpus" class="bg-enter w-full h-full object-cover">
    </div>
    <div class="fixed inset-0 bg-black/60 -z-10"></div>

    <!-- Teks berjalan -->
    <div
        class="bg-linear-to-t from-yellow-400 to-yellow-300 text-yellow-900 font-bold text-2xl p-2 px-4 md:p-4 md:px-8 overflow-hidden whitespace-nowrap">
        <span class="animate-marquee">
            Selamat Datang di Dinas Kearsipan dan Perpustakaan Provinsi Jawa Tengah — Mohon isi Buku Tamu Elektronik
            dengan data yang benar
        </span>
    </div>

    <div class="flex items-center justify-center px-4 py-8 pb-40">
        <div class="card-enter bg-white/95 backdrop-blur rounded-2xl shadow-2xl p-6 md:p-8 w-full max-w-3xl">

            <h1 class="title-enter text-center text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">
                BUKU TAMU ELEKTRONIK
            </h1>
            <div class="border-t border-gray-200 my-6"></div>

            <form action="{{ route('bukutamu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
                id="bukuTamuForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- IDENTITAS -->
                    <div class="field-enter" style="animation-delay:.55s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700">
                            IDENTITAS <span class="font-normal italic text-red-600">(Wajib Diisi)</span>
                        </label>
                        <input type="text" name="identitas" required inputmode="none" pattern="[0-9]*" maxlength="20"
                            placeholder="Kartu Tanda Penduduk / SIM / Kartu Pelajar"
                            class="bg-white kb-input-numeric w-full border border-gray-300 rounded-md px-4 p-2 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <!-- NOMOR HP -->
                    <div class="field-enter" style="animation-delay:.6s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            NOMOR HP <span class="font-normal italic text-red-600">(Data akan kami jaga
                                kerahasiaannya)</span>
                        </label>
                        <input type="text" name="no_hp" inputmode="none" pattern="[0-9]*" maxlength="15"
                            placeholder="Nomor yang bisa dihubungi"
                            class="bg-white kb-input kb-input-numeric w-full border border-gray-300 rounded-md px-4 p-2 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <!-- INSTANSI / ALAMAT -->
                    <div class="field-enter" style="animation-delay:.65s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            INSTANSI / ALAMAT <span class="font-normal italic text-red-600">(Wajib Diisi)</span>
                        </label>
                        <input type="text" name="instansi_alamat" required inputmode="none"
                            placeholder="Instansi anda bekerja / Alamat anda"
                            class="bg-white kb-input w-full border border-gray-300 rounded-md px-4 p-2 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <!-- KEPERLUAN -->
                    <div class="field-enter" style="animation-delay:.7s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            KEPERLUAN <span class="font-normal italic text-red-600">(Wajib Diisi)</span>
                        </label>
                        <select name="keperluan" required
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%23374151%27 stroke-width=%272%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25rem;"
                            class="w-full appearance-none border border-gray-300 rounded-md px-4 py-2 text-lg bg-white focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">-- Pilih --</option>
                            @foreach ($keperluans as $item)
                                <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- NAMA -->
                    <div class="field-enter" style="animation-delay:.75s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            NAMA <span class="font-normal italic text-red-600">(Wajib Diisi)</span>
                        </label>
                        <input type="text" name="nama" required inputmode="none" placeholder="Nama Lengkap Anda"
                            class="bg-white kb-input w-full border border-gray-300 rounded-md px-4 p-2 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <!-- PEGAWAI YANG INGIN DITEMUI -->
                    <div class="field-enter" style="animation-delay:.8s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            PEGAWAI YANG INGIN ANDA TEMUI ?
                        </label>
                        <input type="text" name="pegawai_temui" inputmode="none" placeholder="Boleh tidak diisi"
                            class="bg-white kb-input w-full border border-gray-300 rounded-md px-4 p-2 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <!-- JENIS KELAMIN -->
                    <div class="field-enter" style="animation-delay:.85s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            JENIS KELAMIN <span class="font-normal text-red-600">(Wajib Diisi)</span>
                        </label>
                        <div class="flex flex-col gap-3 text-black">
                            <label class="flex items-center gap-4 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" required
                                    class="accent-green-500 w-6 h-6">
                                <span class="text-xl md:text-2xl font-extrabold leading-tight text-black">LAKI -
                                    LAKI</span>
                            </label>
                            <label class="flex items-center gap-4 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" required
                                    class="accent-green-500 w-6 h-6">
                                <span
                                    class="text-xl md:text-2xl font-extrabold leading-tight text-black">PEREMPUAN</span>
                            </label>
                        </div>
                    </div>

                    <!-- ANDA SENDIRIAN -->
                    <div class="field-enter" style="animation-delay:.9s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            ANDA SENDIRIAN ? <span class="font-normal italic text-red-600">(Wajib Diisi)</span>
                        </label>
                        <select name="anda_sendirian" id="anda_sendirian" required
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%23374151%27 stroke-width=%272%27%3e%3cpath d=%27M6 9l6 6 6-6%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25rem;"
                            class="w-full appearance-none border border-gray-300 rounded-md px-4 py-2 text-lg bg-white focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="" selected disabled>-- Pilih --</option>
                            <option value="Hanya saya">Hanya saya</option>
                            <option value="Rombongan">Rombongan ( Lebih dari 1 orang )</option>
                        </select>
                    </div>

                    <!-- USIA -->
                    <div class="field-enter" style="animation-delay:.95s">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            USIA <span class="font-normal italic text-red-600">(Wajib Diisi)</span>
                        </label>
                        <input type="text" name="usia" required inputmode="none" pattern="[0-9]*" maxlength="3"
                            placeholder="Usia Anda"
                            class="bg-white kb-input kb-input-numeric w-full border border-gray-300 rounded-md px-4 p-2 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <!-- SEBUTKAN JUMLAHNYA (muncul kalau Rombongan) -->
                    <div id="jumlah_rombongan_wrapper" class="hidden">
                        <label class="block text-sm md:text-base font-semibold text-gray-700 mb-1 px-4 py-2">
                            SEBUTKAN JUMLAHNYA ? (Orang) <span class="font-normal italic text-red-600">(Wajib
                                Diisi)</span>
                        </label>
                        <input type="text" name="jumlah_rombongan" id="jumlah_rombongan" inputmode="none"
                            pattern="[0-9]*" maxlength="3" placeholder="Contoh: 5"
                            class="bg-white kb-input kb-input-numeric w-full border border-gray-300 rounded-md px-4 p-2 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                </div>

                <button type="submit"
                    class="w-full block bg-linear-to-t from-yellow-400 to-yellow-300 text-yellow-900 p-2 px-4 md:p-4 md:px-8 text-xl md:text-3xl rounded-md font-extrabold border-[1.5px] border-yellow-500 shadow-[0_2.5px_0_#ca8a04] hover:bg-yellow-400 active:scale-98 hover:scale-101 duration-200 transition-all ease-in-out animate-slide-in-bottom text-center whitespace-normal wrap-break-words"
                    style="animation-delay:1.05s">
                    Simpan
                </button>
            </form>

        </div>
    </div>

    @if (session('showFeedbackModal'))
        <div id="successModal" class="fixed inset-0 z-100 flex items-center justify-center bg-black/60 px-4 py-12">
            <div
                class="w-full max-w-md rounded-4xl border border-yellow-200 bg-white/95 p-6 shadow-[0_30px_80px_rgba(15,23,42,0.18)]">
                <div class="flex items-center justify-center mb-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-center text-xl font-bold text-gray-900">Terima kasih!</h3>
                <p class="mt-2 text-center text-sm text-gray-600">Data buku tamu Anda berhasil tersimpan.</p>
                <form action="{{ route('bukutamu.feedback.store') }}" method="POST" class="mt-4 space-y-3">
                    @csrf
                    <div class="flex items-center justify-center gap-3 py-2" id="feedbackStars">
                        <button type="button" class="star-btn text-4xl text-gray-300 transition" data-value="1">★</button>
                        <button type="button" class="star-btn text-4xl text-gray-300 transition" data-value="2">★</button>
                        <button type="button" class="star-btn text-4xl text-gray-300 transition" data-value="3">★</button>
                        <button type="button" class="star-btn text-4xl text-gray-300 transition" data-value="4">★</button>
                        <button type="button" class="star-btn text-4xl text-gray-300 transition" data-value="5">★</button>
                    </div>
                    <input type="hidden" name="feedback_rating" id="feedbackRating" value="">
                    <input type="hidden" name="latest_buku_tamu_id" value="{{ session('latest_buku_tamu_id') }}">
                    <textarea name="feedback_message" rows="3"
                        placeholder="Berikan saran atau feedback singkat untuk kami..."
                        class="bg-white kb-input w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
                        <button type="submit" class="btn-enter w-full sm:w-auto text-center">Kirim Feedback</button>
                        <button type="button" id="closeSuccessModal"
                            class="rounded-full border border-gray-300 px-5 py-3 font-semibold text-gray-700 hover:bg-gray-100 transition">Lewati</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @include('partials.footer')

    <!-- Keyboard virtual custom -->
    <div id="customKeyboard"
        class="hidden fixed bottom-0 left-0 w-full z-50 bg-[#18181b]/95 backdrop-blur border-t border-zinc-700 shadow-2xl py-3 px-4">
        <div class="max-w-3xl mx-auto w-full">
            <div id="kbKeys" class="flex flex-col gap-1.5 w-full"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Toggle jumlah rombongan
            const sendirianSelect = document.getElementById('anda_sendirian');
            const jumlahWrap = document.getElementById('jumlah_rombongan_wrapper');
            const jumlahInput = document.getElementById('jumlah_rombongan');

            sendirianSelect.addEventListener('change', function () {
                if (this.value === 'Rombongan') {
                    jumlahWrap.classList.remove('hidden');
                    jumlahInput.setAttribute('required', 'required');
                } else {
                    jumlahWrap.classList.add('hidden');
                    jumlahInput.removeAttribute('required');
                    jumlahInput.value = '';
                }
            });

            // Batasi hanya angka untuk field numerik (mengantisipasi keyboard fisik / paste)
            document.querySelectorAll('.kb-input-numeric').forEach(input => {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });

            // Custom keyboard
            const kbBox = document.getElementById('customKeyboard');
            const kbKeys = document.getElementById('kbKeys');
            let activeInput = null;
            let isShift = false;

            kbKeys.addEventListener('mousedown', e => e.preventDefault());
            kbKeys.addEventListener('touchstart', e => e.preventDefault(), { passive: false });

            const rows = [
                ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'],
                ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'],
                ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l'],
                ['shift', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'bksp'],
                ['space', 'enter']
            ];

            function isNumericKey(key) {
                return /^[0-9]$/.test(key);
            }

            function isLetterKey(key) {
                return /^[a-z]$/i.test(key);
            }

            function renderKeyboard() {
                kbKeys.innerHTML = '';
                const activeIsNumeric = activeInput && activeInput.classList.contains('kb-input-numeric');

                rows.forEach(rowKeys => {
                    const rowEl = document.createElement('div');
                    rowEl.className = 'flex gap-1.5 w-full justify-center';

                    rowKeys.forEach(key => {
                        const btn = document.createElement('button');
                        btn.type = 'button';

                        let label = key;
                        let extraClass = 'flex-1';
                        let variant = '';

                        if (key === 'space') { label = 'Spasi'; extraClass = 'flex-[6]'; }
                        else if (key === 'enter') { label = 'Selesai'; extraClass = 'flex-[3]'; variant = 'kb-key-enter'; }
                        else if (key === 'bksp') { label = '⌫'; variant = 'kb-key-bksp'; }
                        else if (key === 'shift') { label = '⇧'; variant = 'kb-key-shift'; }
                        else { label = isShift ? key.toUpperCase() : key; }

                        btn.textContent = label;
                        btn.dataset.key = key;
                        btn.className = `kb-key ${variant} ${extraClass} h-11`;

                        // Nonaktifkan tombol huruf/shift/spasi kalau field aktif adalah numerik
                        if (activeIsNumeric && (isLetterKey(key) || key === 'shift' || key === 'space')) {
                            btn.classList.add('kb-disabled');
                        }

                        btn.addEventListener('click', () => handleKey(key, btn));
                        rowEl.appendChild(btn);
                    });

                    kbKeys.appendChild(rowEl);
                });
            }

            function closeKeyboard() {
                kbBox.classList.add('hidden');
                kbBox.classList.remove('kb-show');
                if (activeInput) {
                    activeInput.blur();
                    activeInput = null;
                }
            }

            function handleKey(key, btn) {
                if (!activeInput) return;

                const isNumericField = activeInput.classList.contains('kb-input-numeric');

                // Tolak huruf, shift, dan spasi kalau field numerik
                if (isNumericField && (isLetterKey(key) || key === 'shift' || key === 'space')) {
                    return;
                }

                btn.classList.add('kb-pressed');
                setTimeout(() => btn.classList.remove('kb-pressed'), 100);

                if (key === 'bksp') {
                    activeInput.value = activeInput.value.slice(0, -1);
                } else if (key === 'space') {
                    activeInput.value += ' ';
                } else if (key === 'enter') {
                    closeKeyboard();
                    return;
                } else if (key === 'shift') {
                    isShift = !isShift;
                    renderKeyboard();
                    return;
                } else {
                    activeInput.value += isShift ? key.toUpperCase() : key;
                }

                activeInput.dispatchEvent(new Event('input', { bubbles: true }));
            }

            function adjustFormPosition(input) {
                setTimeout(() => {
                    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            }

            document.querySelectorAll('.kb-input').forEach(input => {
                input.addEventListener('focus', () => {
                    activeInput = input;
                    kbBox.classList.remove('hidden');
                    kbBox.classList.add('kb-show');
                    renderKeyboard();
                    adjustFormPosition(input);
                });
            });

            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('feedbackRating');
            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const value = parseInt(star.dataset.value, 10);
                    ratingInput.value = value;
                    stars.forEach((item, index) => {
                        item.classList.toggle('text-yellow-500', index < value);
                        item.classList.toggle('text-gray-300', index >= value);
                    });
                });
            });

            const form = document.getElementById('bukuTamuForm');
            const successModal = document.getElementById('successModal');
            const closeSuccessModal = document.getElementById('closeSuccessModal');

            form.addEventListener('submit', function () {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Menyimpan...';
                }
            });

            if (successModal) {
                if (closeSuccessModal) {
                    closeSuccessModal.addEventListener('click', () => {
                        successModal.classList.add('hidden');
                        successModal.classList.remove('flex');
                    });
                }

                successModal.addEventListener('click', (event) => {
                    if (event.target === successModal) {
                        successModal.classList.add('hidden');
                        successModal.classList.remove('flex');
                    }
                });
            }

            document.addEventListener('pointerdown', e => {
                const isInput = e.target.classList.contains('kb-input');
                const isKeyboard = e.target.closest('#customKeyboard');
                if (!isInput && !isKeyboard) {
                    closeKeyboard();
                }
            });

            renderKeyboard();
        });
    </script>

</body>

</html>