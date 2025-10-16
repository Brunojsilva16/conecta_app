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

        // Validação de erros de upload do PHP
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE   => 'O ficheiro excede a diretiva upload_max_filesize no php.ini.',
            UPLOAD_ERR_FORM_SIZE  => 'O ficheiro excede a diretiva MAX_FILE_SIZE especificada no formulário HTML.',
            UPLOAD_ERR_PARTIAL    => 'O upload do ficheiro foi feito parcialmente.',
            UPLOAD_ERR_NO_TMP_DIR => 'Falta uma pasta temporária.',
            UPLOAD_ERR_CANT_WRITE => 'Falha ao escrever o ficheiro no disco.',
            UPLOAD_ERR_EXTENSION  => 'Uma extensão do PHP interrompeu o upload do ficheiro.',
        ];

        $errorCode = $_FILES['image']['error'];
        if ($errorCode !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => $uploadErrors[$errorCode] ?? 'Erro desconhecido no upload. Código: ' . $errorCode];
        }

        // --- Lógica de diretório e permissões ---
        $uploadSubDir = 'assets' . DIRECTORY_SEPARATOR . 'img-courses';
        $uploadDir = ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $uploadSubDir;

        // Tenta criar o diretório se não existir
        if (!is_dir($uploadDir)) {
            // @-silencia o warning do mkdir caso falhe, pois vamos tratar o erro
            if (!@mkdir($uploadDir, 0777, true)) {
                $error = error_get_last();
                $errorMessage = $error ? $error['message'] : 'desconhecido';
                return ['path' => null, 'error' => "Falha ao criar o diretório de uploads ($uploadDir). Erro do sistema: $errorMessage"];
            }
        }

        $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

        // Movimentação do ficheiro com verificação de erro detalhada
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $relativePath = '/' . str_replace(DIRECTORY_SEPARATOR, '/', $uploadSubDir . '/' . $fileName);
            return ['path' => $relativePath, 'error' => null];
        } else {
            // Adiciona mais contexto ao erro
            $error = error_get_last();
            $errorMessage = $error ? $error['message'] : 'Verifique as permissões do servidor e o caminho do upload.';
            return ['path' => null, 'error' => "Falha crítica ao mover o ficheiro para ($targetPath). Erro do sistema: $errorMessage"];
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
