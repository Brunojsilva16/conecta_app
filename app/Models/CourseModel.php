<?php

namespace App\Models;

use App\Database\DataSource;

class CourseModel
{
    private DataSource $db;
    protected string $table = 'courses';

    public function __construct()
    {
        $this->db = DataSource::getInstance();
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

    public function findCoursesByUserId(int $userId): array
    {
        $sql = "
            SELECT 
                c.*
            FROM 
                courses c
            INNER JOIN 
                user_courses uc ON c.id = uc.course_id
            WHERE 
                uc.user_id = :userId 
            AND 
                c.status = 'published'
        ";
        return $this->db->select($sql, ['userId' => $userId]);
    }

    public function create(array $data): bool
    {
        // Garante que o preço seja null se estiver vazio, para evitar problemas com o tipo de dados no BD
        $data['price'] = !empty($data['price']) ? $data['price'] : null;

        $sql = "INSERT INTO {$this->table} (title, description, instructor, price, image_url, status) VALUES (:title, :description, :instructor, :price, :image_url, :status)";
        return $this->db->execute($sql, $data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        // Garante que o preço seja null se estiver vazio
        $data['price'] = !empty($data['price']) ? $data['price'] : null;

        $sql = "UPDATE {$this->table} SET title = :title, description = :description, instructor = :instructor, price = :price, image_url = :image_url, status = :status WHERE id = :id";
        return $this->db->execute($sql, $data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    public function getMockCourses(int $limit = 6): array
    {
        // ... (Este método pode ser removido se não for mais usado)
        return [];
    }
}

