# Buku Elektronik Tamu

## Instalasi Docker

1. Clone repository:

```bash
git clone <url-repo-ini>
cd buku-elektronik-tamu
```

2. Salin file environment:

```bash
cp .env.example .env
```

3. Pastikan konfigurasi database di `.env` menggunakan pengaturan berikut:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=buku_tamu
DB_USERNAME=laravel
DB_PASSWORD=secret
```

4. Jalankan Docker Compose:

```bash
docker compose up --build -d
```

5. Jalankan migrasi database:

```bash
docker compose exec app php artisan migrate
```

6. Jalankan seeder untuk membuat akun admin default:

```bash
docker compose exec app php artisan db:seed
```

Admin default akan dibuat dari nilai `ADMIN_NAME`, `ADMIN_EMAIL`, dan `ADMIN_PASSWORD` di file `.env`.

## Akses Aplikasi

Setelah container berjalan, buka aplikasi di:

- `http://127.0.0.1:8000`
- `http://127.0.0.1:8000/buku-tamu`
- `http://127.0.0.1:8000/login`
- `http://127.0.0.1:8000/dashboard`

## Catatan

- Docker Compose sudah menyediakan service `app` dan `db`.
- `app` akan menjalankan `php artisan serve --host=0.0.0.0 --port=8000`.
- Jika butuh melihat log, gunakan:

```bash
docker compose logs -f
```

- Untuk menghentikan dan menghapus container:

```bash
docker compose down
```

