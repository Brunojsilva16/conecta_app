<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Controllers\BaseController;
use App\Core\Auth; // NOVO: Importa a classe Auth

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
     * NOVO: Exibe os detalhes de um curso específico.
     */
    public function show($id)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->findById((int)$id);

        if (!$course) {
            // Se o curso não for encontrado, redireciona para a página 404
            header("Location: " . BASE_URL . "/404");
            exit;
        }

        $userHasCourse = false;
        $userPlan = 'none'; // Valor padrão

        if (Auth::isLogged()) {
            $userId = Auth::userId();
            $userPlan = Auth::userPlan() ?? 'none';
            $userHasCourse = $courseModel->checkUserHasCourse($userId, (int)$id);
        }

        $this->render('course_show', [
            'title' => $course['title'],
            'course' => $course,
            'userHasCourse' => $userHasCourse,
            'userPlan' => $userPlan
        ]);
    }

     /**
     * NOVO: Processa a "compra" de um curso.
     */
    public function purchase($courseId)
    {
        if (!Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = Auth::userId();
        $courseModel = new CourseModel();

        // Lógica para adicionar o curso ao usuário (simples)
        if ($courseModel->grantCourseAccess($userId, (int)$courseId)) {
            // Redireciona para o dashboard com mensagem de sucesso
             $_SESSION['success_message'] = 'Curso adquirido com sucesso!';
        } else {
             $_SESSION['error_message'] = 'Não foi possível adquirir o curso.';
        }
        
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
}

