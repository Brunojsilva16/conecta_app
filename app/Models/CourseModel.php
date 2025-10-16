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

    /**
     * Busca os cursos comprados por um utilizador específico.
     */
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

    /**
     * Busca todos os cursos publicados (filtrados por categoria) e o progresso do utilizador neles.
     */
    public function findAllPublishedWithUserStatus(int $userId, array $allowedCategories): array
    {
        if (empty($allowedCategories)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($allowedCategories), '?'));

        $sql = "
            SELECT
                c.*,
                COALESCE(uc.status, 'Em Andamento') as user_status
            FROM
                {$this->table} c
            LEFT JOIN
                {$this->pivotTable} uc ON c.id = uc.course_id AND uc.user_id = ?
            WHERE
                c.status = 'published' AND c.category IN ($placeholders)
        ";

        $params = array_merge([$userId], $allowedCategories);
        return $this->db->select($sql, $params);
    }

    /**
     * Atualiza ou insere o estado de um curso para um utilizador.
     */
    public function updateUserCourseStatus(int $userId, int $courseId, string $status): bool
    {
        $sqlCheck = "SELECT id FROM {$this->pivotTable} WHERE user_id = :userId AND course_id = :courseId";
        $existing = $this->db->selectOne($sqlCheck, ['userId' => $userId, 'courseId' => $courseId]);

        if ($existing) {
            $sqlUpdate = "UPDATE {$this->pivotTable} SET status = :status WHERE id = :id";
            return $this->db->execute($sqlUpdate, ['status' => $status, 'id' => $existing['id']]);
        } else {
            $sqlInsert = "INSERT INTO {$this->pivotTable} (user_id, course_id, status) VALUES (:userId, :courseId, :status)";
            return $this->db->execute($sqlInsert, [
                'userId' => $userId,
                'courseId' => $courseId,
                'status' => $status
            ]);
        }
    }

    public function checkUserHasCourse(int $userId, int $courseId): bool
    {
        $sql = "SELECT id FROM {$this->pivotTable} WHERE user_id = :userId AND course_id = :courseId";
        $result = $this->db->selectOne($sql, ['userId' => $userId, 'courseId' => $courseId]);
        return !empty($result);
    }

    public function grantCourseAccess(int $userId, int $courseId): bool
    {
        if ($this->checkUserHasCourse($userId, $courseId)) {
            return true; // Utilizador já tem acesso
        }
        $sql = "INSERT INTO {$this->pivotTable} (user_id, course_id, status) VALUES (:userId, :courseId, 'Em Andamento')";
        return $this->db->execute($sql, ['userId' => $userId, 'courseId' => $courseId]);
    }

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
        $sql = "INSERT INTO {$this->table} (title, description, instructor, price, image_url, status, workload, target_audience, format, level, modality, category) VALUES (:title, :description, :instructor, :price, :image_url, :status, :workload, :target_audience, :format, :level, :modality, :category)";
        return $this->db->execute($sql, $data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $data['price'] = !empty($data['price']) ? $data['price'] : null;
        $sql = "UPDATE {$this->table} SET title = :title, description = :description, instructor = :instructor, price = :price, image_url = :image_url, status = :status, workload = :workload, target_audience = :target_audience, format = :format, level = :level, modality = :modality, category = :category WHERE id = :id";
        return $this->db->execute($sql, $data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }
}
