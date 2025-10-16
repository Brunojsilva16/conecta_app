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

    private function validateCourseData(array $postData): ?string
    {
        $requiredFields = [
            'title' => 'Título',
            'description' => 'Descrição',
            'instructor' => 'Instrutor',
            'workload' => 'Carga Horária',
            'target_audience' => 'Público-alvo',
            'format' => 'Formato',
            'level' => 'Nível',
            'modality' => 'Modalidade',
            'category' => 'Categoria',
            'status' => 'Status'
            // 'price' não é obrigatório, pois pode ser gratuito
        ];

        foreach ($requiredFields as $field => $fieldName) {
            if (empty(trim($postData[$field]))) {
                return "O campo '{$fieldName}' é obrigatório.";
            }
        }
        return null; // Sem erros
    }

    private function handleImageUpload(): array
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => null];
        }

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => 'Erro no upload. Código: ' . $_FILES['image']['error']];
        }

        $uploadSubDir = 'assets' . DIRECTORY_SEPARATOR . 'img-courses';
        $uploadDir = ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $uploadSubDir;

        if (!is_dir($uploadDir)) {
            if (!@mkdir($uploadDir, 0777, true)) {
                 $error = error_get_last();
                 return ['path' => null, 'error' => "Falha ao criar diretório: " . ($error['message'] ?? 'erro desconhecido')];
            }
        }

        $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            return ['path' => '/' . str_replace(DIRECTORY_SEPARATOR, '/', $uploadSubDir . '/' . $fileName), 'error' => null];
        } else {
            return ['path' => null, 'error' => 'Falha ao mover o ficheiro. Verifique as permissões do servidor.'];
        }
    }

    public function createCourse()
    {
        $validationError = $this->validateCourseData($_POST);
        if ($validationError) {
            $_SESSION['error_message'] = $validationError;
            // Salva os dados do post para repopular o formulário
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . BASE_URL . '/admin/courses/create');
            exit;
        }

        $uploadResult = $this->handleImageUpload();
        if ($uploadResult['error']) {
            $_SESSION['error_message'] = $uploadResult['error'];
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . BASE_URL . '/admin/courses/create');
            exit;
        }

        $courseModel = new CourseModel();
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'instructor' => $_POST['instructor'],
            'price' => empty($_POST['price']) ? 0.00 : $_POST['price'],
            'image_url' => $uploadResult['path'],
            'status' => $_POST['status'],
            'workload' => $_POST['workload'],
            'target_audience' => $_POST['target_audience'],
            'format' => $_POST['format'],
            'level' => $_POST['level'],
            'modality' => $_POST['modality'],
            'category' => $_POST['category'],
        ];

        if ($courseModel->create($data)) {
            $_SESSION['success_message'] = 'Curso criado com sucesso!';
            unset($_SESSION['form_data']);
        } else {
            $_SESSION['error_message'] = 'Erro ao salvar o curso no banco de dados.';
            $_SESSION['form_data'] = $_POST;
        }

        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
    }

    public function updateCourse($id)
    {
        $validationError = $this->validateCourseData($_POST);
        if ($validationError) {
            $_SESSION['error_message'] = $validationError;
            header('Location: ' . BASE_URL . '/admin/courses/edit/' . $id);
            exit;
        }

        $uploadResult = $this->handleImageUpload();
        if ($uploadResult['error']) {
            $_SESSION['error_message'] = $uploadResult['error'];
            header('Location: ' . BASE_URL . '/admin/courses/edit/' . $id);
            exit;
        }

        $imageUrl = $uploadResult['path'] ?? $_POST['current_image_url'] ?? null;

        $courseModel = new CourseModel();
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'instructor' => $_POST['instructor'],
            'price' => empty($_POST['price']) ? 0.00 : $_POST['price'],
            'image_url' => $imageUrl,
            'status' => $_POST['status'],
            'workload' => $_POST['workload'],
            'target_audience' => $_POST['target_audience'],
            'format' => $_POST['format'],
            'level' => $_POST['level'],
            'modality' => $_POST['modality'],
            'category' => $_POST['category'],
        ];

        if ($courseModel->update((int)$id, $data)) {
            $_SESSION['success_message'] = 'Curso atualizado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao atualizar o curso no banco de dados.';
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
        // Recupera dados do formulário da sessão, se houver, e depois limpa
        $courseData = $_SESSION['form_data'] ?? null;
        unset($_SESSION['form_data']);
        
        $this->render('admin/course_form', [
            'title' => 'Adicionar Novo Curso',
            'action' => BASE_URL . '/admin/courses/create',
            'course' => $courseData
        ]);
    }

    public function editCourseForm($id)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->findById((int)$id);
        if (!$course) {
            header("Location: " . BASE_URL . "/admin/courses");
            exit;
        }
        $this->render('admin/course_form', [
            'title' => 'Editar Curso',
            'action' => BASE_URL . '/admin/courses/edit/' . $id,
            'course' => $course
        ]);
    }

    public function deleteCourse($id)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->findById((int)$id);
        if ($course && !empty($course['image_url'])) {
            $filePath = ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . $course['image_url'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $courseModel->delete((int)$id);
        $_SESSION['success_message'] = 'Curso apagado com sucesso!';
        header('Location: ' . BASE_URL . '/admin/courses');
        exit;
    }
}

