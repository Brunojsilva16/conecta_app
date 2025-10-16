<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\UserModel;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function loginForm()
    {
        if (Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
        $this->render('login', ['title' => 'Acesse sua conta']);
    }

    public function login()
    {
        header('Content-Type: application/json');
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos.']);
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
            return;
        }

        // ATUALIZADO: Passa nome, perfil e plano para a função de login
        $userName = $user['name'] ?? 'Usuário';
        $userRole = $user['role'] ?? 'user';
        $userPlan = $user['subscription_plan'] ?? 'none';
        Auth::login((int) $user['id'], $userName, $userRole, $userPlan);
        
        echo json_encode([
            'success' => true,
            'message' => 'Login realizado com sucesso!',
            'redirect' => BASE_URL . '/dashboard'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}
