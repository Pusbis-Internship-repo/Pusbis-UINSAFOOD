
![Logo](/public/frontend/images/logo_uinsa_food.png)
# UINSA Food

Sebuah web aplikasi online food yang dikembangkan oleh Pusat Bisnis Universitas Islam Negeri Sunan Ampel Surabaya.

## Features

- Cross platform
- CRUD for admin & seller
- Checkout menu
- Rating & Review

## Instalasi

Clone project ini

```bash
  git clone https://github.com/Pusbis-Internship/UINSA-FOOD.git
```

Start web server (xampp/laragon/dsb). Jika menggunakan Laragon, 
copy direktori project ke dalam folder 'www'.

Buka localhost dan buat database baru dengan nama 'food' (bebas).

Buka project
```bash
  cd my-project
  code .
```
Rename file .env.example. menjadi .env dan rubah DB_DATABASE menjadi 'food' (sesuai nama database yang di-create).

Jalankan file seeder
```bash
  php artisan migrate:fresh --seed
```

Jalankan project
```bash
  php artisan serve
```

