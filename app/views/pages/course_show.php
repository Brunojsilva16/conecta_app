<?php use App\Core\Auth; ?>

<div class="flex">
    <!-- Barra Lateral de Navegação (Apenas para usuários logados) -->
    <?php if (Auth::isLogged()): ?>
    <aside class="w-1/4 bg-gray-800 text-white p-6 rounded-lg mr-8">
        <?php require_once __DIR__ . '/../partials/course_sidebar.php'; ?>
    </aside>
    <?php endif; ?>

    <!-- Conteúdo Principal do Curso -->
    <div class="<?= Auth::isLogged() ? 'w-3/4' : 'w-full' ?>">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            
            <!-- Cabeçalho do Curso -->
            <div class="flex items-start mb-8">
                <img src="<?= !empty($course['image_url']) ? BASE_URL . htmlspecialchars($course['image_url']) : 'https://placehold.co/150x100' ?>" alt="<?= htmlspecialchars($course['title']) ?>" class="w-48 h-auto rounded-md object-cover mr-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($course['title']) ?></h1>
                    <p class="text-lg text-gray-600">com <?= htmlspecialchars($course['instructor']) ?></p>
                    <!-- NOVO: Badge da Categoria -->
                    <span class="mt-2 inline-block bg-indigo-100 text-indigo-800 text-sm font-semibold px-3 py-1 rounded-full capitalize">
                        <?= htmlspecialchars($course['category']) ?>
                    </span>
                </div>
            </div>

            <!-- Detalhes do Curso -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <!-- ... outros detalhes ... -->
                 <div>
                    <h3 class="font-semibold text-gray-700">Carga Horária:</h3>
                    <p><?= htmlspecialchars($course['workload'] ?? 'Não informado') ?></p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700">Nível:</h3>
                    <p><?= htmlspecialchars($course['level'] ?? 'Não informado') ?></p>
                </div>
                 <div>
                    <h3 class="font-semibold text-gray-700">Formato:</h3>
                    <p><?= htmlspecialchars($course['format'] ?? 'Não informado') ?></p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700">Modalidade:</h3>
                    <p><?= htmlspecialchars($course['modality'] ?? 'Não informado') ?></p>
                </div>
                <div class="col-span-2">
                    <h3 class="font-semibold text-gray-700">Público-alvo:</h3>
                    <p><?= htmlspecialchars($course['target_audience'] ?? 'Não informado') ?></p>
                </div>
            </div>

            <hr class="my-8">

            <!-- Descrição e Botão de Compra -->
            <div class="prose max-w-none text-gray-700">
                <?= nl2br(htmlspecialchars($course['description'])) ?>
            </div>
            
            <!-- ATUALIZADO: Lógica do Botão de Ação -->
            <div class="mt-8 pt-6 border-t">
                <?php
                    $userPlan = Auth::userPlan() ?? 'none';
                    $courseCategory = $course['category'];
                ?>
                
                <?php if ($userHasAccess): // Usuário já tem acesso (seja por plano ou compra) ?>
                    <a href="<?= BASE_URL ?>/dashboard" class="w-full block text-center bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition">Acessar Curso</a>
                
                <?php else: // Usuário NÃO tem acesso, vamos verificar as regras ?>

                    <?php if ($courseCategory === 'platinum'): ?>
                        <?php if ($userPlan === 'none'): ?>
                            <a href="<?= BASE_URL ?>/planos" class="w-full block text-center bg-red-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-red-700 transition">Exclusivo para Assinantes</a>
                        <?php else: // essential ou premium podem comprar platinum ?>
                            <form action="<?= BASE_URL ?>/curso/comprar/<?= $course['id'] ?>" method="POST">
                                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition">Comprar Curso Avulso (R$ <?= htmlspecialchars(number_format($course['price'], 2, ',', '.')) ?>)</button>
                            </form>
                        <?php endif; ?>

                    <?php elseif ($courseCategory === 'premium'): ?>
                         <?php if ($userPlan === 'none' || $userPlan === 'essential'): ?>
                            <a href="<?= BASE_URL ?>/planos" class="w-full block text-center bg-orange-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-orange-600 transition">Faça Upgrade para Acessar</a>
                        <?php endif; ?>

                    <?php elseif ($courseCategory === 'essential'): ?>
                         <?php if ($userPlan === 'none'): ?>
                            <form action="<?= BASE_URL ?>/curso/comprar/<?= $course['id'] ?>" method="POST">
                                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition">Comprar Curso Avulso (R$ <?= htmlspecialchars(number_format($course['price'], 2, ',', '.')) ?>)</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

