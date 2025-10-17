<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Controllers\BaseController;
use App\Core\Auth;

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
     * Exibe os detalhes de um curso específico.
     */
    public function show($id)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->findById((int)$id);

        if (!$course || $course['status'] !== 'published') {
            (new PageController())->notFound();
            return;
        }

        $userHasAccess = false;
        $userPlan = Auth::userPlan();
        $userId = Auth::userId();

        if ($userId) {
            // 1. Verifica se já comprou o curso
            $userHasCourse = $courseModel->checkUserHasCourse($userId, (int)$id);

            // 2. Verifica acesso via plano de assinatura
            $hasAccessByPlan = (
                ($userPlan === 'premium' && in_array($course['category'], ['essential', 'premium'])) ||
                ($userPlan === 'essential' && $course['category'] === 'essential')
            );

            if ($userHasCourse || $hasAccessByPlan) {
                $userHasAccess = true;
            }
        }


        $this->render('course_show', [
            'title' => $course['title'],
            'course' => $course,
            'userHasAccess' => $userHasAccess,
            'userPlan' => $userPlan
        ]);
    }

    /**
     * Processa a compra de um curso.
     */
    public function purchase($id)
    {
        if (!Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = Auth::userId();
        $courseModel = new CourseModel();
        $course = $courseModel->findById((int)$id);

        if (!$course) {
            // Lógica para curso não encontrado
            header('Location: ' . BASE_URL);
            exit;
        }

        // Adiciona o curso à tabela 'user_courses'
        $courseModel->grantCourseAccess($userId, (int)$id);

        // Redireciona para o dashboard ou para a página do curso com mensagem de sucesso
        $_SESSION['success_message'] = 'Compra realizada com sucesso! Você já pode acessar o curso.';
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
}
