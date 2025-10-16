<?php use App\Core\Auth; ?>

<!-- ATUALIZADO: Cabeçalho do Perfil -->
<div class="flex items-center mb-6 border-b border-gray-600 pb-4">
    <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center mr-4">
        <!-- Placeholder para a foto -->
        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
    </div>
    <div>
        <h2 class="text-lg font-bold truncate"><?= htmlspecialchars(Auth::userName() ?? 'Visitante') ?></h2>
        <a href="<?= BASE_URL ?>/perfil" class="text-sm text-indigo-400 hover:text-indigo-300">Ver Perfil</a>
    </div>
</div>


<h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Navegação</h3>
<nav>
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

