<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

## Appointment API - Gestión de Citas Médicas

Appointment es una API desarrollada en Laravel 11 para la gestión eficiente de citas médicas. Este proyecto facilita la creación, actualización, visualización y cancelación de citas médicas, utilizando migraciones de datos para administrar la estructura de la base de datos.

## Características

- **Framework:** Laravel 11
- **Base de Datos:** MySQL
- **Autenticación:** Soporte para autenticación con tokens utilizando Laravel Sanctum o Passport.
- **Migraciones de Datos:** Administradas con las poderosas herramientas de migración de Laravel.
- **Estructura Escalable:** Sistema modular que facilita la extensión y mantenimiento.

## Requisitos del Sistema

- PHP >= 8.1
- Composer
- MySQL
- Extensiones PHP requeridas: `OpenSSL`, `PDO`, `Mbstring`, `Tokenizer`, `XML`, `Ctype`, `JSON`, `BCMath`, `Fileinfo`

## Instalación

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/tuusuario/appointment-api.git
   cd appointment-api
   composer install
   php artisan migrate
## Ejecucion de aplicacion
  php artisan serve

## Uso
**Endpoint:**
   ```bash
   Login de usuario POST http://127.0.0.1:8000/api/login
   Registro de usuarios POST http://127.0.0.1:8000/api/register

