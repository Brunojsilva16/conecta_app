<?php

use App\Core\Auth;

$imageUrl = !empty($course['image_url'])
    ? BASE_URL . htmlspecialchars($course['image_url'])
    : BASE_URL . '/assets/img/default_course.png'; // Caminho para a imagem padrão
?>

<div class="bg-white p-8 rounded-lg shadow-xl max-w-6xl mx-auto">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Coluna Esquerda: Imagem e Detalhes -->
        <div class="lg:w-1/3">
            <?php
            $imageUrl = !empty($course['image_url'])
                ? BASE_URL . htmlspecialchars($course['image_url'])
                : BASE_URL . '/assets/img/default_course.svg'; // Caminho para a imagem padrão
            ?>
            <img src="<?= $imageUrl ?>" alt="Capa do curso <?= htmlspecialchars($course['title']) ?>"
                class="w-full rounded-lg shadow-md object-cover aspect-video">

            <div class="mt-6 space-y-3 text-sm">
                <p class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <strong>Carga Horária:</strong><span class="ml-2"><?= htmlspecialchars($course['workload'] ?? 'N/D') ?></span>
                </p>
                <p class="flex items-start text-gray-700">
                    <svg class="w-5 h-5 mr-2 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <strong>Público-alvo:</strong><span class="ml-2"><?= htmlspecialchars($course['target_audience'] ?? 'N/D') ?></span>
                </p>
                <p class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <strong>Formato:</strong><span class="ml-2"><?= htmlspecialchars($course['format'] ?? 'N/D') ?></span>
                </p>
                <p class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <strong>Nível:</strong><span class="ml-2"><?= htmlspecialchars($course['level'] ?? 'N/D') ?></span>
                </p>
                <p class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M12 6v.01M12 12v.01M12 18v.01"></path>
                    </svg>
                    <strong>Modalidade:</strong><span class="ml-2"><?= htmlspecialchars($course['modality'] ?? 'N/D') ?></span>
                </p>
            </div>
        </div>

        <!-- Coluna Direita: Título, Descrição e Ação -->
        <div class="lg:w-2/3 flex flex-col">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight"><?= htmlspecialchars($course['title']) ?></h1>
                    <p class="mt-1 text-md text-gray-600">com <?= htmlspecialchars($course['instructor']) ?></p>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full category-tag-<?= strtolower($course['category'] ?? '') ?>">
                    <?= htmlspecialchars(ucfirst($course['category'] ?? '')) ?>
                </span>
            </div>

            <div class="mt-6 text-gray-700 space-y-4 text-base border-t pt-4">
                <h2 class="text-xl font-semibold text-gray-800">Sobre o curso</h2>
                <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
            </div>

            <!-- Caixa de Ação (Comprar/Acessar) -->
            <div class="mt-auto pt-8">
                <div class="bg-gray-50 p-6 rounded-lg border">
                    <?php if (Auth::isLogged()): ?>
                        <?php if ($userHasCourse): ?>
                            <p class="text-center text-green-700 mb-4 font-semibold">Você já tem acesso a este conteúdo.</p>
                            <a href="<?= BASE_URL ?>/dashboard" class="block w-full text-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                Acessar Curso
                            </a>
                        <?php elseif ($userPlan !== 'none' && in_array($course['category'], ['essential', 'premium']) && $course['category'] === $userPlan): ?>
                            <p class="text-center text-blue-700 mb-4 font-semibold">Este curso está incluso no seu plano <?= ucfirst($userPlan) ?>.</p>
                            <a href="<?= BASE_URL ?>/dashboard" class="block w-full text-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Acessar Curso
                            </a>
                        <?php else: ?>
                            <p class="text-xl font-medium text-gray-600">Invista no seu conhecimento:</p>
                            <p class="text-4xl font-extrabold text-gray-900 mt-1">
                                R$ <?= htmlspecialchars(number_format($course['price'] ?? 0, 2, ',', '.')) ?>
                            </p>
                            <form action="<?= BASE_URL ?>/curso/comprar/<?= $course['id'] ?>" method="POST" class="mt-4">
                                <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 text-base font-medium text-white hover:bg-indigo-700">
                                    Comprar Agora
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-xl font-medium text-gray-600">Invista no seu conhecimento:</p>
                        <p class="text-4xl font-extrabold text-gray-900 mt-1">
                            R$ <?= htmlspecialchars(number_format($course['price'] ?? 0, 2, ',', '.')) ?>
                        </p>
                        <a href="<?= BASE_URL ?>/login" class="mt-4 block w-full text-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900">
                            Faça login para comprar
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>