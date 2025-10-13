<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\UserModel;
use App\Services\MailService; // Mantido, caso a funcionalidade de "Esqueci a Senha" esteja aqui

use App\Controllers\BaseController; // Importa a classe BaseController

class AuthController extends BaseController // Herda de BaseController
{
    /**
     * Exibe a página de login.
     * Mapeado para a rota GET /login.
     */
    public function loginForm()
    {
        // Se o usuário já estiver logado, redireciona para o painel
        if (Auth::isLogged()) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        // CORREÇÃO ESSENCIAL: Usa o método render herdado para aplicar o layout.php
        $this->render('login', ['title' => 'Acesse sua conta']);
    }

    /**
     * Processa o envio do formulário de login (via AJAX).
     * Mapeado para a rota POST /login.
     */
    public function login()
    {
        // Esta é a função que processa o POST do login e retorna JSON.
        // O código foi copiado da versão anterior que processava o login via AJAX (como na view login.php).
        
        header('Content-Type: application/json');

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $baseUrl = defined('BASE_URL') ? BASE_URL : '/';

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos.']);
            return;
        }

        $userModel = new UserModel();
        // Usando findByEmail (ajustado anteriormente)
        $user = $userModel->findByEmail($email);

        // Verifica a senha contra o hash armazenado em 'password_hash' (conforme database.sql)
        // OBS: Se a coluna no seu banco for 'password', ajuste a linha abaixo.
        $passwordColumn = $user['password_hash'] ?? $user['password'] ?? null; 

        if (!$user || !password_verify($password, $passwordColumn)) {
            echo json_encode(['success' => false, 'message' => 'Credenciais inválidas. Verifique seu email e senha.']);
            return;
        }

        // Sucesso
        // OBS: Usando 'subscription_plan' do database.sql para o tipo de usuário
        $userType = $user['role'] ?? 'user';
        Auth::login((int) $user['id'], $userType);
        
        echo json_encode([
            'success' => true,
            'message' => 'Login realizado com sucesso!',
            'redirect' => $baseUrl . '/dashboard'
        ]);
        return;
    }


    // Os métodos forgotPasswordForm, sendPasswordResetLink, e resetPassword devem ser mantidos aqui,
    // usando $this->render() para exibir views, caso existam.
    
    // Exemplo de como ficaria a função de logout usando BaseController
    /**
     * Realiza o logout do usuário.
     */
    public function logout()
    {
        Auth::logout();
        header('Location: ' . BASE_URL . '/'); // Redireciona para a home após o logout
        exit;
    }
}
