## Instalasi Aplikasi Reservasi Event

1. Pastikan pengaturan di .env nama database yang akan dibuat atau tuliskan dengan nama "db_resevent" dan type database (misal mysql)
2. Buat database pada dengan nama "db_resevent" pada aplikasi database
3. Buka command pada VS Code atau yang lainnya, ketikkan:

    - php artisan migrate
    - Buat akun admin untuk pertama kali masuk aplikasi dengan cara:
      Ketikkan "php artisan tinker" pada cmd vs code atau lainnya lalu ketikkan:

    User::create([
    'name' => 'Admin',
    'username' => 'admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('admin123'),
    'role' => 'admin',
    ]);
    exit

4. Ketikkan "npm install" lalu "npm run dev" pada cmd dan buka tab cmd lainnya pada vs code atau lainnya lalu ketikkan "php artisan serve" untuk menjalankan server lokal laravel
5. Masuk aplikasi kemudian login dengan akun admin yang sebelumnya dibuat dengan tinker.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
