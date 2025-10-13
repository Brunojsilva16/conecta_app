<?php

use App\Core\Auth;
?>
<header class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div>
            <a href="<?= BASE_URL ?>/" class="text-2xl font-bold text-gray-800">
                <!-- Substitua por seu logo -->
                Plataforma
            </a>
        </div>
        <nav class="space-x-6 flex items-center">
            <!-- Link para a HOME (Cursos em geral) -->
            <a href="<?= BASE_URL ?>/" class="text-gray-600 hover:text-indigo-600">Cursos</a>
            <a href="<?= BASE_URL ?>/planos" class="text-gray-600 hover:text-indigo-600">Planos</a>
            
            <?php if (Auth::isLogged()): ?>
                <!-- Usuário Logado -->
                
                <!-- Link Meus Cursos (Dashboard) -->
                <a href="<?= BASE_URL ?>/dashboard" class="text-gray-600 hover:text-indigo-600 font-semibold">
                    Meus Cursos
                </a>

                <!-- Link Perfil (Novo) -->
                <a href="<?= BASE_URL ?>/perfil" class="text-gray-600 hover:text-indigo-600">
                    Perfil
                </a>
                
                <!-- Botão Sair -->
                <a href="<?= BASE_URL ?>/logout" class="bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300">
                    Sair
                </a>
            <?php else: ?>
                <!-- Usuário Deslogado -->
                <a href="<?= BASE_URL ?>/login" class="text-gray-600 hover:text-indigo-600">Acesse sua conta</a>
                <a href="#" class="bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">
                    Fale conosco
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>
