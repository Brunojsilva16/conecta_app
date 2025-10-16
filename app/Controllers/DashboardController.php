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
            // Premium vê cursos essential e premium
            $coursesData = $courseModel->findAllPublishedWithUserStatus($userId, ['essential', 'premium']);
        } else if ($userPlan === 'essential') {
            // Essential vê apenas cursos essential
            $coursesData = $courseModel->findAllPublishedWithUserStatus($userId, ['essential']);
        } else { // none
            // Usuário sem plano vê apenas os cursos que comprou
            $coursesData = $courseModel->findCoursesByUserId($userId);
        }

        // Verifica se o arquivo de imagem de cada curso existe no servidor
        $finalCoursesData = array_map(function ($course) {
            $defaultImageUrl = '/assets/img/default_course.svg';

            if (empty($course['image_url']) || !file_exists(ROOT_PATH . '/public' . $course['image_url'])) {
                $course['image_url'] = $defaultImageUrl;
            }

            return $course;
        }, $coursesData);


        $this->render('dashboard', [
            'title' => 'Meus Cursos',
            'userName' => $user['name'] ?? 'Usuário',
            'userCourses' => $finalCoursesData
        ]);
    }
}

