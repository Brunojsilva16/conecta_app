<?php

use App\Controllers\PageController;
use App\Controllers\CourseController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ProfileController;
use App\Controllers\AdminController;
use App\Controllers\ProgressController;

/**
 * --- ROTAS DE CURSOS ---
 */
$router->get('curso/{id}', [CourseController::class, 'show']);
$router->post('curso/comprar/{id}', [CourseController::class, 'purchase']);


/**
 * --- ROTAS PRINCIPAIS ---
 */
$router->get('', [CourseController::class, 'index']);
$router->get('home', [CourseController::class, 'index']);

/**
 * --- ROTAS DE AUTENTICAÇÃO ---
 */
$router->get('login', [AuthController::class, 'loginForm']);
$router->post('login', [AuthController::class, 'login']);   
$router->get('logout', [AuthController::class, 'logout']);

// ROTAS PARA ESQUECI A SENHA
$router->get('esqueci-a-senha', [AuthController::class, 'forgotPasswordForm']);
$router->post('esqueci-a-senha', [AuthController::class, 'sendPasswordResetLink']);
$router->post('resetar-senha', [AuthController::class, 'resetPassword']);


/**
 * --- ROTAS DO PAINEL DO ALUNO ---
 */
$router->get('dashboard', [DashboardController::class, 'index']);


/**
 * --- ROTAS DE PERFIL DO USUÁRIO ---
 */
$router->get('perfil', [ProfileController::class, 'index']);
$router->post('perfil/atualizar', [ProfileController::class, 'update']);


/**
 * --- ROTAS DE ADMINISTRAÇÃO DE CURSOS ---
 */
$router->get('admin/courses', [AdminController::class, 'listCourses']);
$router->get('admin/courses/create', [AdminController::class, 'createCourseForm']);
$router->post('admin/courses/create', [AdminController::class, 'createCourse']);
$router->get('admin/courses/edit/{id}', [AdminController::class, 'editCourseForm']);
$router->post('admin/courses/edit/{id}', [AdminController::class, 'updateCourse']);
$router->get('admin/courses/delete/{id}', [AdminController::class, 'deleteCourse']);


// Atualizar progresso do curso
$router->post('progress/update', [ProgressController::class, 'update']);


/**
 * --- ROTAS DE PÁGINAS ESTÁTICAS ---
 */
$router->get('planos', [PageController::class, 'plans']);

// Rota 404 de fallback
$router->get('{any}', [PageController::class, 'notFound']);

