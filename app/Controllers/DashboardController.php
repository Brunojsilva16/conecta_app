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

        $coursesData = [];
        if ($userPlan === 'premium') {
            $coursesData = $courseModel->findAllPublished();
        } else {
            $coursesData = $courseModel->findCoursesByUserId($userId);
        }
        
        // Adiciona um status inicial para a interatividade no frontend
        $userCoursesWithStatus = array_map(function($course) {
            $course['user_status'] = 'Em Andamento'; // Status inicial
            return $course;
        }, $coursesData);


        $this->render('dashboard', [
            'title' => 'Meus Cursos',
            'userName' => $user['name'] ?? 'Usuário',
            'userCourses' => $userCoursesWithStatus 
        ]);
    }
}

