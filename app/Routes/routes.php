<?php

use App\Controllers\PageController;
use App\Controllers\CourseController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ProfileController; // NOVO: Importa o controlador de Perfil
use App\Controllers\AdminController; // NOVO
use App\Controllers\ProgressController; // NOVO

/**
 * --- ROTAS PRINCIPAIS ---
 */
$router->get('', [CourseController::class, 'index']);
$router->get('home', [CourseController::class, 'index']);

/**
 * --- ROTAS DE AUTENTICAÇÃO ---
 */
$router->get('login', [AuthController::class, 'loginForm']); // Exibe o formulário
$router->post('login', [AuthController::class, 'login']);    // Processa o login (POST via AJAX)
$router->get('logout', [AuthController::class, 'logout']);

// ROTAS PARA ESQUECI A SENHA
$router->get('esqueci-a-senha', [AuthController::class, 'forgotPasswordForm']);
$router->post('esqueci-a-senha', [AuthController::class, 'sendPasswordResetLink']);
$router->post('resetar-senha', [AuthController::class, 'resetPassword']); // Rota de POST para redefinição (assumindo a existência)


/**
 * --- ROTAS DO PAINEL DO ALUNO ---
 */
// Meus Cursos (Dashboard)
$router->get('dashboard', [DashboardController::class, 'index']);


/**
 * --- ROTAS DE PERFIL DO USUÁRIO (NOVO) ---
 */
// Exibe o formulário de perfil
$router->get('perfil', [ProfileController::class, 'index']);
// Processa a atualização do formulário
$router->post('perfil/atualizar', [ProfileController::class, 'update']);


/**
 * --- ROTAS DE ADMINISTRAÇÃO DE CURSOS (NOVO) ---
 */
$router->get('admin/courses', [AdminController::class, 'listCourses']);
$router->get('admin/courses/create', [AdminController::class, 'createCourseForm']);
$router->post('admin/courses/create', [AdminController::class, 'createCourse']);
$router->get('admin/courses/edit/{id}', [AdminController::class, 'editCourseForm']);
$router->post('admin/courses/edit/{id}', [AdminController::class, 'updateCourse']);
$router->get('admin/courses/delete/{id}', [AdminController::class, 'deleteCourse']);


// Meus Cursos (Dashboard)
$router->get('dashboard', [DashboardController::class, 'index']);
// Atualizar progresso do curso (NOVO)
$router->post('progress/update', [ProgressController::class, 'update']);


/**
 * --- ROTAS DO PAINEL DO ALUNO ---
 */
// Meus Cursos (Dashboard)
$router->get('dashboard', [DashboardController::class, 'index']);
// Atualizar progresso do curso (NOVO)
$router->post('progress/update', [ProgressController::class, 'update']);

/**
 * --- ROTAS DE PÁGINAS ESTÁTICAS ---
 */
$router->get('planos', [PageController::class, 'plans']);

// Rota 404 de fallback (usando GET na última posição)
$router->get('{any}', [PageController::class, 'notFound']); 
