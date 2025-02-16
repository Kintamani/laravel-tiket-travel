<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Cara Menjalankan Aplikasi

### Instalasi
- Clone repositori ini
- Buka terminal dan masuk ke direktori aplikasi
- Jalankan perintah berikut
```bash
composer install
```

### Konfigurasi
- Buka file `.env` dan ubah isi dengan informasi yang dibutuhkan
```bash
cp .env.example .env
```

### Migrasi Database
- Jalankan perintah berikut
```bash
php artisan migrate:fresh --seed
```

### Menjalankan Aplikasi
- Jalankan perintah berikut
```bash
php artisan serve
```
- Buka browser dan masuk ke alamat `http://localhost:8000`

### Auth
Role : admin
```bash
username : admin@mail.com
password : admin    
```

![admin](demo-admin.mov)

Role : penumpang
```bash
username : penumpang@mail.com
password : penumpang
```
![penumpang](demo-penumpang.mov)
