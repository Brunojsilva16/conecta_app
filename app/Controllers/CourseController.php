<?php

namespace App\Controllers;

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
        // Agora, os cursos são buscados diretamente do banco de dados
        $courses = $courseModel->findAllPublished();

        $this->render('home', [
            'title' => 'Nossos Cursos',
            'courses' => $courses
        ]);
    }
}
