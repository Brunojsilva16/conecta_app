<?php

use App\Core\Auth;

// Definições de permissão para facilitar a leitura do código
$isLoggedIn = Auth::isLogged();
$userPlan = Auth::userPlan();
$courseCategory = $course['category'] ?? 'essential'; // Categoria do curso

// Lógica de acesso
$hasDirectAccess = $userHasCourse || ($userPlan === 'premium' && in_array($courseCategory, ['essential', 'premium']));
$canBuyPlatinum = $isLoggedIn && $courseCategory === 'platinum';
$canBuyEssential = !$isLoggedIn && $courseCategory === 'essential';

?>

<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row -mx-4">

            <!-- Coluna Esquerda: Imagem e Detalhes -->
            <div class="lg:w-1/3 px-4">
                <!-- Imagem do Curso -->
                <?php
                $imageUrl = !empty($course['image_url'])
                    ? BASE_URL . htmlspecialchars($course['image_url'])
                    : 'https://placehold.co/600x400/9333EA/FFFFFF?text=Curso';
                ?>


                <div class="rounded-lg shadow-lg overflow-hidden mb-8">
                <img src="<?= $imageUrl ?>" alt="Capa do curso <?= htmlspecialchars($course['title']) ?>" class="w-full h-auto object-cover">
                </div>

                <!-- Detalhes do Curso -->
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-6 space-y-4">
                    <div class="flex items-center text-slate-700">
                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <strong>Carga Horária:</strong>
                        <span class="ml-2"><?= htmlspecialchars($course['workload'] ?? 'N/A') ?></span>
                    </div>
                    <div class="flex items-start text-slate-700">
                        <svg class="w-5 h-5 mr-3 text-slate-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <strong>Público-alvo:</strong>
                        <span class="ml-2"><?= htmlspecialchars($course['target_audience'] ?? 'N/A') ?></span>
                    </div>
                    <div class="flex items-center text-slate-700">
                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <strong>Formato:</strong>
                        <span class="ml-2"><?= htmlspecialchars($course['format'] ?? 'N/A') ?></span>
                    </div>
                    <div class="flex items-center text-slate-700">
                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <strong>Nível:</strong>
                        <span class="ml-2"><?= htmlspecialchars($course['level'] ?? 'N/A') ?></span>
                    </div>
                    <div class="flex items-center text-slate-700">
                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-1.414v.001M9 12h.01M15 12h.01M12 15h.01M12 9h.01M12 6v.01M15 18v.01M9 6v.01M6 12h.01M6 15h.01"></path>
                        </svg>
                        <strong>Modalidade:</strong>
                        <span class="ml-2"><?= htmlspecialchars($course['modality'] ?? 'N/A') ?></span>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita: Título, Descrição e Ação -->
            <div class="lg:w-2/3 px-4 mt-8 lg:mt-0">
                <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200 h-full flex flex-col">
                    <div class="flex justify-between items-start">
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight"><?= htmlspecialchars($course['title']) ?></h1>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full ml-4
                            <?= $courseCategory === 'platinum' ? 'bg-purple-100 text-purple-800' : '' ?>
                            <?= $courseCategory === 'premium' ? 'bg-indigo-100 text-indigo-800' : '' ?>
                            <?= $courseCategory === 'essential' ? 'bg-blue-100 text-blue-800' : '' ?>
                        "><?= ucfirst($courseCategory) ?></span>
                    </div>
                    <p class="mt-2 text-md text-gray-600">com <?= htmlspecialchars($course['instructor']) ?></p>

                    <div class="mt-6 border-t pt-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">Sobre o curso</h2>
                        <div class="text-gray-700 space-y-4 text-base leading-relaxed">
                            <?= nl2br(htmlspecialchars($course['description'])) ?>
                        </div>
                    </div>

                    <!-- Bloco de Ação (Compra/Acesso) -->
                    <div class="mt-auto pt-8">
                        <div class="bg-gray-50 p-6 rounded-lg border">
                            <?php if ($hasDirectAccess): ?>
                                <p class="text-center text-green-700 font-medium mb-4">Você já tem acesso a este conteúdo.</p>
                                <a href="<?= BASE_URL ?>/dashboard" class="w-full flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                    Acessar Curso
                                </a>
                            <?php elseif ($canBuyPlatinum || $canBuyEssential): ?>
                                <p class="text-lg font-medium text-gray-600">Invista no seu conhecimento:</p>
                                <p class="text-4xl font-extrabold text-gray-900 mt-1">
                                    R$ <?= htmlspecialchars(number_format($course['price'], 2, ',', '.')) ?>
                                </p>
                                <form action="<?= BASE_URL ?>/curso/comprar/<?= $course['id'] ?>" method="POST" class="mt-6">
                                    <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700">
                                        Comprar Agora
                                    </button>
                                </form>
                            <?php else: // Usuário logado mas sem permissão (ex: essential tentando comprar premium) 
                            ?>
                                <p class="text-center text-amber-800 font-medium mb-4">Este curso não está disponível para compra avulsa no seu plano atual.</p>
                                <a href="<?= BASE_URL ?>/planos" class="w-full flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700">
                                    Ver Planos
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>