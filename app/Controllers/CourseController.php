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
     * Exibe a página de detalhes de um curso específico.
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
        if (Auth::isLogged()) {
            $userId = Auth::userId();
            $userHasCourse = $courseModel->checkUserHasCourse($userId, (int)$id);
        }

        $this->render('course_show', [
            'title' => $course['title'],
            'course' => $course,
            'userHasCourse' => $userHasCourse
        ]);
    }

    /**
     * Processa a "compra" de um curso avulso.
     */
    public function buy($id)
    {
        if (!Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = Auth::userId();
        $courseId = (int)$id;

        $courseModel = new CourseModel();
        
        // Concede acesso ao curso
        if ($courseModel->grantCourseAccess($userId, $courseId)) {
            $_SESSION['success_message'] = 'Compra realizada com sucesso! Você já pode acessar o curso.';
            header('Location: ' . BASE_URL . '/dashboard');
        } else {
            $_SESSION['error_message'] = 'Ocorreu um erro ao processar sua compra. Tente novamente.';
            header('Location: ' . BASE_URL . '/curso/' . $courseId);
        }
        exit;
    }
}

