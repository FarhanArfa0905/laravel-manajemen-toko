<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## POS & Manajemen Penyimpanan Barang Berbasis Laravel

Sistem manajemen toko berbasis web yang dibangun menggunakan Laravel.
Project ini mencakup pengelolaan produk, stok barang, serta transaksi penjualan (Point of Sale).

- Authentication -> Login & Register (Breeze + Auth).
- Manajemen Product (CRUD).
- Barang Masuk (Page Penambahan Stok).
- Barang Keluar (Page Stok Keluar).
- Point of Sale (POS).
- Checkout  & Sistem Transaksi.
- Invoice.
- History Transaksi
- Catatan Barang Keluar
- Dashboard / Laporan Keuangan (Total Profit, Produk Terlaris, Chart, Total Modal, Total Profit, Filter Per minggu)

## Tech Stack

- Laravel 12.
- TailWind.
- Alpine Js.
- MySql
- Laravel Breeze

## Struktur Folder Project

- Product -> Manajemen Produk, (Create, Edit, Index, etc)
- Stock-ins -> Manajemen Barang Masuk
- Stock-outs -> Manajemen Barang Keluar
- POS -> Sistem Transaksi
- Dashboard -> Halaman Utama, Laporan Keuangan

## Getting Started / Installation

1. Clone Repository
   git clone https://github.com/FarhanArfa0905/laravel-manajemen-toko.git
   cd laravel-manajemen-toko
2. Install Dependency (Yang Dibutuhkan)
   composer Install
   npm Install
3. Setup Environment
   cp .env.example .env
   php artisan key:generate
4. Setup .env
5. Jalankan Migrasi
   php artisan migrate
6. Jalankan Server
   npm run dev -> Wajib
   php artisan serve (Misal menggunakan Laragon bisa langsung dibuka setelah start all)

## Business Logic / Logika Bisnis

1. Product -> digunakan untuk memasukkan barang baru, harga jual, harga modal, tidak termasuk jumlah stok.
2. Stock-ins / Stock-outs -> Semua barang masuk dan barang keluar melalui page ini serta melalui POS
3. Setiap transaksi menggunakan POS akan menghasilkan
   - Pengurangan setiap produk
   - Menghasilkan Invoice
   - Menghasilkan Catatan Transaksi Penjualan

## Pengembangan Lebih Lanjut

- Pagination
- Filter Kategori
- Dashboard
- Bug dan lain lain.

## Screenshot
1. Desktop
(screenshots/desktop.png)
2. Medium / Mobile
(screenshots/mobile.png)

## Author
Muammar Farhan

## Note
Project ini dibuat sebagai latihan sekaligus portofolio dalam membangun sebuah sistem POS berbasis Laravel.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
