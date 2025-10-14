<?php

namespace App\Models;

use App\Database\DataSource;

class CourseModel
{
    private DataSource $db;
    protected string $table = 'courses';
    protected string $pivotTable = 'user_courses';

    public function __construct()
    {
        $this->db = DataSource::getInstance();
    }

    public function findCoursesByUserId(int $userId): array
    {
        $sql = "
            SELECT 
                c.*,
                uc.status as user_status
            FROM 
                {$this->table} c
            INNER JOIN 
                {$this->pivotTable} uc ON c.id = uc.course_id
            WHERE 
                uc.user_id = :userId 
            AND 
                c.status = 'published'
        ";
        return $this->db->select($sql, ['userId' => $userId]);
    }

    public function findAllPublishedWithUserStatus(int $userId): array
    {
        $sql = "
            SELECT
                c.*,
                COALESCE(uc.status, 'Em Andamento') as user_status
            FROM
                {$this->table} c
            LEFT JOIN
                {$this->pivotTable} uc ON c.id = uc.course_id AND uc.user_id = :userId
            WHERE
                c.status = 'published'
        ";
        return $this->db->select($sql, ['userId' => $userId]);
    }
    
    /**
     * Atualiza o estado de um curso para um utilizador.
     * Se a relação não existir, ela é criada.
     */
    public function updateUserCourseStatus(int $userId, int $courseId, string $status): bool
    {
        // 1. Verifica se já existe um registo
        $sqlCheck = "SELECT id FROM {$this->pivotTable} WHERE user_id = :userId AND course_id = :courseId";
        $existing = $this->db->selectOne($sqlCheck, ['userId' => $userId, 'courseId' => $courseId]);

        if ($existing) {
            // 2. Se existe, atualiza
            $sqlUpdate = "UPDATE {$this->pivotTable} SET status = :status WHERE id = :id";
            return $this->db->execute($sqlUpdate, ['status' => $status, 'id' => $existing['id']]);
        } else {
            // 3. Se não existe, insere um novo registo
            $sqlInsert = "INSERT INTO {$this->pivotTable} (user_id, course_id, status) VALUES (:userId, :courseId, :status)";
            return $this->db->execute($sqlInsert, [
                'userId' => $userId,
                'courseId' => $courseId,
                'status' => $status
            ]);
        }
    }

    // --- MÉTODOS DE ADMINISTRAÇÃO (sem alterações) ---
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY title ASC";
        return $this->db->select($sql);
    }

    public function findAllPublished(): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'published'";
        return $this->db->select($sql);
    }

    public function create(array $data): bool
    {
        $data['price'] = !empty($data['price']) ? $data['price'] : null;
        $sql = "INSERT INTO {$this->table} (title, description, instructor, price, image_url, status) VALUES (:title, :description, :instructor, :price, :image_url, :status)";
        return $this->db->execute($sql, $data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $data['price'] = !empty($data['price']) ? $data['price'] : null;
        $sql = "UPDATE {$this->table} SET title = :title, description = :description, instructor = :instructor, price = :price, image_url = :image_url, status = :status WHERE id = :id";
        return $this->db->execute($sql, $data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }
}

