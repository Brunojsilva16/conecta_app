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
        $userType = Auth::userType(); // Pega o tipo de usuário da sessão
        
        $userModel = new UserModel();
        $courseModel = new CourseModel();

        // 2. Buscar Dados do Usuário
        $user = $userModel->findById($userId); 
        
        // 3. Buscar Cursos do Usuário
        if ($userType === 'premium') {
            // Se o usuário for premium, busca todos os cursos
            $userCourses = $courseModel->findAllPublished();
        } else {
            // Caso contrário, busca apenas os cursos do usuário
            $userCourses = $courseModel->findCoursesByUserId($userId);
        }

        // 4. Renderizar a view correta, que é 'course-user'
        $this->render('course-user', [
            'title' => 'Meus Cursos',
            'userName' => $user['name'],
            'userCourses' => $userCourses
        ]);
    }
}