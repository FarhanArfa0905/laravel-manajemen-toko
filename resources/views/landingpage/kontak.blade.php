<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami - Ayra Cell</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <!-- NAVBAR (Sama dengan Landing Page) -->
    <nav class="glass-nav sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center space-x-2">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <span class="text-white font-bold text-xl">A</span>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-slate-800">Ayra<span class="text-indigo-600">Cell</span></span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-10">
                    <div class="flex space-x-8">
                        <a href="/" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Beranda</a>
                        <a href="/kontak" class="text-sm font-semibold text-indigo-600 transition">Kontak</a>
                    </div>
                    <div class="h-6 w-[1px] bg-slate-200"></div>
                    <a href="/login" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-slate-900 hover:bg-slate-800 shadow-xl shadow-slate-200 transition">
                        Login Kasir
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Hubungi Kami</h1>
                <p class="mt-4 text-slate-500 max-w-xl mx-auto">Punya pertanyaan seputar layanan kami atau ingin kerja sama? Tim Ayra Cell siap membantu Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                
                <!-- Info Kontak Kiri -->
                <div class="space-y-8">
                    <!-- WhatsApp Card -->
                    <div class="flex items-start p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mr-6 shrink-0">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217s.231.001.332.005c.108.004.254-.041.398.305.144.346.491 1.197.535 1.283.044.086.073.187.015.304-.058.117-.087.187-.174.289-.087.101-.182.226-.26.303-.094.094-.193.196-.083.385.11.19.488.804 1.053 1.307.729.646 1.342.846 1.529.933.187.086.297.072.405-.054.108-.127.462-.534.585-.715.123-.181.246-.151.412-.09.166.06.1.481 1.353 1.104.123.06.205.09.267.188.062.098.062.569-.082.974z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">WhatsApp CS</h3>
                            <p class="text-slate-500 text-sm mb-2">Fast Respon: Senin - Minggu (08:00 - 22:00)</p>
                            <a href="https://wa.me/6281376875853" class="text-indigo-600 font-bold hover:underline">+62 812-3456-789</a>
                        </div>
                    </div>

                    <!-- Location Card -->
                    <div class="flex items-start p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mr-6 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Lokasi Konter</h3>
                            <p class="text-slate-500 text-sm mb-2">Kunjungi outlet offline kami untuk tarik tunai atau service.</p>
                            <p class="text-slate-800 font-medium">Jl. Pratama, Perdamaian, Kec. Stabat, Kabupaten Langkat, Sumatera Utara 20811</p>
                        </div>
                    </div>

                    <!-- Instagram/Social Card -->
                    <div class="flex items-start p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                        <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center mr-6 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Media Sosial</h3>
                            <p class="text-slate-500 text-sm mb-2">Ikuti promo terbaru di Instagram kami.</p>
                            <a href="#" class="text-indigo-600 font-bold hover:underline">-</a>
                        </div>
                    </div>
                </div>

                <!-- Formulir Kanan -->
                {{-- <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-slate-200/50">
                    <form action="#" method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition" placeholder="Paijo Parman">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nomor WhatsApp</label>
                                <input type="text" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition" placeholder="0812...">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Subjek Kebutuhan</label>
                            <select class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition">
                                <option>Tanya Stok Voucher/Pulsa</option>
                                <option>Masalah Transaksi</option>
                                <option>Jasa Transfer Bank/E-Wallet</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pesan Anda</label>
                            <textarea rows="4" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition" placeholder="Tuliskan pesan atau kendala Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                            Kirim Pesan Sekarang
                        </button>
                    </form>
                </div> --}}
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-slate-200/50">
                    <form id="whatsappForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" id="nama" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition" placeholder="Paijo Daisuki">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nomor WhatsApp</label>
                                <input type="text" id="nomor_wa" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition" placeholder="0812...">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Subjek Kebutuhan</label>
                            <select id="subjek" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition">
                                <option value="Tanya Stok Voucher/Pulsa">Tanya Stok Voucher/Pulsa</option>
                                <option value="Masalah Transaksi">Masalah Transaksi</option>
                                <option value="Jasa Transfer Bank/E-Wallet">Jasa Transfer Bank/E-Wallet</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pesan Anda</label>
                            <textarea id="pesan" rows="4" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition" placeholder="Tuliskan pesan atau kendala Anda di sini..."></textarea>
                        </div>
                        <button type="button" onclick="sendToWhatsApp()" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                            Kirim via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-100 py-10">
        <div class="max-w-7xl mx-auto px-6 text-center text-xs text-slate-400">
            &copy; 2024 Ayra Cell. Terpercaya, Cepat, & Aman.
        </div>
    </footer>

    {{-- Script JS Form Kanan --}}
    <script>
        function sendToWhatsApp() {
            // 1. Ambil nomor tujuan konter (Ganti dengan nomor WA Ayra Cell kamu)
            const nomorTujuan = "6281376875853"; // Gunakan format 62, bukan 0

            // 2. Ambil nilai dari inputan form
            const nama = document.getElementById('nama').value;
            const nomorWaUser = document.getElementById('nomor_wa').value;
            const subjek = document.getElementById('subjek').value;
            const pesan = document.getElementById('pesan').value;

            // 3. Validasi sederhana
            if (nama === "" || nomorWaUser === "" || pesan === "") {
                alert("Harap isi semua kolom terlebih dahulu ya!");
                return;
            }

            // 4. Susun template pesan
            // %0A adalah kode untuk baris baru (Enter)
            const teksPesan = 
                `Halo Ayra Cell,%0A%0A` +
                `*Data Pengirim*%0A` +
                `- Nama: ${nama}%0A` +
                `- No. WA: ${nomorWaUser}%0A%0A` +
                `*Kebutuhan:*%0A` +
                `${subjek}%0A%0A` +
                `*Pesan:*%0A` +
                `${pesan}`;

            // 5. Arahkan ke URL WhatsApp
            const url = `https://wa.me/${nomorTujuan}?text=${teksPesan}`;

            // 6. Buka di tab baru
            window.open(url, '_blank');
        }
    </script>
</body>
</html>