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

    private function handleImageUpload(): array
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => null];
        }

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => 'Erro no upload. Código: ' . $_FILES['image']['error']];
        }

        // Caminho de destino construído com a constante ROOT_PATH
        $uploadSubDir = 'assets' . DIRECTORY_SEPARATOR . 'img-courses';
        $uploadDir = ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $uploadSubDir;

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true)) {
            return ['path' => null, 'error' => "Falha ao criar o diretório de uploads: $uploadDir"];
        }

        if (!is_writable($uploadDir)) {
            return ['path' => null, 'error' => "O diretório de uploads não tem permissão de escrita: $uploadDir"];
        }
        
        $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $relativePath = '/' . str_replace(DIRECTORY_SEPARATOR, '/', $uploadSubDir . '/' . $fileName);
            return ['path' => $relativePath, 'error' => null];
        } else {
            return ['path' => null, 'error' => 'Falha ao mover o ficheiro. Verifique as permissões do servidor.'];
        }
    }

    // O resto dos métodos permanece igual à versão anterior, mas incluo aqui para garantir consistência.

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
        
        if ($courseModel->create($data)) {
            $_SESSION['success_message'] = 'Curso criado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao salvar o curso na base de dados.';
        }

        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
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
        
        if ($courseModel->update($id, $data)) {
            $_SESSION['success_message'] = 'Curso atualizado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao atualizar o curso na base de dados.';
        }

        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
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

    public function deleteCourse($id)
    {
        $courseModel = new CourseModel();
        
        $course = $courseModel->findById($id);
        if ($course && !empty($course['image_url'])) {
            $filePath = ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . $course['image_url'];
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

