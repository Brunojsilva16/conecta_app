<?php use App\Core\Auth; ?>

<!-- Barra lateral fixa com botão de sair no final -->
<aside class="w-64 bg-gray-800 text-white h-screen fixed top-0 left-0 z-50 flex flex-col p-4 hidden lg:flex">
    
    <!-- Cabeçalho do Perfil -->
    <div class="flex items-center mb-6 border-b border-gray-700 pb-4">
        <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
        </div>
        <div class="overflow-hidden">
            <h2 class="text-lg font-bold truncate"><?= htmlspecialchars(Auth::userName() ?? 'Visitante') ?></h2>
            <a href="<?= BASE_URL ?>/perfil" class="text-sm text-indigo-400 hover:text-indigo-300">Ver Perfil</a>
        </div>
    </div>

    <!-- Navegação (ocupa o espaço do meio)-->
    <nav class="flex-grow">
        <ul class="space-y-2">
            <li>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700 transition-colors">Sobre os cursos</a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/" class="block py-2 px-3 rounded hover:bg-gray-700 transition-colors">Cursos</a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/dashboard" class="block py-2 px-3 rounded hover:bg-gray-700 transition-colors">Meus Cursos</a>
            </li>
            <li>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700 transition-colors">Certificados e histórico</a>
            </li>
        </ul>
    </nav>
    
    <!-- Botão Sair (no fundo) -->
    <div class="pt-4 mt-auto">
        <a href="<?= BASE_URL ?>/logout" class="flex items-center justify-center bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 w-full">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Sair</span>
        </a>
    </div>

</aside>

