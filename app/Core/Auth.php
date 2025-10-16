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

    /**
     * NOVO: Retorna o nome do utilizador logado.
     * @return string|null
     */
    public static function userName(): ?string
    {
        return $_SESSION['usuario_nome'] ?? null;
    }

    /**
     * Retorna o perfil do utilizador ('admin' ou 'user').
     * @return string|null
     */
    public static function userRole(): ?string
    {
        return $_SESSION['usuario_role'] ?? null;
    }

    /**
     * Retorna o plano de subscrição do utilizador ('premium', 'essential', 'none').
     * @return string|null
     */
    public static function userPlan(): ?string
    {
        return $_SESSION['usuario_plano'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::isLogged() && self::userRole() === 'admin';
    }

    /**
     * ATUALIZADO: Inicia a sessão guardando ID, nome, perfil e plano.
     * @param int $id
     * @param string $name
     * @param string $role
     * @param string $plan
     */
    public static function login(int $id, string $name, string $role, string $plan): void
    {
        session_regenerate_id(true); 
        
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_nome'] = $name;
        $_SESSION['usuario_role'] = $role;
        $_SESSION['usuario_plano'] = $plan;
    }

    public static function logout(): void
    {
        session_unset();
        session_destroy();
    }
}
