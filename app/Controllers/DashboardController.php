<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\UserModel;
use App\Models\CourseModel;
use App\Controllers\BaseController; // NOVO: Importa a classe BaseController

class DashboardController extends BaseController
{

   /**
     * Exibe o painel do usuário, carregando os cursos.
     */
    public function index()
    {
        // 1. Verificar Autenticação (GARANTIA DE ACESSO)
        if (!Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = Auth::userId();
        
        $userModel = new UserModel();
        $courseModel = new CourseModel();

        // 2. Buscar Dados do Usuário
        // Em uma aplicação real, você buscaria o usuário pelo ID da sessão
        // Exemplo: $user = $userModel->findById($userId); 
        // Mocking para demonstração:
        $user = [
            'id' => $userId, 
            'name' => 'Bruno', // Nome mocado para demonstração
        ];
        
        // 3. Buscar Cursos do Usuário (Mocando dados)
        // Exemplo: $userCourses = $courseModel->findCoursesByUserId($userId);
        $userCourses = [
            [
                'id' => 1,
                'title' => 'Introdução ao Tailwind CSS',
                'instructor' => 'Prof. Maria',
                'status' => 'Finalizado',
                'progress' => 100
            ],
            [
                'id' => 2,
                'title' => 'Fundamentos de React (MVC)',
                'instructor' => 'Prof. João',
                'status' => 'Em Progresso',
                'progress' => 0
            ],
            [
                'id' => 3,
                'title' => 'PHP Moderno com Padrões de Projeto',
                'instructor' => 'Prof. Carlos',
                'status' => 'Em Progresso',
                'progress' => 45
            ]
        ];

        // 4. Renderizar a view correta, que é 'course-user'
        $this->render('course-user', [
            'title' => 'Meus Cursos',
            'userName' => $user['name'],
            'userCourses' => $userCourses
        ]);
    }
}
