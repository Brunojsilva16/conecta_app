<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\UserModel;
use App\Models\CourseModel;
use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = Auth::userId();
        $userPlan = Auth::userPlan();

        $userModel = new UserModel();
        $courseModel = new CourseModel();

        $user = $userModel->findById($userId);

        // ATUALIZADO: A lógica de busca de cursos agora é centralizada no Model,
        // garantindo que as regras de negócio sejam aplicadas corretamente.
        $userCoursesWithStatus = $courseModel->findCoursesForDashboard($userId, $userPlan);

        $this->render('dashboard', [
            'title' => 'Meus Cursos',
            'userName' => $user['name'] ?? 'Usuário',
            'userCourses' => $userCoursesWithStatus
        ]);
    }
}

