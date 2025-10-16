<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\CourseModel;
use App\Controllers\BaseController;

class CourseController extends BaseController
{
    /**
     * Exibe a página principal com a lista de cursos.
     */
    public function index()
    {
        $courseModel = new CourseModel();
        $courses = $courseModel->findAllPublished();

        $this->render('home', [
            'title' => 'Nossos Cursos',
            'courses' => $courses
        ]);
    }

    /**
     * ATUALIZADO: Exibe a página de detalhes com lógica de acesso.
     */
    public function show($id)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->findById((int)$id);

        if (!$course || $course['status'] !== 'published') {
            $this->render('404', ['title' => 'Página Não Encontrada']);
            return;
        }

        // Lógica de Acesso
        $userHasAccess = false;
        if (Auth::isLogged()) {
            $userId = Auth::userId();
            $userPlan = Auth::userPlan();
            $courseCategory = $course['category'];

            // Verifica se o usuário já possui o curso na tabela user_courses
            $userAlreadyOwns = $courseModel->checkUserHasCourse($userId, (int)$id);

            if ($userAlreadyOwns) {
                $userHasAccess = true;
            } else {
                // Regras de acesso por plano
                if ($userPlan === 'premium' && ($courseCategory === 'essential' || $courseCategory === 'premium')) {
                    $userHasAccess = true;
                }
                if ($userPlan === 'essential' && $courseCategory === 'essential') {
                    $userHasAccess = true;
                }
            }
        }

        $this->render('course_show', [
            'title' => $course['title'],
            'course' => $course,
            'userHasAccess' => $userHasAccess,
            'fullWidthLayout' => true
        ]);
    }

    /**
     * NOVO: Processa a compra de um curso.
     */
    public function purchase($id)
    {
        if (!Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = Auth::userId();
        $courseModel = new CourseModel();
        $success = $courseModel->grantCourseAccess($userId, (int)$id);

        if ($success) {
            $_SESSION['success_message'] = 'Curso adquirido com sucesso!';
            header('Location: ' . BASE_URL . '/dashboard');
        } else {
            $_SESSION['error_message'] = 'Não foi possível adquirir o curso. Tente novamente.';
            header('Location: ' . BASE_URL . '/curso/' . $id);
        }
        exit;
    }
}

