<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Controllers\BaseController; // NOVO: Importa a classe BaseController

class CourseController extends BaseController
{
    /**
     * Exibe a página principal com a lista de cursos.
     */
    public function index()
    {
        $courseModel = new CourseModel();
        // Em um caso real, os dados viriam do banco: $courses = $courseModel->findAll();
        // Por enquanto, usaremos dados mocados para montar o layout.
        $courses = $courseModel->getMockCourses();

        $this->render('home', [
            'title' => 'Nossos Cursos',
            'courses' => $courses
        ]);
    }
}
