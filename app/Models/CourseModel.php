<?php

namespace App\Models;

use App\Database\DataSource;

class CourseModel
{
    private DataSource $db;
    protected string $table = 'courses';

    public function __construct()
    {
        // Conexão com o banco de dados via Singleton
        $this->db = DataSource::getInstance();
    }

    /**
     * Busca todos os cursos publicados para a página inicial.
     * @return array
     */
    public function findAllPublished(): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'published'";
        // Use selectOne se quiser apenas uma linha, mas select para a lista de cursos.
        return $this->db->select($sql);
    }

    /**
     * Busca os cursos que um usuário específico (logado) tem acesso,
     * baseando-se na tabela pivot user_courses.
     * @param int $userId O ID do usuário logado (da tabela users_app).
     * @return array
     */
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

    /**
     * Retorna uma lista de cursos mocados para fins de layout.
     * MANTIDO COMO FALLBACK, mas não será mais usado no controlador principal.
     */
    public function getMockCourses(int $limit = 6): array
    {
        // ... (Dados mocados originais) ...
        return [
            [
                'id' => 1,
                'title' => 'Manejo Clínico dos Transtornos de Ansiedade',
                'image_url' => 'https://placehold.co/400x225/6D28D9/FFFFFF?text=Curso+1',
                'price' => 'R$ 1.699,00',
                'type' => 'EAD',
                'status' => 'open'
            ],
            [
                'id' => 2,
                'title' => 'Workshop Manejo Clínico do TUS',
                'image_url' => 'https://placehold.co/400x225/6D28D9/FFFFFF?text=Curso+2',
                'price' => 'R$ 149,00',
                'type' => 'EAD',
                'status' => 'open'
            ],
            [
                'id' => 3,
                'title' => 'Avaliação Clínica e Diagnóstica',
                'image_url' => 'https://placehold.co/400x225/4C1D95/FFFFFF?text=Workshop',
                'price' => null,
                'type' => 'Workshop',
                'status' => 'sold_out'
            ],
            [
                'id' => 4,
                'title' => 'Intervenções Cognitivo-Comportamentais',
                'image_url' => 'https://placehold.co/400x225/4C1D95/FFFFFF?text=Workshop',
                'price' => null,
                'type' => 'Workshop Online',
                'status' => 'sold_out'
            ],
            [
                'id' => 5,
                'title' => 'Estratégias Psicoeducativas e de Relaxamento',
                'image_url' => 'https://placehold.co/400x225/6D28D9/FFFFFF?text=Lançamento',
                'price' => 'R$ 600,00',
                'type' => 'Lançamento',
                'status' => 'open'
            ],
             [
                'id' => 6,
                'title' => 'Casos clínicos e supervisão aplicada',
                'image_url' => 'https://placehold.co/400x225/6D28D9/FFFFFF?text=Curso+Online',
                'price' => null,
                'type' => 'Curso Online',
                'status' => 'sold_out'
            ],
        ];
    }
}
