## Software yang dibutuhkan

1. [XAMPP](https://www.apachefriends.org/download.html) atau [Laragon](https://laragon.org/download/)
2. [Git](https://git-scm.com/downloads) 
3. [Composer](https://getcomposer.org/download/)
4. [Laravel 10](https://laravel.com/docs/8.x/installation)
5. [NodeJS](https://nodejs.org/en/download/)

## Langkah-langkah instalasi

```bash
  git clone -v https://github.com/SemmiDev/sdn-167-pku.git sdn-167-pku
  or
  Download zip file
```

```bash
  cd sdn-167-pku
```

```bash
  composer install
```

```bash
  npm install && npm run dev
```

```bash
  cp .env.example .env
```

```bash
  php artisan key:generate
```

```bash
  php artisan migrate
```

```bash
  php artisan db:seed
```

```bash
  php artisan serve
```
