<?php

namespace App\Models;

use App\Database\DataSource;

class InterestModel
{
    private $db;

    public function __construct()
    {
        // Garante que a conexão com o banco de dados seja estabelecida
        $this->db = DataSource::getInstance();
    }

    /**
     * Salva o interesse de um usuário no banco de dados.
     *
     * @param string $name
     * @param string $email
     * @param string $courseTitle
     * @return bool Retorna true em caso de sucesso, false em caso de falha.
     */
    public function saveInterest(string $name, string $email, string $courseTitle): bool
    {
        $sql = "INSERT INTO users_app (name, email, course_title) VALUES (?, ?, ?)";
        try {
            return $this->db->execute($sql, [$name, $email, $courseTitle]);
        } catch (\Exception $e) {
            // Em um ambiente de produção, seria bom logar o erro: error_log($e->getMessage());
            return false;
        }
    }
}
