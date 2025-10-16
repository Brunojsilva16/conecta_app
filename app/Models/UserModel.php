<?php

namespace App\Models;

use App\Database\DataSource;

class UserModel
{
    private DataSource $db;
    protected string $table = 'users_app';

    public function __construct()
    {
        // O DataSource é obtido via Singleton
        $this->db = DataSource::getInstance();
    }

    /**
     * Busca um usuário pelo email.
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        return $this->db->selectOne($sql, ['email' => $email]); //
    }

    /**
     * Busca um usuário pelo ID.
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    /**
     * Atualiza o token de redefinição de senha de um usuário.
     * * @param int $userId O ID do usuário.
     * @param string|null $token O token gerado (ou null para limpar).
     * @param string|null $expires A data de expiração (ou null para limpar).
     * @return bool
     */
    public function updatePasswordResetToken(int $userId, ?string $token, ?string $expires): bool
    {
        $sql = "UPDATE {$this->table} SET password_reset_token = :token, password_reset_expires = :expires WHERE id = :id";
        return $this->db->execute($sql, [ //
            'token' => $token,
            'expires' => $expires,
            'id' => $userId
        ]);
    }
    
    /**
     * Atualiza o nome e o CPF (e outros dados não sensíveis) do usuário.
     * * @param int $userId ID do usuário
     * @param array $data Array associativo contendo 'name' e 'cpf'.
     * @return bool
     */
    public function updateProfile(int $userId, array $data): bool
    {
        // Campos permitidos para atualização
        $allowedFields = ['name', 'cpf'];
        $updateParts = [];
        $params = ['id' => $userId];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updateParts[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
        }

        if (empty($updateParts)) {
            // Nenhum campo válido fornecido para atualização
            return false;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $updateParts) . " WHERE id = :id";
        
        // Execute a query. Retorna true se a query for executada (mesmo que 0 linhas sejam alteradas)
        return $this->db->execute($sql, $params);
    }
}
