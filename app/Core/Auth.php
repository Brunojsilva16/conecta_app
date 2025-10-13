<?php
namespace App\Core;

class Auth
{
    public static function isLogged(): bool
    {
        return !empty($_SESSION['usuario_id']);
    }

    public static function userId(): ?int
    {
        return $_SESSION['usuario_id'] ?? null;
    }

    public static function userType(): ?string
    {
        return $_SESSION['usuario_tipo'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::isLogged() && self::userType() === 'admin';
    }

    public static function login(int $id, string $tipo): void
    {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_tipo'] = $tipo;
    }

    public static function logout(): void
    {
        session_unset();
        session_destroy();
    }
}