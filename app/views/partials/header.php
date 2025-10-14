<?php

use App\Core\Auth;
?>
<header class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div>
            <a href="<?= BASE_URL ?>/" class="text-2xl font-bold text-gray-800">
                Plataforma
            </a>
        </div>
        <nav class="space-x-6 flex items-center">
            <a href="<?= BASE_URL ?>/" class="text-gray-600 hover:text-indigo-600">Cursos</a>
            <a href="<?= BASE_URL ?>/planos" class="text-gray-600 hover:text-indigo-600">Planos</a>
            
            <?php if (Auth::isLogged()): ?>
                
                <?php if (Auth::isAdmin()): ?>
                    <!-- Link do Admin (visível apenas para admins) -->
                    <a href="<?= BASE_URL ?>/admin/courses" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                        Admin Cursos
                    </a>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>/dashboard" class="text-gray-600 hover:text-indigo-600 font-semibold">
                    Meus Cursos
                </a>
                <a href="<?= BASE_URL ?>/perfil" class="text-gray-600 hover:text-indigo-600">
                    Perfil
                </a>
                
                <a href="<?= BASE_URL ?>/logout" class="bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300">
                    Sair
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/login" class="text-gray-600 hover:text-indigo-600">Acesse sua conta</a>
                <a href="#" class="bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">
                    Fale conosco
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>

