<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\CourseModel;
use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function __construct()
    {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /**
     * Lida com o upload de uma imagem com validação e feedback de erro.
     * @return array ['path' => string|null, 'error' => string|null]
     */
    private function handleImageUpload(): array
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => null]; // Nenhum ficheiro enviado, não é um erro.
        }

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    return ['path' => null, 'error' => 'O ficheiro é demasiado grande.'];
                default:
                    return ['path' => null, 'error' => 'Ocorreu um erro inesperado durante o upload. Código: ' . $_FILES['image']['error']];
            }
        }
        
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array(mime_content_type($_FILES['image']['tmp_name']), $allowedMimes)) {
            return ['path' => null, 'error' => 'Tipo de ficheiro inválido. Apenas JPG, PNG, GIF, WEBP são permitidos.'];
        }

        $uploadSubDir = 'assets' . DIRECTORY_SEPARATOR . 'img-courses';
        $uploadDir = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $uploadSubDir;

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true)) {
            return ['path' => null, 'error' => 'Falha ao criar o diretório de uploads. Verifique as permissões.'];
        }

        if (!is_writable($uploadDir)) {
            return ['path' => null, 'error' => 'O diretório de uploads não tem permissão de escrita.'];
        }

        $fileName = uniqid() . '-' . preg_replace("/[^a-zA-Z0-9.\-_]/", "", basename($_FILES['image']['name']));
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $relativePath = '/' . str_replace(DIRECTORY_SEPARATOR, '/', $uploadSubDir . '/' . $fileName);
            return ['path' => $relativePath, 'error' => null];
        }

        return ['path' => null, 'error' => 'Falha ao mover o ficheiro carregado. Verifique as permissões do servidor.'];
    }


    public function listCourses()
    {
        $courseModel = new CourseModel();
        $courses = $courseModel->findAll();
        $this->render('admin/courses', ['title' => 'Gerenciar Cursos', 'courses' => $courses]);
    }

    public function createCourseForm()
    {
        $this->render('admin/course_form', [
            'title' => 'Adicionar Novo Curso',
            'action' => BASE_URL . '/admin/courses/create',
            'course' => null
        ]);
    }

    public function createCourse()
    {
        $uploadResult = $this->handleImageUpload();

        if ($uploadResult['error']) {
            $_SESSION['error_message'] = $uploadResult['error'];
            header('Location: ' . BASE_URL . '/admin/courses/create');
            exit;
        }

        $courseModel = new CourseModel();
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'instructor' => $_POST['instructor'],
            'price' => $_POST['price'],
            'image_url' => $uploadResult['path'],
            'status' => $_POST['status']
        ];
        $courseModel->create($data);

        $_SESSION['success_message'] = 'Curso criado com sucesso!';
        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
    }

    public function editCourseForm($id)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->findById($id);
        $this->render('admin/course_form', [
            'title' => 'Editar Curso',
            'action' => BASE_URL . '/admin/courses/edit/' . $id,
            'course' => $course
        ]);
    }

    public function updateCourse($id)
    {
        $uploadResult = $this->handleImageUpload();
        if ($uploadResult['error']) {
            $_SESSION['error_message'] = $uploadResult['error'];
            header('Location: ' . BASE_URL . '/admin/courses/edit/' . $id);
            exit;
        }

        $newImageUrl = $uploadResult['path'];
        $imageUrl = $newImageUrl ?? $_POST['current_image_url'] ?? null;

        $courseModel = new CourseModel();
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'instructor' => $_POST['instructor'],
            'price' => $_POST['price'],
            'image_url' => $imageUrl,
            'status' => $_POST['status']
        ];
        $courseModel->update($id, $data);

        $_SESSION['success_message'] = 'Curso atualizado com sucesso!';
        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
    }

    public function deleteCourse($id)
    {
        $courseModel = new CourseModel();
        
        // Opcional: Apagar o ficheiro de imagem antigo
        $course = $courseModel->findById($id);
        if ($course && !empty($course['image_url'])) {
            $filePath = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'public' . $course['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        $courseModel->delete($id);
        $_SESSION['success_message'] = 'Curso apagado com sucesso!';
        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
    }
}
